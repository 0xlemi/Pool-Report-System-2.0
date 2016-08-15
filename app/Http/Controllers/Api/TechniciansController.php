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

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TechniciansController extends ApiController
{

    private $technicianTransformer;

    public function __construct(TechnicianTransformer $technicianTransformer)
    {
        $this->technicianTransformer = $technicianTransformer;
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
        // check that the user has permission
        if($this->getUser()->cannot('create', Technician::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $admin = $this->loggedUserAdministrator();

        // Validation
            $this->validateTechnicianRequestCreate($request);
            try {
                $supervisor_id = $admin->supervisorBySeqId($request->supervisor)->id;
            }catch(ModelNotFoundException $e){
                return $this->respondNotFound('There is no supervisor with that supervisor_id.');
            }

        // ***** Persisting *****
        $transaction = DB::transaction(function () use($request, $admin, $supervisor_id) {

            // create Technician
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

            // Optional values
            if(isset($request->getReportsEmails)){ $technician->get_reports_emails = $request->getReportsEmails; }
            $technician->save();

            // create User
            $technician_id = $admin->technicians(true)->first()->id;
            $user = User::create([
                'email' => $request->username,
                'password' => bcrypt($request->password),
                'api_token' => str_random(60),
                'userable_type' => 'App\Technician',
                'userable_id' => $technician_id,
            ]);

            // add photo
            if($request->photo){
                $photo = $technician->addImageFromForm($request->file('photo'));
            }

        });

        return $this->respondPersisted(
            'The technician was successfuly created.',
            $this->technicianTransformer->transform($admin->technicians(true)->first())
        );
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($seq_id, $checkPermission = true)
    {
        if($checkPermission && $this->getUser()->cannot('show', Technician::class))
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
        // check that the user has permissions
        if($checkPermission && $this->getUser()->cannot('edit', Technician::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        // ***** Validation *****
            // checking seq_id
            try {
                $technician = $this->loggedUserAdministrator()->technicianBySeqId($seq_id);
            }catch(ModelNotFoundException $e){
                return $this->respondNotFound('Technician with that id, does not exist.');
            }
            // checking core attributes
            $this->validateTechnicianRequestUpdate(
                            $request,
                            $technician->user()->id
                        );
            // checking the supervisor_seqid and getting the real id
            try {
                $supervisor_id = $technician->supervisor_id;
                if(isset($request->supervisor)){
                    $supervisor_id = $this->loggedUserAdministrator()
                        ->supervisorBySeqId($request->supervisor)->id;
                }
            }catch(ModelNotFoundException $e){
                return $this->respondNotFound('There is no supervisor with that supervisor_id.');
            }

        // ***** Persisting *****
        $transaction = DB::transaction(function () use($request, $technician, $supervisor_id) {

            // update technician
            if(isset($request->name)){ $technician->name = $request->name; }
            if(isset($request->last_name)){ $technician->last_name = $request->last_name; }
            if(isset($request->cellphone)){ $technician->cellphone = $request->cellphone; }
            if(isset($request->address)){ $technician->address = $request->address; }
            if(isset($request->language)){ $technician->language = $request->language; }
            if(isset($request->getReportsEmails)){ $technician->get_reports_emails = $request->getReportsEmails; }
            if(isset($request->comments)){ $technician->comments = $request->comments; }
            if(isset($request->supervisor)){$technician->supervisor_id = $supervisor_id; }

            // update user
            $user = $technician->user();
            if(isset($request->username)){ $user->email = $request->username; }
            if(isset($request->password)){ $user->password = bcrypt($request->password); }

            // persist
            $technician->save();
            $user->save();

            // add photo
            if($request->photo){
                $technician->images()->delete();
                $photo = $technician->addImageFromForm($request->file('photo'));
            }
        });

        $message = 'The technician was successfully updated.';
        if($request->password){
            $message = 'The technician and its password were successfully updated.';
        }
        return $this->respondPersisted(
            $message,
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
        return $this->validate($request, [
            'name' => 'required|string|max:25',
            'last_name' => 'required|string|max:40',
            'supervisor' => 'required|integer|min:1',
            'username' => 'required|alpha_dash|between:4,25|unique:users,email',
            'password' => 'required|alpha_dash|between:6,40',
            'cellphone' => 'required|string|max:20',
            'address'   => 'string|max:100',
            'language' => 'required|string|max:2',
            'getReportsEmails' => 'boolean',
            'photo' => 'mimes:jpg,jpeg,png',
            'comments' => 'string|max:1000',
        ]);
    }

    protected function validateTechnicianRequestUpdate(Request $request, $id)
    {
        return $this->validate($request, [
            'name' => 'string|max:25',
            'last_name' => 'string|max:40',
            'supervisor' => 'integer|min:1',
            'username' => 'alpha_dash|between:4,25|unique:users,email,'.$id.',id',
            'password' => 'alpha_dash|between:6,40',
            'cellphone' => 'string|max:20',
            'address'   => 'max:100',
            'language' => 'string|max:2',
            'getReportsEmails' => 'boolean',
            'photo' => 'mimes:jpg,jpeg,png',
            'comments' => 'string|max:1000',
        ]);
    }

}
