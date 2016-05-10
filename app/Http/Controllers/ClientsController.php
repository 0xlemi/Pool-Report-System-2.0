<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use JavaScript;

use App\Client;
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
        JavaScript::put([
            'click_url' => url('clients').'/',
        ]);
        $clients = Auth::user()->clients();
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $client = Client::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'cellphone' => $request->cellphone,
            'type' => $request->type,
            'language' => $request->language,
            'comments' => $request->comments,
            'user_id' => Auth::user()->id,
        ]);
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
        $client = Auth::user()->clientsBySeqId($seq_id);
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
        $client = Auth::user()->clientsBySeqId($seq_id);
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
        $client = Auth::user()->clientsBySeqId($seq_id);

        $client->name = $request->name;
        $client->last_name = $request->last_name;
        $client->email = $request->email;
        $client->cellphone = $request->cellphone;
        $client->type = $request->type;
        $client->language = $request->language;
        $client->comments = $request->comments;

        $photo = true;
        if($request->photo){
            $client->images()->delete();
            $photo = $client->addImageFromForm($request->file('photo'));
        }

        if($client->save() && $photo){
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
        $client = Auth::user()->clientsBySeqId($seq_id);
        if($client->delete()){
            flash()->success('Deleted', 'The client was successfuly deleted');
            return redirect('clients');
        }
        flash()->error('Not Deleted', 'We could not delete the client, please try again later.');
        return redirect()->back();
    }
}
