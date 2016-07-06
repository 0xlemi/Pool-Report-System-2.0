<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Supervisor;
use App\User;

use Validator;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PRS\Transformers\SupervisorTransformer;

class SupervisorsController extends ApiController
{

    private $supervisorTransformer;


    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(SupervisorTransformer $supervisorTransformer)
    {
        $this->supervisorTransformer = $supervisorTransformer;
        $this->middleware(['api', 'auth:api']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($this->getUser()->cannot('index', Supervisor::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $supervisors = $this->loggedUserAdministrator()->supervisors()->get();

        return $this->respond([
            'data' => $this->supervisorTransformer->transformCollection($supervisors),
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

        $validator = $this->validateSupervisorRequestCreate($request);

        if ($validator->fails()) {
            // return error responce
            return $this->setStatusCode(422)->RespondWithError('Paramenters failed validation.', $validator->errors()->toArray());
        }

        $admin = $this->loggedUserAdministrator();

        $supervisor = Supervisor::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'cellphone' => $request->cellphone,
            'address' => $request->address,
            'language' => $request->language,
            'comments' => $request->comments,
            'admin_id' => $admin->id,
        ]);
        $supervisor_id = $admin->supervisors(true)->first()->id;

        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            // add salt
            'api_token' => str_random(60),
            'userable_type' => 'App\Supervisor',
            'userable_id' => $supervisor_id,
        ]);

        if($supervisor){
            return $this->respondPersisted(
                'The supervisor was successfuly created.',
                $this->supervisorTransformer->transform($admin->supervisors(true)->first())
            );
        }

        return $this->respondInternalError();
    }

    /**
     * Display the specified resource.
     * tested
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($seq_id)
    {
        if($this->getUser()->cannot('show', Supervisor::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        try {
            $supervisor = $this->loggedUserAdministrator()->supervisorBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Supervisor with that id, does not exist.');
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $seq_id)
    {
        if($this->getUser()->cannot('edit', Supervisor::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        try{
            $supervisor = $this->loggedUserAdministrator()->supervisorBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Supervisor with that id, does not exist.');
        }

        $validator = $this->validateSupervisorRequestUpdate($request, $supervisor->user()->userable_id);

        if ($validator->fails()) {
            // return error responce
            return $this->setStatusCode(422)
                ->RespondWithError(
                    'Paramenters failed validation.',
                    $validator->errors()->toArray()
                );
        }


        $objects = $this->updateSupervisor($request, $supervisor);

        // $photo = true;
        // if($request->photo){
        //     $supervisor->images()->delete();
        //     $photo = $supervisor->addImageFromForm($request->file('photo'));
        // }

        if($objects['supervisor']->save() && $objects['user']->save()){
            return $this->respondPersisted(
                'The supervisor was successfully updated.',
                $this->supervisorTransformer->transform($this->loggedUserAdministrator()->supervisorBySeqId($seq_id))
            );
        }
        return $this->respondInternalError('The supervisor could not be updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($seq_id)
    {
        if($this->getUser()->cannot('destroy', Supervisor::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        try{
            $supervisor = $this->loggedUserAdministrator()->supervisorBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Supervisor with that id, does not exist.');
        }

        if($supervisor->delete()){
            return $this->respondWithSuccess('Supervisor was successfully deleted');
        }

        return $this->respondNotFound('Supervisor with that id, does not exist.');
    }

protected function validateSupervisorRequestCreate(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:25',
            'last_name' => 'required|string|max:40',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|alpha_dash|between:6,40',
            'cellphone' => 'required|string|max:20',
            'address'   => 'string|max:100',
            'language' => 'required|string|max:2',
            'photo' => 'mimes:jpg,jpeg,png',
            'comments' => 'string|max:1000',
        ]);
    }

    protected function validateSupervisorRequestUpdate(Request $request, $userable_id)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:25',
            'last_name' => 'required|string|max:40',
            'email' => 'required|email|unique:users,email,'.$userable_id.',userable_id',
            'password' => 'required|alpha_dash|between:6,40',
            'cellphone' => 'required|string|max:20',
            'address'   => 'string|max:100',
            'language' => 'required|string|max:2',
            'photo' => 'mimes:jpg,jpeg,png',
            'comments' => 'string|max:1000',
        ]);
    }

    protected function updateSupervisor(Request $request, Supervisor $supervisor)
    {

        if(isset($request->name)){ $supervisor->name = $request->name; }
        if(isset($request->last_name)){ $supervisor->last_name = $request->last_name; }
        if(isset($request->cellphone)){ $supervisor->cellphone = $request->cellphone; }
        if(isset($request->address)){ $supervisor->address = $request->address; }
        if(isset($request->language)){ $supervisor->language = $request->language; }
        if(isset($request->comments)){ $supervisor->comments = $request->comments; }

        $user = $supervisor->user();
        if(isset($request->email)){ $user->email = $request->email; }
        if(isset($request->password)){ $user->password = $request->password; }


        return array(
            'supervisor' => $supervisor,
            'user' => $user
        );
    }

}
