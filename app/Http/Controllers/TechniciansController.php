<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use JavaScript;

use App\Technician;
use App\User;

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
        $user = Auth::user();
        if($user->cannot('index', Technician::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator()){
            $technicians = $user->userable()->technicians()->get();
        }else{
            $technicians = $user->userable()->admin()->technicians()->get();
        }

        JavaScript::put([
            'click_url' => url('technicians').'/'
        ]);

        return view('technicians.index', compact('technicians'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        if($user->cannot('create', Technician::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator()){
            $supervisors = $user->userable()->supervisors()->get();
        }else{
            $supervisors = $user->userable()->admin()->supervisors()->get();
        }

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
        $user = Auth::user();
        if($user->cannot('create', Technician::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator()){
            $supervisor = $user->userable()->supervisorBySeqId($request->supervisor);
        }else{
            $supervisor = $user->userable()->admin()->supervisorBySeqId($request->supervisor);
        }

        $technician = Technician::create([
            'name'          => $request->name,
            'last_name'     => $request->last_name,
            'cellphone'     => $request->cellphone,
            'address'       => $request->address,
            'language'      => $request->language,
            'comments'      => $request->comments,
            'supervisor_id' => $supervisor->id,
        ]);

        $user = User::create([
            'email' => $request->username,
            'password' => $request->password,
            'userable_id' => $technician->id,
            'userable_type' => 'App\Technician',
            'remember_token' => str_random(10),
            'api_token' => str_random(60),
        ]);

        $photo = true;
        if($request->photo){
            $photo = $technician->addImageFromForm($request->file('photo'));
        }
        if($user && $technician && $photo){
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
    public function show($seq_id)
    {
        $user = Auth::user();
        if($user->cannot('show', Technician::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator()){
            $technician = $user->userable()->technicianBySeqId($seq_id);
        }else{
            $technician = $user->userable()->admin()->technicianBySeqId($seq_id);
        }

        return view('technicians.show', compact('technician'));
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
        if($user->cannot('show', Technician::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator()){
            $technician = $user->userable()->technicianBySeqId($seq_id);
            $supervisors = $user->userable()->supervisors()->get();
        }else{
            $technician = $user->userable()->admin()->technicianBySeqId($seq_id);
            $supervisors = $user->userable()->admin()->supervisors()->get();
        }

        return view('technicians.edit', compact('technician','supervisors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateTechnicianRequest $request, $seq_id)
    {
        $logged_user = Auth::user();
        if($logged_user->cannot('show', Technician::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($logged_user->isAdministrator()){
            $technician = $logged_user->userable()->technicianBySeqId($seq_id);
            $supervisor = $logged_user->userable()->supervisorBySeqId($request->supervisor);
        }else{
            $technician = $logged_user->userable()->admin()->technicianBySeqId($seq_id);
            $supervisor = $logged_user->userable()->admin()->supervisorBySeqId($request->supervisor);
        }
        $user = $technician->user();

        $user->email = $request->username;
        $user->password = $request->password;

        $technician->name = $request->name;
        $technician->last_name = $request->last_name;
        $technician->supervisor_id = $supervisor->id;
        $technician->cellphone = $request->cellphone;
        $technician->address = $request->address;
        $technician->language = $request->language;
        $technician->comments = $request->comments;

        $photo = true;
        if($request->photo){
            $technician->images()->delete();
            $photo = $technician->addImageFromForm($request->file('photo'));
        }

        if($user->save() && $technician->save() && $photo){
            flash()->success('Updated', 'New technician successfully updated.');
            return redirect('technicians/'.$seq_id);
        }
        flash()->error('Not Updated', 'Technician was not updated, please try again later.');
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
        if($user->cannot('show', Technician::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator()){
            $technician = $user->userable()->technicianBySeqId($seq_id);
        }else{
            $technician = $user->userable()->admin()->technicianBySeqId($seq_id);
        }

        if($technician->delete()){
            flash()->success('Deleted', 'The technician was successfuly deleted');
            return redirect('technicians');
        }
        flash()->error('Not Deleted', 'We could not delete the technician, please try again later.');
        return redirect()->back();
    }
}
