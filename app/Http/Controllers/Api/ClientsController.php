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
    public function index()
    {
        $clients = $this->loggedUserAdministrator()->clients()->get();

        return $this->respond([
            'data' => $this->clientTransformer->transformCollection($clients),
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
        $validator = $this->validateClientRequestCreate($request);

        if ($validator->fails()) {
            // return error responce
            return $this->setStatusCode(422)->RespondWithError('Paramenters failed validation.', $validator->errors()->toArray());
        }

        $admin = $this->loggedUserAdministrator();

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
        try {
            $client = $this->loggedUserAdministrator()->clientsBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Client with that id, does not exist.');
        }

        $validator = $this->validateClientRequestUpdate($request, $client->user()->userable_id);

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
            return $this->respondPersisted(
                'The client was successfully updated.',
                $this->clientTransformer->transform($this->loggedUserAdministrator()->clientsBySeqId($seq_id))
            );
        }
        return $this->respondInternalError('The client could not be updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
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

    protected function validateClientRequestUpdate(Request $request, $userable_id)
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
