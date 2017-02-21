<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\PRS\Transformers\ClientTransformer;
use App\PRS\Transformers\PreviewTransformers\ClientPreviewTransformer;

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
    protected $clientPreviewTransformer;

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(ClientTransformer $clientTransformer, ClientPreviewTransformer $clientPreviewTransformer)
    {
        $this->clientTransformer = $clientTransformer;
        $this->clientPreviewTransformer = $clientPreviewTransformer;
    }

    /**
     * Display a listing of the resource.
     * tested
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($this->getUser()->cannot('list', Client::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request, [
            'limit' => 'integer|between:1,25'
        ]);

        $limit = ($request->limit)?: 5;
        $clients = $this->loggedUserAdministrator()->clientsInOrder()->paginate($limit);

        return $this->respondWithPagination(
            $clients,
            $this->clientPreviewTransformer->transformCollection($clients)
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

        $this->validate($request, [
            'name' => 'required|string|max:25',
            'last_name' => 'required|string|max:40',
            'email' => 'required|email|unique:users,email',
            'cellphone' => 'required|string|max:20',
            'type' => 'required|numeric|between:1,2',
            'language' => 'required|string|max:2',
            'comments' => 'string|max:1000',
            'add_services' => 'array',
            'add_services.*' => 'required|integer|exists:services,seq_id',
            'photo' => 'mimes:jpg,jpeg,png',
        ]);

        $admin = $this->loggedUserAdministrator();

        //Persist to database
        $transaction = DB::transaction(function () use($request, $admin) {

            // Create Client
                // Transform services_seq_id to service_id array and check
                // that the services with those id exist
            $client = Client::create(
                    array_merge(
                        array_map('htmlentities', $request->except('add_services')),
                        [
                            'admin_id' => $admin->id,
                        ]
                    )
            );

            if(isset($request->add_services)){ $client->setServices($request->add_services);}

            // Crete the User
            $client_id = $admin->clientsInOrder('desc')->first()->id;
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

        });

        // throw a success message
        return $this->respondPersisted(
            'The client was successfuly created.',
            $this->clientTransformer->transform($admin->clientsInOrder('desc')->first())
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
            $client = $this->loggedUserAdministrator()->clientsBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Client with that id, does not exist.');
        }

        if($this->getUser()->cannot('view', $client))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
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
        try {
            $client = $this->loggedUserAdministrator()->clientsBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Client with that id, does not exist.');
        }

        if($this->getUser()->cannot('update', $client))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        // ***** Validation *****
            $this->validate($request, [
                    'name' => 'string|max:25',
                    'last_name' => 'string|max:40',
                    'email' => 'email|unique:users,email,'.$client->user->id.',id',
                    'cellphone' => 'string|max:20',
                    'type' => 'numeric|between:1,2',
                    'language' => 'string|max:2',
                    'getReportsEmails' => 'boolean',
                    'comments' => 'string|max:1000',
                    'photo' => 'mimes:jpg,jpeg,png',
                    'add_services' => 'array',
                    'add_services.*' => 'required|integer|exists:services,seq_id',
                    'remove_services' => 'array',
                    'remove_services.*' => 'required|integer|exists:services,seq_id',
                ]);
        // end validation

        // ***** Persiting to the database *****
        $transaction = DB::transaction(function () use($request, $client) {

            // set client values
            $client->fill(array_map('htmlentities', $request->except('admin_id','add_services', 'remove_services')));

            if(isset($request->add_services)){ $client->setServices($request->add_services); }
            if(isset($request->remove_services)){ $client->unsetServices($request->remove_services); }

            // set user values
            $user = $client->user;
            if(isset($request->email)){ $user->email = htmlentities($request->email); }
            if(isset($request->password)){ $user->password = bcrypt($request->password); }

            // set photo
            if($request->photo){
                $client->images()->delete();
                $photo = $client->addImageFromForm($request->file('photo'));
            }

            $client->save();
            $user->save();
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
        try {
            $client = $this->loggedUserAdministrator()->clientsBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Client with that id, does not exist.');
        }

        if($this->getUser()->cannot('delete', $client))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if($client->delete()){
            return $this->respondWithSuccess('Client was successfully deleted');
        }

        return $this->respondNotFound('Client with that id, does not exist.');
    }

}
