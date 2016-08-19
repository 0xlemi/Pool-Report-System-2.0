<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use JavaScript;

use App\Technician;
use App\User;

use App\Http\Requests;
use App\Http\Requests\CreateTechnicianRequest;
use App\Http\Controllers\PageController;

class TechniciansController extends PageController
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

        $default_table_url = url('datatables/technicians');

        JavaScript::put([
            'click_url' => url('technicians').'/'
        ]);

        return view('technicians.index', compact('default_table_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->checkPermissions('create');

        $supervisors = $this->loggedUserAdministrator()->supervisors()->get();

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
        $this->checkPermissions('create');

        $supervisor = $this->loggedUserAdministrator()->supervisorBySeqId($request->supervisor);

        $technician =   Technician::create(
                                array_merge(
                                    array_map('htmlentities', $request->except('supervisor_id')),
                                    [ 'supervisor_id' => $supervisor->id ]
                                )
                        );

        $user = User::create([
            'email' => $request->username,
            'password' => bcrypt(str_random(9)),
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
        $this->checkPermissions('show');

        $technician = $this->loggedUserAdministrator()->technicianBySeqId($seq_id);

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
        $this->checkPermissions('edit');

        $technician = $this->loggedUserAdministrator()->technicianBySeqId($seq_id);
        $supervisors = $this->loggedUserAdministrator()->supervisors()->get();

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
        $this->checkPermissions('edit');

        $technician = $this->loggedUserAdministrator()->technicianBySeqId($seq_id);
        $supervisor = $this->loggedUserAdministrator()->supervisorBySeqId($request->supervisor);

        $user = $technician->user();

        $user->email = htmlentities($request->username);
        $user->password = htmlentities($request->password);



        $technician->fill(array_merge(
                                array_map('htmlentities', $request->except('supervisor_id')),
                                [ 'supervisor_id' => $supervisor->id ]
                            ));

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
        $this->checkPermissions('destroy');

        $technician = $this->loggedUserAdministrator()->technicianBySeqId($seq_id);

        if($technician->delete()){
            flash()->success('Deleted', 'The technician was successfuly deleted');
            return redirect('technicians');
        }
        flash()->error('Not Deleted', 'We could not delete the technician, please try again later.');
        return redirect()->back();
    }

    protected function checkPermissions($typePermission)
    {
        $user = Auth::user();
        if($user->cannot($typePermission, Technician::class))
        {
            abort(403, 'If you really need to see this. Ask system administrator for access.');
        }
    }

}
