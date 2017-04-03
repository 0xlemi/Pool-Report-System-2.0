<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Technician;
use App\Supervisor;
use App\User;

use Validator;
use DB;

use App\PRS\Transformers\TechnicianTransformer;
use App\PRS\Transformers\PreviewTransformers\TechnicianPreviewTransformer;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\UserRoleCompany;
use App\Administrator;

class TechniciansController extends ApiController
{

    private $technicianTransformer;
    private $technicianPreviewTransformer;

    public function __construct(TechnicianTransformer $technicianTransformer,
                                TechnicianPreviewTransformer $technicianPreviewTransformer)
    {
        $this->technicianTransformer = $technicianTransformer;
        $this->technicianPreviewTransformer = $technicianPreviewTransformer;
    }
    /**
     * Display a listing of the resource.
     * tested
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($this->getUser()->cannot('list', [UserRoleCompany::class, 'tech']))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request, [
            'preview' => 'boolean',
            'active' => 'boolean',
            'limit' => 'integer|between:1,25',// dont validate limit if preview is true
        ]);

        $admin = $this->loggedUserAdministrator();

        // make a preview transformation
        if($request->preview){
            return $this->indexPreview($request, $admin);
        }

        $limit = ($request->limit)?: 5;
        if($request->has('active')){
            $technicians = $admin->techniciansActive($request->active)
                            ->paginate($limit);
        }else{
            $technicians = $admin->techniciansInOrder()
                            ->paginate($limit);
        }

        return $this->respondWithPagination(
            $technicians,
            $this->technicianTransformer->transformCollection($technicians)
        );
    }

    protected function indexPreview(Request $request, Administrator $admin)
    {
        if($request->has('active')){
            $technicians = $admin->techniciansActive($request->active)->get();
        }else{
            $technicians = $admin->techniciansInOrder()->get();
        }

        return $this->respond([
                'data' => $this->technicianPreviewTransformer->transformCollection($technicians)
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
        if($this->getUser()->cannot('create', Technician::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        // Validation
        $admin = $this->loggedUserAdministrator();
        $this->validate($request, [
            'name' => 'required|string|max:25',
            'last_name' => 'required|string|max:40',
            'cellphone' => 'required|string|max:20',
            'address'   => 'string|max:100',
            'language' => 'required|string|max:2',
            'photo' => 'mimes:jpg,jpeg,png',
            'comments' => 'string|max:1000',
            'username' => 'required|alpha_dash|between:4,25|unique:users,email',
            'supervisor' => 'required|integer|existsBasedOnCompany:supervisors,'.$admin->id,
        ]);

        // check if the you can add new users
        if(!$admin->canAddObject()){
            return response("You ran out of your {$admin->free_objects} free users, to activate more users subscribe to Pro account.", 402);
        }

        // ***** Persisting *****
        $technician = DB::transaction(function () use($request, $admin) {

            $supervisor = $admin->supervisorBySeqId($request->supervisor);

            // create Technician
            $technician = $supervisor->technicians()->create(
                array_map('htmlentities', $request->all())
            );

            // create User
            $technician->user()->create([
                'email' => htmlentities($request->username),
                'api_token' => str_random(60),
            ]);

            // add photo
            if($request->photo){
                $photo = $technician->addImageFromForm($request->file('photo'));
            }

            return $technician;
        });

        return $this->respondPersisted(
            'The technician was successfuly created.',
            $this->technicianTransformer->transform(Technician::findOrFail($technician->id))
        );
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($seq_id, $checkPermission = true)
    {
        try {
            $technician = $this->loggedUserAdministrator()->technicianBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Technician with that id, does not exist.');
        }

        // checkpermission toogle so i can use this no the user controller
        if($checkPermission && $this->getUser()->cannot('view', $technician))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if($technician){
            return $this->respond([
                // send the type so they can be deferiantable in the user controller show
                'type' => 'Technician',
                'data' => $this->technicianTransformer->transform($technician),
            ]);
        }

        return $this->respondNotFound('Technician with that id, does not exist.');
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $seq_id, $checkPermission = true)
    {
        $admin = $this->loggedUserAdministrator();
        try {
            $technician = $admin->technicianBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Technician with that id, does not exist.');
        }

        // checkpermission toogle so i can use this no the user controller
        if($checkPermission && $this->getUser()->cannot('update', $technician))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        // ***** Validation *****
        $this->validate($request, [
            'name' => 'string|max:25',
            'last_name' => 'string|max:40',
            'cellphone' => 'string|max:20',
            'address'   => 'max:100',
            'language' => 'string|max:2',
            'photo' => 'mimes:jpg,jpeg,png',
            'comments' => 'string|max:1000',
            'username' => 'alpha_dash|between:4,25|unique:users,email,'.$technician->user->id.',id',
            'active' =>  'boolean',
            'supervisor' => 'integer|existsBasedOnCompany:supervisors,'.$admin->id,
        ]);

        // Check that the admin has payed for this technician
        $user = $technician->user;
        $active = ($request->active)? 1:0;
        if( ($active && ($active != $user->activeUser->paid)) && !$admin->canAddObject()){
            return response("You ran out of your {$admin->free_objects} free users, to activate more users subscribe to Pro account.", 402);
        }

        // ***** Persisting *****
        $transaction = DB::transaction(function () use($request, $admin, $user, $technician) {

            // update technician
            $technician->fill(array_map('htmlentities', $request->all()));

            // update user
            if($request->has('username')){ $user->email = htmlentities($request->username); }
            if($request->has('active')){ $user->active = $request->active; }

            if($request->has('supervisor')){
                $technician->supervisor()->associate($admin->supervisorBySeqId($request->supervisor));
            }

            $technician->save();
            $user->save();

            // add photo
            if($request->photo){
                $supervisor->deleteImages();
                $photo = $technician->addImageFromForm($request->file('photo'));
            }
        });

        return $this->respondPersisted(
            'The technician was successfully updated.',
            $this->technicianTransformer->transform($this->loggedUserAdministrator()->technicianBySeqId($seq_id))
        );
    }

    /**
     * Remove the specified resource from storage.
     * tested
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($seq_id)
    {
        try {
            $technician = $this->loggedUserAdministrator()->technicianBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Technician with that id, does not exist.');
        }

        if($this->getUser()->cannot('delete', $technician))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if($technician->delete()){
            return $this->respondWithSuccess('Technician was successfully deleted');
        }

        return $this->respondNotFound('Technician with that id, does not exist.');
    }

}
