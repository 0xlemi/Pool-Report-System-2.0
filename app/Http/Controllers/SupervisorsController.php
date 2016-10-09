<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use JavaScript;

use App\Supervisor;
use App\User;

use App\Http\Requests\CreateSupervisorRequest;
use App\Http\Requests;
use App\Http\Controllers\PageController;

class SupervisorsController extends PageController
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
        $this->checkPermissions('index');

        $default_table_url = url('datatables/supervisors?status=1');

        JavaScript::put([
            'supervisorTableUrl' => url('datatables/supervisors?status='),
            'click_url' => url('supervisors').'/',
        ]);

        return view('supervisors.index', compact('default_table_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->checkPermissions('create');

        return view('supervisors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSupervisorRequest $request)
    {
        $this->checkPermissions('create');

        $admin = $this->loggedUserAdministrator();

        $supervisor = Supervisor::create(
                        array_merge(
                            array_map('htmlentities', $request->all()),
                            [ 'admin_id' => $admin->id ]
                        )
                    );
        $user = User::create([
            'email' => htmlentities($request->email),
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
        $this->checkPermissions('show');

        $supervisor = $this->loggedUserAdministrator()->supervisorBySeqId($seq_id);

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
        $this->checkPermissions('edit');

        $supervisor = $this->loggedUserAdministrator()->supervisorBySeqId($seq_id);

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
        $this->checkPermissions('edit');

        $admin = $this->loggedUserAdministrator();

        $supervisor = $admin->supervisorBySeqId($seq_id);

        $user = $supervisor->user();

        $user->email = htmlentities($request->email);

        $supervisor->fill(array_map('htmlentities', $request->except('admin_id')));

        if($request->status){
            // If user can not add more objects and the status is set to false.
            // then reject the change.
            if(!$admin->canAddObject() && !$supervisor->status){
                flash()->overlay("Oops, run out of free users.",
                        "Want more? Go to settings and subscribe for monthly plan.",
                        'warning');
                return redirect()->back();
            }
            $supervisor->status = 1;
        }else{
            $supervisor->status = 0;
        }

        $photo = false;
        if($request->photo){
            $supervisor->images()->delete();
            $photo = $supervisor->addImageFromForm($request->file('photo'));
        }

        $userSaved = $user->save();
        $supervisorSaved = $supervisor->save();

        if(!$userSaved && !$supervisorSaved && !$photo){
            flash()->overlay("You did not change anything", 'You did not make changes in supervisor information.', 'info');
            return redirect()->back();
        }
        flash()->success('Updated', 'Supervisor successfully updated.');
        return redirect('supervisors/'.$seq_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($seq_id)
    {
        $this->checkPermissions('destroy');

        $supervisor = $this->loggedUserAdministrator()->supervisorBySeqId($seq_id);

        if($supervisor->delete()){
            flash()->success('Deleted', 'The supervisor was successfuly deleted');
            return redirect('supervisors');
        }
        flash()->error('Not Deleted', 'We could not delete the supervisor, please try again later.');
        return redirect()->back();
    }

    protected function checkPermissions($typePermission)
    {
        $user = Auth::user();
        if($user->cannot($typePermission, Supervisor::class))
        {
            abort(403, 'If you really need to see this. Ask system administrator for access.');
        }
    }

}
