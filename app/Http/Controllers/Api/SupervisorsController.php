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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($this->getUser()->cannot('index', Supervisor::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $limit = ($request->limit)?: 5;
        $supervisors = $this->loggedUserAdministrator()->supervisors()->paginate($limit);

        return $this->respondWithPagination(
            $supervisors,
            $this->supervisorTransformer->transformCollection($supervisors)
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
        if($this->getUser()->cannot('create', Supervisor::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        // Validation
        $validator = $this->validateSupervisorRequestCreate($request);
        if ($validator->fails()) {
            // return error responce
            return $this->setStatusCode(422)->RespondWithError('Paramenters failed validation.', $validator->errors()->toArray());
        }

        $admin = $this->loggedUserAdministrator();

        // ***** Persiting *****
        $transaction = DB::transaction(function () use($request, $admin) {
            // create Supervisor
            $supervisor = Supervisor::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'cellphone' => $request->cellphone,
                'address' => $request->address,
                'language' => $request->language,
                'get_reports_emails' => $request->getReportsEmails,
                'comments' => $request->comments,
                'admin_id' => $admin->id,
            ]);

            // Optional values
            if(isset($request->getReportsEmails)){ $supervisor->get_reports_emails = $request->getReportsEmails; }
            $supervisor->save();

            // create User
            $supervisor_id = $admin->supervisors(true)->first()->id;
            $user = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'api_token' => str_random(60),
                'userable_type' => 'App\Supervisor',
                'userable_id' => $supervisor_id,
            ]);

            // add photo
            if($request->photo){
                $photo = $supervisor->addImageFromForm($request->file('photo'));
            }
        });

        return $this->respondPersisted(
            'The supervisor was successfuly created.',
            $this->supervisorTransformer->transform($admin->supervisors(true)->first())
        );
    }

    /**
     * Display the specified resource.
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $seq_id, $checkPermission = true)
    {
        // check that user has permission
        if($checkPermission && $this->getUser()->cannot('edit', Supervisor::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        // Validation
            // validate the $seq_id
            try{
                $supervisor = $this->loggedUserAdministrator()->supervisorBySeqId($seq_id);
            }catch(ModelNotFoundException $e){
                return $this->respondNotFound('Supervisor with that id, does not exist.');
            }
            // validate the core attributes
            $validator = $this->validateSupervisorRequestUpdate($request, $supervisor->user()->userable_id);
            if ($validator->fails()) {
                // return error responce
                return $this->setStatusCode(422)
                    ->RespondWithError(
                        'Paramenters failed validation.',
                        $validator->errors()->toArray()
                    );
            }


        // ***** Persiting *****
        $transaction = DB::transaction(function () use($request, $supervisor) {
            // update supervisor
            if(isset($request->name)){ $supervisor->name = $request->name; }
            if(isset($request->last_name)){ $supervisor->last_name = $request->last_name; }
            if(isset($request->cellphone)){ $supervisor->cellphone = $request->cellphone; }
            if(isset($request->address)){ $supervisor->address = $request->address; }
            if(isset($request->language)){ $supervisor->language = $request->language; }
            if(isset($request->getReportsEmails)){ $supervisor->get_reports_emails = $request->getReportsEmails; }
            if(isset($request->comments)){ $supervisor->comments = $request->comments; }

            // update the user
            $user = $supervisor->user();
            if(isset($request->email)){ $user->email = $request->email; }
            if(isset($request->password)){ $user->password = bcrypt($request->password); }

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
            'getReportsEmails' => 'boolean',
            'photo' => 'mimes:jpg,jpeg,png',
            'comments' => 'string|max:1000',
        ]);
    }

    protected function validateSupervisorRequestUpdate(Request $request, $userable_id)
    {
        return Validator::make($request->all(), [
            'name' => 'string|max:25',
            'last_name' => 'string|max:40',
            'email' => 'email|unique:users,email,'.$userable_id.',userable_id',
            'password' => 'alpha_dash|between:6,40',
            'cellphone' => 'string|max:20',
            'address'   => 'string|max:100',
            'language' => 'string|max:2',
            'getReportsEmails' => 'boolean',
            'photo' => 'mimes:jpg,jpeg,png',
            'comments' => 'string|max:1000',
        ]);
    }


}
