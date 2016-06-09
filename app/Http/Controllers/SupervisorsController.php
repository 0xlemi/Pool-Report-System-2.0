<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use JavaScript;

use App\Supervisor;
use App\User;

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
        $user = Auth::user();
        if($user->cannot('index', Supervisor::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator()){
            $supervisors = $user->userable()->supervisors()->get();
        }else{
            $supervisors = $user->userable()->admin()->supervisors()->get();
        }

        JavaScript::put([
            'click_url' => url('supervisors').'/',
        ]);

        return view('supervisors.index', compact('supervisors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        if($user->cannot('create', Supervisor::class))
        {
            // abort(403);
            return 'you should not pass';
        }

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
        $user = Auth::user();
        if($user->cannot('create', Supervisor::class))
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

        $supervisor = Supervisor::create([
            'name'      => $request->name,
            'last_name' => $request->last_name,
            'cellphone' => $request->cellphone,
            'address'   => $request->address,
            'language'  => $request->language,
            'comments'  => $request->comments,
            'admin_id'   => $admin->id,
        ]);
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt(str_random(9)),
            'userable_id' => $supervisor->id,
            'userable_type' => 'App\Supervisor',
            'remember_token' => str_random(10),
            'api_token' => str_random(60),
        ]);

        $photo = true;
        if($request->photo){
            $photo = $supervisor->addImageFromForm($request->file('photo'));
        }
        if($user && $supervisor && $photo){
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
        $user = Auth::user();
        if($user->cannot('show', Supervisor::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator()){
            $supervisor = $user->userable()->supervisorBySeqId($seq_id);
        }else{
            $supervisor = $user->userable()->admin()->supervisorBySeqId($seq_id);
        }

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
        $user = Auth::user();
        if($user->cannot('edit', Supervisor::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator()){
            $supervisor = $user->userable()->supervisorBySeqId($seq_id);
        }else{
            $supervisor = $user->userable()->admin()->supervisorBySeqId($seq_id);
        }

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
        $logged_user = Auth::user();
        if($logged_user->cannot('edit', Supervisor::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($logged_user->isAdministrator()){
            $supervisor = $logged_user->userable()->supervisorBySeqId($seq_id);
        }else{
            $supervisor = $logged_user->userable()->admin()->supervisorBySeqId($seq_id);
        }
        $user = $supervisor->user();

        $user->email = $request->email;
        $user->password = $request->password;

        $supervisor->name = $request->name;
        $supervisor->last_name = $request->last_name;
        $supervisor->cellphone = $request->cellphone;
        $supervisor->address = $request->address;
        $supervisor->language = $request->language;
        $supervisor->comments = $request->comments;

        $photo = true;
        if($request->photo){
            $supervisor->images()->delete();
            $photo = $supervisor->addImageFromForm($request->file('photo'));
        }

        if($user->save() && $supervisor->save() && $photo){
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
        $user = Auth::user();
        if($user->cannot('destroy', Supervisor::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator()){
            $supervisor = $user->userable()->supervisorBySeqId($seq_id);
        }else{
            $supervisor = $user->userable()->admin()->supervisorBySeqId($seq_id);
        }

        if($supervisor->delete()){
            flash()->success('Deleted', 'The supervisor was successfuly deleted');
            return redirect('supervisors');
        }
        flash()->error('Not Deleted', 'We could not delete the supervisor, please try again later.');
        return redirect()->back();
    }
}
