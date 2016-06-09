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

class ClientsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if($user->cannot('index', Client::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator())
        {
            $clients = $user->userable()->clients()->get();
        }else{
            $clients = $user->userable()->admin()->clients()->get();
        }

        JavaScript::put([
            'click_url' => url('clients').'/',
        ]);

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        if($user->cannot('create', Client::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateClientRequest $request)
    {
        $user = Auth::user();
        if($user->cannot('create', Client::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator())
        {
            $admin = $user->userable();
        }else{
            $admin = $user->userable()->admin();
        }

        $client = Client::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'cellphone' => $request->cellphone,
            'type' => $request->type,
            'language' => $request->language,
		    'email_preferences' => 4,
            'comments' => $request->comments,
            'admin_id' => $admin->id,
        ]);
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt(str_random(9)),
            'userable_id' => $client->id,
            'userable_type' => 'App\Client',
            'remember_token' => str_random(10),
            'api_token' => str_random(60),
        ]);

        // DB::table('client_service')->insert([
        //         'client_id' => $client_id,
        //         'service_id' => $service_id,
        //     ]);

        $photo = true;
        if($request->photo){
            $photo = $client->addImageFromForm($request->file('photo'));
        }
        if($client && $photo){
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
        $user = Auth::user();
        if($user->cannot('show', Client::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator())
        {
            $client = $user->userable()->clientsBySeqId($seq_id);
        }else{
            $client = $user->userable()->admin()->clientsBySeqId($seq_id);
        }

        return view('clients.show',compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($seq_id)
    {
        $user = Auth::user();
        if($user->cannot('edit', Client::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator())
        {
            $client = $user->userable()->clientsBySeqId($seq_id);
        }else{
            $client = $user->userable()->admin()->clientsBySeqId($seq_id);
        }

        return view('clients.edit',compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateClientRequest $request, $seq_id)
    {
        $user = Auth::user();
        if($user->cannot('edit', Client::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator())
        {
            $client = $user->userable()->clientsBySeqId($seq_id);
            $user = $client->user();
        }else{
            $client = $user->userable()->admin()->clientsBySeqId($seq_id);
            $user = $client->user();
        }

        $user->email = $request->email;

        $client->name = $request->name;
        $client->last_name = $request->last_name;
        $client->cellphone = $request->cellphone;
        $client->type = $request->type;
        $client->language = $request->language;
        $client->comments = $request->comments;

        $photo = true;
        if($request->photo){
            $client->images()->delete();
            $photo = $client->addImageFromForm($request->file('photo'));
        }

        if($user->save() && $client->save() && $photo){
            flash()->success('Updated', 'New client successfully updated.');
            return redirect('clients/'.$seq_id);
        }
        flash()->error('Not Updated', 'Client was not updated, please try again later.');
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($seq_id)
    {
        $user = Auth::user();
        if($user->cannot('destroy', Client::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator())
        {
            $client = $user->userable()->clientsBySeqId($seq_id);
        }else{
            $client = $user->userable()->admin()->clientsBySeqId($seq_id);
        }

        if($client->delete()){
            flash()->success('Deleted', 'The client was successfuly deleted');
            return redirect('clients');
        }
        flash()->error('Not Deleted', 'We could not delete the client, please try again later.');
        return redirect()->back();
    }
}
