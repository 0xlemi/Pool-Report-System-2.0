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
use App\PRS\Transformers\ImageTransformer;

class SupervisorsController extends PageController
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
        $this->authorize('list', Supervisor::class);

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
        $this->authorize('create', Supervisor::class);

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
        $this->authorize('create', Supervisor::class);

        $admin = $this->loggedUserAdministrator();

        // check if the you can add new users
        if(!$admin->canAddObject()){
            flash()->overlay("Oops, you need a Pro account.",
                    "You ran out of your {$admin->free_objects} free users, to activate more users subscribe to Pro account.",
                    'info');
            return redirect()->back()->withInput();
        }

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
        $supervisor = $this->loggedUserAdministrator()->supervisorBySeqId($seq_id);

        $this->authorize('view', $supervisor);
        $image = $this->imageTransformer->transform($supervisor->images->first());

        return view('supervisors.show', compact('supervisor', 'image'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($seq_id)
    {
        $supervisor = $this->loggedUserAdministrator()->supervisorBySeqId($seq_id);

        $this->authorize('update', $supervisor);

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
        $admin = $this->loggedUserAdministrator();
        $supervisor = $admin->supervisorBySeqId($seq_id);

        $this->authorize('update', $supervisor);

        $user = $supervisor->user();
        $user->email = htmlentities($request->email);

        $supervisor->fill(array_map('htmlentities', $request->except('admin_id')));

        $status = ($request->status)? 1:0;
        // if he is setting the status to active
        // if is changing the status compared with the one already in database
        // or if admin dosn't pass the checks for subscription and free objects
        if( ($status && ($status != $user->active)) && !$admin->canAddObject()){
            flash()->overlay("Oops, you need a Pro account.",
                    "You ran out of your {$admin->free_objects} free users, to activate more users subscribe to Pro account.",
                    'info');
            return redirect()->back();
        }
        $user->active = $status;

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
        $supervisor = $this->loggedUserAdministrator()->supervisorBySeqId($seq_id);

        $this->authorize('delete', $supervisor);

        if($supervisor->delete()){
            flash()->success('Deleted', 'The supervisor successfully deleted.');
            return response()->json([
                'message' => 'The supervisor was deleted successfully.'
            ]);
        }
        return response()->json([
                'error' => 'The supervisor was not deleted, please try again later.'
            ], 500);
    }

}
