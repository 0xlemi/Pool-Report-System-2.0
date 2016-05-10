<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use JavaScript;

use App\Supervisor;

use App\Http\Requests\CreateSupervisorRequest;
use App\Http\Requests;

class SupervisorsController extends Controller
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
            'click_url' => url('supervisors').'/',
        ]);
        $supervisors = Auth::user()->supervisors;
        return view('supervisors.index', compact('supervisors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supervisors.create', compact('supervisors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSupervisorRequest $request)
    {
        $supervisor = Supervisor::create([
            'name'      => $request->name,
            'last_name' => $request->last_name,
            'email'     => $request->email,
            'password'  => $request->password,
            'cellphone' => $request->cellphone,
            'address'   => $request->address,
            'language'  => $request->language,
            'comments'  => $request->comments,
            'user_id'   => Auth::user()->id,
        ]);
        $photo = true;
        if($request->photo){
            $photo = $supervisor->addImageFromForm($request->file('photo'));
        }
        if($supervisor && $photo){
            flash()->success('Created', 'New supervisor successfully created.');
            return redirect('supervisors');
        }
        flash()->success('Not created', 'New supervisor was not created, please try again later.');
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
        $supervisor = Auth::user()->supervisorBySeqId($seq_id);
        return view('supervisors.show', compact('supervisor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($seq_id)
    {
        $supervisor = Auth::user()->supervisorBySeqId($seq_id);
        return view('supervisors.edit', compact('supervisor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateSupervisorRequest $request, $seq_id)
    {
        $supervisor = Auth::user()->supervisorBySeqId($seq_id);

        $supervisor->name = $request->name;
        $supervisor->last_name = $request->last_name;
        $supervisor->email = $request->email;
        $supervisor->password = $request->password;
        $supervisor->cellphone = $request->cellphone;
        $supervisor->address = $request->address;
        $supervisor->language = $request->language;
        $supervisor->comments = $request->comments;

        $photo = true;
        if($request->photo){
            $supervisor->images()->delete();
            $photo = $supervisor->addImageFromForm($request->file('photo'));
        }

        if($supervisor->save() && $photo){
            flash()->success('Updated', 'New supervisor successfully updated.');
            return redirect('supervisors/'.$seq_id);
        }
        flash()->error('Not Updated', 'Supervisor was not updated, please try again later.');
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
        $supervisor = Auth::user()->supervisorBySeqId($seq_id);
        if($supervisor->delete()){
            flash()->success('Deleted', 'The supervisor was successfuly deleted');
            return redirect('supervisors');
        }
        flash()->error('Not Deleted', 'We could not delete the supervisor, please try again later.');
        return redirect()->back();
    }
}
