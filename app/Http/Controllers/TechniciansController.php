<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Technician;

use App\Http\Requests;
use App\Http\Requests\CreateTechnicianRequest;

class TechniciansController extends Controller
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
        $technicians = Auth::user()->technicians;

        return view('technicians.index', compact('technicians'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supervisors = Auth::user()->supervisors;

        return view('technicians.create', compact('supervisors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTechnicianRequest $request)
    {
        $supervisor = Auth::user()->supervisorBySeqId($request->supervisor);
                
        $technician = Technician::create([
            'name'          => $request->name,
            'last_name'     => $request->last_name,
            'supervisor_id' => $supervisor->id,
            'username'      => $request->username,
            'password'      => $request->password,
            'cellphone'     => $request->cellphone,
            'address'       => $request->address,
            'language'      => $request->language,
            'comments'      => $request->comments,
        ]);
        $photo = true;
        if($request->photo){
            $photo = $technician->addImageFromForm($request->file('photo'));
        }
        if($technician && $photo){
            flash()->success('Created', 'New technician successfully created.');
            return redirect('technicians');
        }
        flash()->success('Not created', 'New technician was not created, please try again later.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
