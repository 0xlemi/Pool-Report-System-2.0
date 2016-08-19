<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\PRS\Transformers\ClientTransformer;

use App\Client;
use App\Service;
use App\User;

use Validator;
use DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Administrator;

class ClientsController extends ApiController
{

    protected $clientTransformer;

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(ClientTransformer $clientTransformer)
    {
        $this->clientTransformer = $clientTransformer;
    }

    /**
     * Display a listing of the resource.
     * tested
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($this->getUser()->cannot('index', Client::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $limit = ($request->limit)?: 5;
        $clients = $this->loggedUserAdministrator()->clients()->paginate($limit);

        return $this->respondWithPagination(
            $clients,
            $this->clientTransformer->transformCollection($clients)
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
        // Check if user has permission
        if($this->getUser()->cannot('create', Client::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        // validate the request
        $this->validateClientCreate($request);

        $admin = $this->loggedUserAdministrator();

        //Persist to database
        $transaction = DB::transaction(function () use($request, $admin) {

            // Create Client
                // Transform services_seq_id to service_id array and check
                // that the services with those id exist
            $service_ids = $this->getAddServicesIds($request->service_ids, $admin);
            $client = Client::create(
                    array_merge(
                        array_map('htmlentities', $request->all()),
                        [
                            'admin_id' => $admin->id,
                        ]
                    )
            );

            // Optional values
            if(isset($request->getReportsEmails)){ $client->get_reports_emails = $request->getReportsEmails; }
            $client->save();

            // Crete the User
            $client_id = $admin->clients(true)->first()->id;
            $user = User::create([
                'email' => htmlentities($request->email),
                'password' => bcrypt(str_random(20)),
                'api_token' => str_random(60),
                'userable_type' => 'App\Client',
                'userable_id' => $client_id,
            ]);

            // Add Photo to Client
            if($request->photo){
                $photo = $client->addImageFromForm($request->file('photo'));
            }

            $client->services()->attach($service_ids);

        });

        // throw a success message
        return $this->respondPersisted(
            'The client was successfuly created.',
            $this->clientTransformer->transform($admin->clients(true)->first())
        );

    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($seq_id)
    {
        if($this->getUser()->cannot('show', Client::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        try {
            $client = $this->loggedUserAdministrator()->clientsBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Client with that id, does not exist.');
        }

        if($client){
            return $this->respond([
                'data' => $this->clientTransformer->transform($client),
            ]);
        }

        return $this->respondNotFound('Client with that id, does not exist.');
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $seq_id)
    {
        // checks that the user has permission
        if($this->getUser()->cannot('edit', Client::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $admin = $this->loggedUserAdministrator();

        // ***** Validation *****
            // validation for the $seq_id
            try {
                $client = $this->loggedUserAdministrator()->clientsBySeqId($seq_id);
            }catch(ModelNotFoundException $e){
                return $this->respondNotFound('Client with that id, does not exist.');
            }
            // validate core values
            $this->validateClientUpdate($request, $client->user()->id);
            // get real ids, because we were sent seq_ids arrays
            $add_service_ids = $this->getAddServicesIds($request->add_service_ids, $admin, $client);
            $remove_service_ids = $this->getRemoveServicesIds($request->remove_service_ids, $admin);
        // end validation

        // ***** Persiting to the database *****
        $transaction = DB::transaction(function () use($request, $client, $add_service_ids, $remove_service_ids) {

            // set client values
            $client->fill(array_map('htmlentities', $request->except('admin_id')));
            
            if(isset($request->getReportsEmails)){ $client->get_reports_emails = $request->getReportsEmails; }

            // set user values
            $user = $client->user();
            if(isset($request->email)){ $user->email = htmlentities($request->email); }
            if(isset($request->password)){ $user->password = bcrypt($request->password); }

            // set photo
            if($request->photo){
                $client->images()->delete();
                $photo = $client->addImageFromForm($request->file('photo'));
            }

            // presint
            $client->save();
            $user->save();

            // attach or remove services from client based on service_ids arrays
            $client->services()->attach($add_service_ids);
            if(!empty($remove_service_ids)){
                $client->services()->detach($remove_service_ids);
            }

        });
        // end persistance

        // success message
        return $this->respondPersisted(
            'The client was successfully updated.',
            $this->clientTransformer->transform($this->loggedUserAdministrator()->clientsBySeqId($seq_id))
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
        if($this->getUser()->cannot('destroy', Client::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        try {
            $client = $this->loggedUserAdministrator()->clientsBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Client with that id, does not exist.');
        }

        if($client->delete()){
            return $this->respondWithSuccess('Client was successfully deleted');
        }

        return $this->respondNotFound('Client with that id, does not exist.');
    }


    protected function validateClientCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:25',
            'last_name' => 'required|string|max:40',
            'email' => 'required|email|unique:users,email',
            'cellphone' => 'required|string|max:20',
            'type' => 'required|numeric|between:1,2',
            'language' => 'required|string|max:2',
            'getReportsEmails' => 'boolean',
            'comments' => 'string|max:1000',
            'photo' => 'mimes:jpg,jpeg,png',
        ]);
    }

    protected function validateClientUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'string|max:25',
            'last_name' => 'string|max:40',
            'email' => 'email|unique:users,email,'.$id.',id',
            'cellphone' => 'string|max:20',
            'type' => 'numeric|between:1,2',
            'language' => 'string|max:2',
            'getReportsEmails' => 'boolean',
            'comments' => 'string|max:1000',
            'photo' => 'mimes:jpg,jpeg,png',
        ]);
    }


    // transform array of services seq_ids to array of service ids (primary key)
    /**
     * t
     * @param  array $services_seq_id   array of seq_id for the services
     * @param  App\Administrator $admin
     * @param  string $message        error message if a seq_id in array doen't exist
     * @param  App\Client $client         client in question
     * @return array                  array of id (primary key) coresponding to the services
     */
    public function getServicesIds($services_seq_id, $admin, $message, $client = null)
    {
        $service_ids = array();
        if(isset($services_seq_id)){
            foreach ($services_seq_id as $service_seq_id) {
                try{
                    // get the real id
                    $service_id = $admin->serviceBySeqId($service_seq_id)->id;
                    // check if client they sended a client
                    if(isset($client)){
                        // check that this service dosn't have a connection already with client in question
                        if(!$client->services()->get()->contains('id', $service_id)){
                            $service_ids[] = $service_id;
                        }
                    }else{
                        $service_ids[] = $service_id;
                    }
                }catch(ModelNotFoundException $e){
                    return $this->respondNotFound($message);
                }

            }
        }
        return $service_ids;
    }

    /**
     * get service_ids array where message error is for add_services_ids array
     * @param  array $add_service_seq_ids array of the seq_id for the services to be added
     * @param  \App\Administrator $admin
     * @param  \App\Client $client       client in question
     * @return array                       array of the id (primary key) for the services to be added
     */
    protected function getAddServicesIds($add_service_seq_ids, $admin, $client = null)
    {
        return $this->getServicesIds(
                $add_service_seq_ids,
                $admin,
                'Some services from the array add_service_ids, does not exist.',
                $client
            );
    }


    /**
     * get service_ids array where message error is for remove_service_ids array
     * @param  array $remove_service_seq_ids    array of the seq_id for the services to be removed
     * @param  \App\Administrator $admin
     * @return  array                       array of the id (primary key) for the services to be removed
     */
    protected function getRemoveServicesIds($remove_service_seq_ids, $admin)
    {
        return $this->getServicesIds(
                $remove_service_seq_ids,
                $admin,
                'Some services from the array remove_service_ids, does not exist.'
            );
    }


}
