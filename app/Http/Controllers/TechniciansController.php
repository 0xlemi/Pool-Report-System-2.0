<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use JavaScript;

use App\Technician;
use App\Supervisor;
use App\User;

use App\Http\Requests;
use App\Http\Requests\CreateUserRoleCompanyRequest;
use App\Http\Requests\UpdateUserRoleCompanyRequest;
use App\Http\Controllers\PageController;
use App\PRS\Helpers\UserRoleCompanyHelpers;
use App\PRS\Transformers\ImageTransformer;
use App\UserRoleCompany;

class TechniciansController extends PageController
{

    private $userRoleCompanyHelpers;
    protected $imageTransformer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRoleCompanyHelpers $userRoleCompanyHelpers,
                                ImageTransformer $imageTransformer)
    {
        $this->middleware('auth');
        $this->userRoleCompanyHelpers = $userRoleCompanyHelpers;
        $this->imageTransformer = $imageTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('list', [UserRoleCompany::class, 'tech']);

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
        $this->authorize('create', [UserRoleCompany::class, 'tech']);

        return view('technicians.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRoleCompanyRequest $request)
    {
        $this->validate($request, [
            'password' => 'required|alpha_dash|between:6,200'
        ]);

        $this->authorize('create', [UserRoleCompany::class, 'tech']);

        $company = $this->loggedCompany();

        // check if the you can add new users
        if(!$company->canAddObject()){
            flash()->overlay("Oops, you need a Pro account.",
                    "You ran out of your {$company->free_objects} free users, to activate more users subscribe to Pro account.",
                    'info');
            return redirect()->back()->withInput();
        }


        $user = User::where('email', $request->email)->first();
        if($user == null){
            // Create the user
            $user = User::create(array_map('htmlentities',[
                'email' => $request->email,
                'name' => $request->name,
                'last_name' => $request->last_name,
                'language' => $request->language,
            ]));
            $user->password = bcrypt($request->password);
            $user->save();
        }

        // Check that there is no other URC with the same attributes
        // Not need to worry about creating a only a user because if the user was
        // null this check is never gonig to be true.
        if($user->hasRolesWithCompany($company, 'sup', 'tech', 'admin')){
            flash()->overlay('Not Created', 'You already have a supervisor, technician or administrator with that email for this company.', 'error');
            return redirect()->back()->withInput();
        }

        $technician = $user->userRoleCompanies()->create(array_map('htmlentities', [
            'cellphone' => $request->cellphone,
            'address' => $request->address,
            'about' => $request->about,
            'role_id' => 4, // technician
            'company_id' => $company->id,
        ]));

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
        $technician = $this->loggedCompany()->userRoleCompanies()->bySeqId($seq_id);

        $this->authorize('view', $technician);

        // check that userRoleCompany has role of technician
        if(!$technician->isRole('tech')){
            abort(404, 'There is no technician with that id');
        }

        $user = $technician->user;
        $image = null;
        if($technician->images->count() > 0){
            $image = $this->imageTransformer->transform($technician->images->first());
        }

        return view('technicians.show', compact('technician', 'user', 'image'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($seq_id)
    {
        $technician = $this->loggedCompany()->userRoleCompanies()->bySeqId($seq_id);

        $this->authorize('update', $technician);

        // check that userRoleCompany has role of technician
        if(!$technician->isRole('tech')){
            abort(404, 'There is no technician with that id');
        }

        return view('technicians.edit', compact('technician'));
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
        $technician = $company->userRoleCompanies()->bySeqId($seq_id);

        $this->authorize('update', $technician);

        // check that userRoleCompany has role of technician
        if(!$technician->isRole('tech')){
            abort(404, 'There is no technician with that id');
        }

        $status = ($request->paid)? 1:0;
        // if he is setting the status to active
        // if is changing the status compared with the one already in database
        // or if admin dosn't pass the checks for subscription and free objects
        if( ($status && ($status != $technician->paid)) && !$company->canAddObject()){
            flash()->overlay("Oops, you need a Pro account.",
                    "You ran out of your {$company->free_objects} free users, to activate more users subscribe to Pro account.",
                    'info');
            return redirect()->back()->withInput();
        }

        $technician->fill(array_map('htmlentities', [
            'cellphone' => $request->cellphone,
            'address' => $request->address,
            'about' => $request->about,
        ]));
        // While im using device magic i don't need this
        // $technician->paid = $status;
        // $technician->save();

        $photo = false;
        if($request->photo){
            $technician->images()->delete();
            $photo = $technician->addImageFromForm($request->file('photo'));
        }

        flash()->success('Updated', 'Technician successfully updated.');
        return redirect('technicians/'.$seq_id);
    }

    public function updatePassword(Request $request, $seq_id)
    {
        $this->validate($request, [
            'password' => 'required|alpha_dash|confirmed|between:6,200'
        ]);

        $technician = $this->loggedCompany()->userRoleCompanies()->bySeqId($seq_id);

        $this->authorize('update', $technician);

        // check that userRoleCompany has role of technician
        if(!$technician->isRole('tech')){
            abort(404, 'There is no technician with that id');
        }

        $user = $technician->user;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'message' => 'Technician password was updated.'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($seq_id)
    {
        $technician = $this->loggedCompany()->userRoleCompanies()->bySeqId($seq_id);

        $this->authorize('delete', $technician);

        // check that userRoleCompany has role of technician
        if(!$technician->isRole('tech')){
            abort(404, 'There is no technician with that id');
        }

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
