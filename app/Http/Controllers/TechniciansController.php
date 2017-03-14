<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use JavaScript;

use App\Technician;
use App\Supervisor;
use App\User;

use App\Http\Requests;
use App\Http\Requests\CreateTechnicianRequest;
use App\Http\Requests\UpdateTechnicianRequest;
use App\Http\Controllers\PageController;
use App\PRS\Helpers\SupervisorHelpers;
use App\PRS\Transformers\ImageTransformer;

class TechniciansController extends PageController
{

    private $supervisorHelpers;
    protected $imageTransformer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SupervisorHelpers $supervisorHelpers,
                                ImageTransformer $imageTransformer)
    {
        $this->middleware('auth');
        $this->supervisorHelpers = $supervisorHelpers;
        $this->imageTransformer = $imageTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('list', Technician::class);

        $default_table_url = url('datatables/technicians?status=1');

        JavaScript::put([
            'techniciansTableUrl' => url('datatables/technicians?status='),
            'click_url' => url('technicians').'/'
        ]);

        return view('technicians.index', compact('default_table_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Technician::class);

        $supervisors = $this->supervisorHelpers->transformForDropdown(
                    $this->loggedUserAdministrator()
                    ->supervisorsInOrder()
                    ->get()
                );
        JavaScript::put([
            'dropdownKey' => $request->old('supervisor'),
        ]);

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
        $this->authorize('create', Technician::class);

        $admin = $this->loggedUserAdministrator();

        $supervisor = $admin->supervisorBySeqId($request->supervisor);

        // check if the you can add new users
        if(!$admin->canAddObject()){
            flash()->overlay("Oops, you need a Pro account.",
                    "You ran out of your {$admin->free_objects} free users, to activate more users subscribe to Pro account.",
                    'info');
            return redirect()->back()->withInput();
        }

        $technician = $supervisor->technicians()->create(array_map('htmlentities', $request->all()));

        $photo = true;
        if($request->photo){
            $photo = $technician->addImageFromForm($request->file('photo'));
        }

        $user = $technician->user()->create([
            'email' => htmlentities($request->username),
        ]);


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
        $technician = $this->loggedUserAdministrator()->technicianBySeqId($seq_id);

        $this->authorize('view', $technician);
        $image = null;
        if($technician->images->count() > 0){
            $image = $this->imageTransformer->transform($technician->images->first());
        }

        return view('technicians.show', compact('technician', 'image'));
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
        $technician = $admin->technicianBySeqId($seq_id);

        $this->authorize('update', $technician);

        $supervisors = $this->supervisorHelpers->transformForDropdown($admin->supervisorsInOrder()->get());
        $supervisorSelected = Supervisor::find($technician->supervisor_id);
        JavaScript::put([
            'dropdownKey' => $supervisorSelected->seq_id,
        ]);

        return view('technicians.edit', compact('technician','supervisors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTechnicianRequest $request, $seq_id)
    {
        $admin = $this->loggedUserAdministrator();
        $technician = $admin->technicianBySeqId($seq_id);

        $this->authorize('update', $technician);

        $supervisor = $admin->supervisorBySeqId($request->supervisor);
        $user = $technician->user;

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


        $technician->fill(array_map('htmlentities', $request->all()));
        $technician->supervisor()->associate($admin->supervisorBySeqId($request->supervisor));

        $user->active = $status;
        $user->email = htmlentities($request->username);

        $photo = false;
        if($request->photo){
            $technician->images()->delete();
            $photo = $technician->addImageFromForm($request->file('photo'));
        }

        $userSaved = $user->save();
        $technicianSaved = $technician->save();

        if(!$userSaved && !$technicianSaved && !$photo){
            flash()->overlay("You did not change anything", 'You did not make changes in technician information.', 'info');
            return redirect()->back();
        }
        flash()->success('Updated', 'Technician successfully updated.');
        return redirect('technicians/'.$seq_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($seq_id)
    {
        $technician = $this->loggedUserAdministrator()->technicianBySeqId($seq_id);

        $this->authorize('delete', $technician);

        if($technician->delete()){
            flash()->success('Deleted', 'The technician successfully deleted.');
            return response()->json([
                'message' => 'The technician was deleted successfully.'
            ]);
        }
        return response()->json([
                'error' => 'The technician was not deleted, please try again later.'
            ], 500);
    }

}
