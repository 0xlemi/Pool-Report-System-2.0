<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Supervisor;
use App\User;

use Validator;
use DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PRS\Transformers\SupervisorTransformer;
use App\PRS\Transformers\PreviewTransformers\SupervisorPreviewTransformer;
use App\Administrator;

class SupervisorsController extends ApiController
{

    private $supervisorTransformer;
    private $supervisorPreviewTransformer;


    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(SupervisorTransformer $supervisorTransformer,
                                SupervisorPreviewTransformer $supervisorPreviewTransformer)
    {
        $this->supervisorTransformer = $supervisorTransformer;
        $this->supervisorPreviewTransformer = $supervisorPreviewTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($this->getUser()->cannot('list', Supervisor::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request, [
            'preview' => 'boolean',
            'status' => 'boolean',
            // dont validate limit if preview is true
            'limit' => 'integer|between:1,25',
        ]);

        $admin = $this->loggedUserAdministrator();

        // make a preview transformation
        if($request->preview){
            return $this->indexPreview($request, $admin);
        }

        $limit = ($request->limit)?: 5;
        // Filter by status
        if($request->has('status')){
            $supervisors = $admin->supervisorsActive($request->status)->paginate($limit);
        }else{
            $supervisors = $admin->supervisorsInOrder()
                                ->paginate($limit);
        }

        return $this->respondWithPagination(
            $supervisors,
            $this->supervisorTransformer->transformCollection($supervisors)
        );

    }

    protected function indexPreview(Request $request, Administrator $admin)
    {

        if($request->has('status')){
            $supervisors = $admin->supervisorsActive($request->status)->get();
        }else{
            $supervisors = $admin->supervisorsInOrder()->get();
        }

        return $this->respond([
                'data' => $this->supervisorPreviewTransformer->transformCollection($supervisors)
            ]);
    }

    /**
     * Store a newly created resource in storage.
     * tested
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($this->getUser()->cannot('create', Supervisor::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request, [
            'name' => 'required|string|max:25',
            'last_name' => 'required|string|max:40',
            'email' => 'required|email|unique:users,email',
            'cellphone' => 'required|string|max:20',
            'address'   => 'string|max:100',
            'language' => 'required|string|max:2',
            'photo' => 'mimes:jpg,jpeg,png',
            'comments' => 'string|max:1000',
        ]);

        $admin = $this->loggedUserAdministrator();
        // check if the you can add new users
        if(!$admin->canAddObject()){
            return response("You ran out of your {$admin->free_objects} free users, to activate more users subscribe to Pro account.", 402);
        }

        // ***** Persiting *****
        $supervisor = DB::transaction(function () use($request, $admin) {

            $supervisor = $admin->supervisors()->create(array_map('htmlentities', $request->all()));

            $user = $supervisor->user()->create([
                'email' => htmlentities($request->email),
                'api_token' => str_random(60),
            ]);

            // add photo
            if($request->photo){
                $photo = $supervisor->addImageFromForm($request->file('photo'));
            }

            return $supervisor;
        });

        return $this->respondPersisted(
            'The supervisor was successfuly created.',
            $this->supervisorTransformer->transform(Supervisor::findOrFail($supervisor->id))
        );
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($seq_id)
    {
        try {
            $supervisor = $this->loggedUserAdministrator()->supervisorBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Supervisor with that id, does not exist.');
        }

        if($this->getUser()->cannot('view', $supervisor))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if($supervisor){
            return $this->respond([
                'data' => $this->supervisorTransformer->transform($supervisor),
            ]);
        }

        return $this->respondNotFound('Supervisor with that id, does not exist.');
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $seq_id)
    {
        $admin = $this->loggedUserAdministrator();
        try{
            $supervisor = $admin->supervisorBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Supervisor with that id, does not exist.');
        }

        if($this->getUser()->cannot('update', $supervisor))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request, [
            'name' => 'string|max:25',
            'last_name' => 'string|max:40',
            'email' => 'email|unique:users,email,'.$supervisor->user->id.',id',
            'cellphone' => 'string|max:20',
            'address'   => 'string|max:100',
            'language' => 'string|max:2',
            'photo' => 'mimes:jpg,jpeg,png',
            'comments' => 'string|max:1000',
        ]);

        $user = $supervisor->user;
        // Check that the admin has payed for this supervisor
        $status = ($request->status)? 1:0;
        if( ($status && ($status != $user->active)) && !$admin->canAddObject()){
            return response("You ran out of your {$admin->free_objects} free users, to activate more users subscribe to Pro account.", 402);
        }

        // ***** Persiting *****
        $transaction = DB::transaction(function () use($request, $supervisor, $user) {

            // update supervisor
            $supervisor->fill(array_map('htmlentities', $request->all()));

            // update the user
            if($request->has('email')){ $user->email = htmlentities($request->email); }
            if($request->has('status')){ $user->active = $request->status; }

            $supervisor->save();
            $user->save();

            // add photo
            if($request->photo){
                $supervisor->images()->delete();
                $photo = $supervisor->addImageFromForm($request->file('photo'));
            }
        });

        $message = 'The supervisor was successfully updated.';
        if($request->password){
            $message = 'The supervisor and its password were successfully updated.';
        }
        return $this->respondPersisted(
            $message,
            $this->supervisorTransformer->transform($this->loggedUserAdministrator()->supervisorBySeqId($seq_id))
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($seq_id)
    {
        try{
            $supervisor = $this->loggedUserAdministrator()->supervisorBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Supervisor with that id, does not exist.');
        }

        if($this->getUser()->cannot('delete', $supervisor))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if($supervisor->delete()){
            return $this->respondWithSuccess('Supervisor was successfully deleted');
        }

        return $this->respondNotFound('Supervisor with that id, does not exist.');
    }


}
