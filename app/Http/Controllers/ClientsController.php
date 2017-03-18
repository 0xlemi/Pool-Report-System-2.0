<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use JavaScript;
use DB;

use App\Client;
use App\User;
use App\Http\Requests;

use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\PRS\Transformers\ImageTransformer;

class ClientsController extends PageController
{

    protected $imageTransformer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ImageTransformer $imageTransformer)
    {
        $this->middleware('auth');
        $this->imageTransformer = $imageTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('list', Client::class);

        $default_table_url = url('datatables/clients');

        JavaScript::put([
            'click_url' => url('clients').'/',
        ]);

        return view('clients.index', compact('default_table_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Client::class);

        $services = $this->loggedUserAdministrator()->servicesInOrder()->get();

        return view('clients.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateClientRequest $request)
    {
        $this->authorize('create', Client::class);

        $admin = $this->loggedUserAdministrator();

        $client = $admin->clients()->create(
                        array_map('htmlentities', $request->except('services'))
                    );

        $photo = true;
        if($request->photo){
            $photo = $client->addImageFromForm($request->file('photo'));
        }

        if($request->services){
            $client->setServices($request->services);
        }
        $client->save();

        $user = $client->user()->create([
            'email' => htmlentities($request->email),
        ]);

        if($client && $photo && $user){
            flash()->success('Created', 'New client successfully created.');
            return redirect('clients');
        }
        flash()->success('Not created', 'New client was not created, please try again later.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($seq_id)
    {
        $client = $this->loggedUserAdministrator()->clientsBySeqId($seq_id);

        $this->authorize('view', $client);

        $services = $client->services()->get();
        $image = null;
        if($client->images->count() > 0){
            $image = $this->imageTransformer->transform($client->images->first());
        }

        return view('clients.show',compact('client', 'services', 'image'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($seq_id)
    {
        $admin = $this->loggedUserAdministrator();
        $client = $admin->clientsBySeqId($seq_id);

        $this->authorize('update', $client);

        $services = $admin->servicesInOrder()->get();

        return view('clients.edit',compact('client', 'services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request, $seq_id)
    {
        $client = $this->loggedUserAdministrator()->clientsBySeqId($seq_id);

        $this->authorize('update', $client);

        $user  = $client->user;
        $user->email = htmlentities($request->email);

        $client->fill(array_map('htmlentities', $request->except(['admin_id', 'services'])));
        $client->setServices($request->services);

        $photo = false;
        if($request->photo){
            $client->images()->delete();
            $photo = $client->addImageFromForm($request->file('photo'));
        }

        $userSaved = $user->save();
        $clientSaved = $client->save();

        if(!$userSaved && !$clientSaved && !$photo){
            flash()->overlay("You did not change anything", 'You did not make changes in client information.', 'info');
            return redirect()->back();
        }
        flash()->success('Updated', 'Client successfully updated.');
        return redirect('clients/'.$seq_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($seq_id)
    {
        $client = $this->loggedUserAdministrator()->clientsBySeqId($seq_id);

        $this->authorize('delete', $client);

        if($client->delete()){
            flash()->success('Deleted', 'The client successfully deleted.');
            return response()->json([
                'message' => 'The client was deleted successfully.'
            ]);
        }
        return response()->json([
                'error' => 'The client was not deleted, please try again later.'
            ], 500);
    }

}
