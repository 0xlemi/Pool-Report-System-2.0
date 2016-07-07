<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Technician;
use App\Supervisor;
use App\User;

use Validator;

use App\PRS\Transformers\TechnicianTransformer;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TechniciansController extends ApiController
{

    private $technicianTransformer;

    public function __construct(TechnicianTransformer $technicianTransformer)
    {
        $this->technicianTransformer = $technicianTransformer;
        $this->middleware(['api', 'auth:api']);
    }
    /**
     * Display a listing of the resource.
     * tested
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($this->getUser()->cannot('index', Technician::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $limit = ($request->limit)?: 5;
        $technicians = $this->loggedUserAdministrator()->technicians()->paginate($limit);

        return $this->respondWithPagination(
            $technicians,
            $this->technicianTransformer->transformCollection($technicians)
        );
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

        $validator = $this->validateTechnicianRequestCreate($request);

        if ($validator->fails()) {
            // return error responce
            return $this->setStatusCode(422)->RespondWithError('Paramenters failed validation.', $validator->errors()->toArray());
        }

        $admin = $this->loggedUserAdministrator();

        try {
            $supervisor_id = $admin->supervisorBySeqId($request->supervisor)->id;
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('There is no supervisor with that supervisor_id.');
        }

        $technician = Technician::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'cellphone' => $request->cellphone,
            'address' => $request->address,
            'language' => $request->language,
            'comments' => $request->comments,
            'supervisor_id' => $supervisor_id,
            'admin_id' => $admin->id,
        ]);
        $technician_id = $admin->technicians(true)->first()->id;

        $user = User::create([
            'email' => $request->username,
            'password' => bcrypt($request->password),
            'api_token' => str_random(60),
            'userable_type' => 'App\Technician',
            'userable_id' => $technician_id,
        ]);

        if($technician && $user){
            return $this->respondPersisted(
                'The technician was successfuly created.',
                $this->technicianTransformer->transform($admin->technicians(true)->first())
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
        if($this->getUser()->cannot('show', Technician::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        try {
            $technician = $this->loggedUserAdministrator()->technicianBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Technician with that id, does not exist.');
        }

        if($technician){
            return $this->respond([
                'data' => $this->technicianTransformer->transform($technician),
            ]);
        }

        return $this->respondNotFound('Technician with that id, does not exist.');
    }

    /**
     * Update the specified resource in storage.
     * tested
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $seq_id)
    {
        if($this->getUser()->cannot('edit', Technician::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        try {
            $technician = $this->loggedUserAdministrator()->technicianBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Technician with that id, does not exist.');
        }

        $validator = $this->validateTechnicianRequestUpdate($request, $technician->user()->userable_id);

        if ($validator->fails()) {
            // return error responce
            return $this->setStatusCode(422)
                ->RespondWithError(
                    'Paramenters failed validation.',
                    $validator->errors()->toArray()
                );
        }


        $objects = $this->updateTechnician($request, $technician);

        // $photo = true;
        // if($request->photo){
        //     $supervisor->images()->delete();
        //     $photo = $supervisor->addImageFromForm($request->file('photo'));
        // }

        if($objects['technician']->save() && $objects['user']->save()){
            return $this->respondPersisted(
                'The technician was successfully updated.',
                $this->technicianTransformer->transform($this->loggedUserAdministrator()->technicianBySeqId($seq_id))
            );
        }
        return $this->respondInternalError('The technician could not be updated.');
    }

    /**
     * Remove the specified resource from storage.
     * tested
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($seq_id)
    {
        if($this->getUser()->cannot('destroy', Technician::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        try {
            $technician = $this->loggedUserAdministrator()->technicianBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Technician with that id, does not exist.');
        }

        if($technician->delete()){
            return $this->respondWithSuccess('Technician was successfully deleted');
        }

        return $this->respondNotFound('Technician with that id, does not exist.');
    }

    protected function validateTechnicianRequestCreate(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:25',
            'last_name' => 'required|string|max:40',
            'supervisor' => 'required|integer|min:1',
            'username' => 'required|alpha_dash|between:4,25|unique:users,email',
            'password' => 'required|alpha_dash|between:6,40',
            'cellphone' => 'required|string|max:20',
            'address'   => 'string|max:100',
            'language' => 'required|string|max:2',
            'photo' => 'mimes:jpg,jpeg,png',
            'comments' => 'string|max:1000',
        ]);
    }

    protected function validateTechnicianRequestUpdate(Request $request, $userable_id)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:25',
            'last_name' => 'required|string|max:40',
            'supervisor' => 'required|integer|min:1',
            'username' => 'required|alpha_dash|between:4,25|unique:users,email,'.$userable_id.',userable_id',
            'password' => 'required|alpha_dash|between:6,40',
            'cellphone' => 'required|string|max:20',
            'address'   => 'string|max:100',
            'language' => 'required|string|max:2',
            'photo' => 'mimes:jpg,jpeg,png',
            'comments' => 'string|max:1000',
        ]);
    }


    protected function updateTechnician(Request $request, Technician $technician)
    {

        if(isset($request->name)){ $technician->name = $request->name; }
        if(isset($request->last_name)){ $technician->last_name = $request->last_name; }
        if(isset($request->cellphone)){ $technician->cellphone = $request->cellphone; }
        if(isset($request->address)){ $technician->address = $request->address; }
        if(isset($request->language)){ $technician->language = $request->language; }
        if(isset($request->comments)){ $technician->comments = $request->comments; }
        if(isset($request->supervisor)){
            try {
                $supervisor_id = $this->loggedUserAdministrator()
                    ->supervisorBySeqId($request->supervisor)->id;
                $technician->supervisor_id = $supervisor_id;
            }catch(ModelNotFoundException $e){
                return $this->respondNotFound('There is no supervisor with that supervisor_id.');
            }

          }

        $user = $technician->user();
        if(isset($request->username)){ $user->email = $request->username; }
        if(isset($request->password)){ $user->password = $request->password; }


        return array(
            'technician' => $technician,
            'user' => $user
        );
    }

}
