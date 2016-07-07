<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\PRS\Transformers\ClientTransformer;

use App\Client;
use App\Service;
use App\User;

use Validator;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        $this->middleware(['api', 'auth:api']);
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
        if($this->getUser()->cannot('create', Client::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $validator = $this->validateClientRequestCreate($request);

        if ($validator->fails()) {
            // return error responce
            return $this->setStatusCode(422)->RespondWithError('Paramenters failed validation.', $validator->errors()->toArray());
        }

        $admin = $this->loggedUserAdministrator();

        // transform services_seq_id to service_id array and check
        // that the services with those id exist
        $service_ids = $this->getAddServicesIds($request->service_ids, $admin);

        $client = Client::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'cellphone' => $request->cellphone,
            'language' => $request->language,
            'type' => $request->type, // 1 owner, 2 house administrator
            'comments' => $request->comments,
            'admin_id' => $admin->id,
        ]);

        $client_id = $admin->clients(true)->first()->id;

        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt(str_random(20)),
            'api_token' => str_random(60),
            'userable_type' => 'App\Client',
            'userable_id' => $client_id,
        ]);

        if($client && $user){
            $client->services()->attach($service_ids);

            return $this->respondPersisted(
                'The client was successfuly created.',
                $this->clientTransformer->transform($admin->clients(true)->first())
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
     * tested
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $seq_id)
    {
        if($this->getUser()->cannot('edit', Client::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        try {
            $client = $this->loggedUserAdministrator()->clientsBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Client with that id, does not exist.');
        }

        $admin = $this->loggedUserAdministrator();

        $add_service_ids = $this->getAddServicesIds($request->add_service_ids, $admin, $client);
        $remove_service_ids = $this->getRemoveServicesIds($request->remove_service_ids, $admin);

        $validator = $this->validateClientRequestUpdate($request, $client->user()->userable_id, $add_service_ids, $remove_service_ids);

        if ($validator->fails()) {
            // return error responce
            return $this->setStatusCode(422)
                ->RespondWithError(
                    'Paramenters failed validation.',
                    $validator->errors()->toArray()
                );
        }

        $objects = $this->updateClient($request, $client);

        // $photo = true;
        // if($request->photo){
        //     $supervisor->images()->delete();
        //     $photo = $supervisor->addImageFromForm($request->file('photo'));
        // }

        if($objects['client']->save() && $objects['user']->save()){

            $objects['client']->services()->attach($add_service_ids);
            if(!empty($remove_service_ids)){
                $objects['client']->services()->detach($remove_service_ids);
            }

            return $this->respondPersisted(
                'The client was successfully updated.',
                $this->clientTransformer->transform($this->loggedUserAdministrator()->clientsBySeqId($seq_id))
            );
        }
        return $this->respondInternalError('The client could not be updated.');
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


    protected function validateClientRequestCreate(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:25',
            'last_name' => 'required|string|max:40',
            'email' => 'required|email|unique:users,email',
            'cellphone' => 'required|string|max:20',
            'type' => 'required|numeric|between:1,2',
            'language' => 'required|string|max:2',
            'photo' => 'mimes:jpg,jpeg,png',
            'comments' => 'string|max:1000',
        ]);
    }

    protected function validateClientRequestUpdate(Request $request, $userable_id, $add_service_ids, $remove_service_ids)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:25',
            'last_name' => 'required|string|max:40',
            'email' => 'required|email|unique:users,email,'.$userable_id.',userable_id',
            'cellphone' => 'required|string|max:20',
            'type' => 'required|numeric|between:1,2',
            'language' => 'required|string|max:2',
            'photo' => 'mimes:jpg,jpeg,png',
            'comments' => 'string|max:1000',
        ]);
    }

    public function getServicesIds($services_seq_id, $admin, $message, $client = null)
    {
        $service_ids = array();
        if(isset($services_seq_id)){
            foreach ($services_seq_id as $service_seq_id) {
                try{
                    $service_id = $admin->serviceBySeqId($service_seq_id)->id;
                    // check that dosn't have a connection already
                    if(isset($client)){
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

    protected function getAddServicesIds($add_service_seq_ids, $admin, $client = null)
    {
        return $this->getServicesIds(
                $add_service_seq_ids,
                $admin,
                'Some services from the array add_service_ids, does not exist.',
                $client
            );
    }

    protected function getRemoveServicesIds($remove_service_seq_ids, $admin)
    {
        return $this->getServicesIds(
                $remove_service_seq_ids,
                $admin,
                'Some services from the array remove_service_ids, does not exist.'
            );
    }

    protected function updateClient(Request $request, Client $client)
    {

        if(isset($request->name)){ $client->name = $request->name; }
        if(isset($request->last_name)){ $client->last_name = $request->last_name; }
        if(isset($request->cellphone)){ $client->cellphone = $request->cellphone; }
        if(isset($request->type)){ $client->type = $request->type; }
        if(isset($request->language)){ $client->language = $request->language; }
        if(isset($request->comments)){ $client->comments = $request->comments; }


        $user = $client->user();
        if(isset($request->email)){ $user->email = $request->email; }
        if(isset($request->password)){ $user->password = $request->password; }


        return array(
            'client' => $client,
            'user' => $user
        );
    }


}
