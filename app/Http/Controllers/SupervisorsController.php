<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use JavaScript;

use App\Supervisor;
use App\User;

use App\Http\Requests\CreateUserRoleCompanyRequest;
use App\Http\Requests\UpdateUserRoleCompanyRequest;
use App\Http\Requests;
use App\Http\Controllers\PageController;
use App\PRS\Transformers\ImageTransformer;
use App\UserRoleCompany;

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
        $this->authorize('list', [UserRoleCompany::class, 'sup']);

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
        $this->authorize('create', [UserRoleCompany::class, 'sup']);

        return view('supervisors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRoleCompanyRequest $request)
    {
        $this->authorize('create', [UserRoleCompany::class, 'sup']);

        $company = $this->loggedCompany();

        // check if the you can add new users
        // if(!$company->canAddObject()){
        //     flash()->overlay("Oops, you need a Pro account.",
        //             "You ran out of your {$company->free_objects} free users, to activate more users subscribe to Pro account.",
        //             'info');
        //     return redirect()->back()->withInput();
        // }


        $user = User::where('email', $request->email)->first();
        if($user == null){
            // Create the user
            $user = User::create(array_map('htmlentities',[
                'email' => $request->email,
                'name' => $request->name,
                'last_name' => $request->last_name,
                'language' => $request->language,
            ]));
        }

        // Check that there is no other URC with the same attributes
        // Not need to worry about creating a only a user because if the user was
        // null this check is never gonig to be true.
        if($user->hasRolesWithCompany($company, 'sup', 'tech', 'admin')){
            flash()->overlay('Not Created', 'You already have a supervisor, technician or administrator with that email for this company.', 'error');
            return redirect()->back()->withInput();
        }

        $supervisor = $user->userRoleCompanies()->create(array_map('htmlentities', [
            'cellphone' => $request->cellphone,
            'address' => $request->address,
            'about' => $request->about,
            'role_id' => 3, // supervisor
            'company_id' => $company->id,
        ]));

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
        $supervisor = $this->loggedCompany()->userRoleCompanies()->bySeqId($seq_id);

        $this->authorize('view', $supervisor);

        // check that userRoleCompany has role of supervisor
        if(!$supervisor->isRole('sup')){
            abort(404, 'There is no supervisor with that id');
        }

        $user = $supervisor->user;
        $image = null;
        if($supervisor->images->count() > 0){
            $image = $this->imageTransformer->transform($supervisor->images->first());
        }

        return view('supervisors.show', compact('supervisor', 'user', 'image'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($seq_id)
    {
        $supervisor = $this->loggedCompany()->userRoleCompanies()->bySeqId($seq_id);

        $this->authorize('update', $supervisor);

        // check that userRoleCompany has role of supervisor
        if(!$supervisor->isRole('sup')){
            abort(404, 'There is no supervisor with that id');
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
    public function update(UpdateUserRoleCompanyRequest $request, $seq_id)
    {
        $company = $this->loggedCompany();
        $supervisor = $company->userRoleCompanies()->bySeqId($seq_id);

        $this->authorize('update', $supervisor);

        // check that userRoleCompany has role of supervisor
        if(!$supervisor->isRole('sup')){
            abort(404, 'There is no supervisor with that id');
        }

        $status = ($request->paid)? 1:0;
        // if he is setting the status to active
        // if is changing the status compared with the one already in database
        // or if admin dosn't pass the checks for subscription and free objects
        // if( ($status && ($status != $supervisor->paid)) && !$company->canAddObject()){
        //     flash()->overlay("Oops, you need a Pro account.",
        //             "You ran out of your {$company->free_objects} free users, to activate more users subscribe to Pro account.",
        //             'info');
        //     return redirect()->back()->withInput();
        // }

        $supervisor->fill(array_map('htmlentities', [
            'cellphone' => $request->cellphone,
            'address' => $request->address,
            'about' => $request->about,
        ]));
        // Comented out while im using device magic
        // $supervisor->paid = $status;
        // $supervisorSaved = $supervisor->save();

        $photo = false;
        if($request->photo){
            $supervisor->images()->delete();
            $photo = $supervisor->addImageFromForm($request->file('photo'));
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
        $supervisor = $this->loggedCompany()->userRoleCompanies()->bySeqId($seq_id);

        $this->authorize('delete', $supervisor);

        // check that userRoleCompany has role of supervisor
        if(!$supervisor->isRole('sup')){
            abort(404, 'There is no supervisor with that id');
        }

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
