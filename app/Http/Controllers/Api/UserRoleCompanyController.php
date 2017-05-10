<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\PRS\Transformers\UserRoleCompanyTransformer;
use App\PRS\Transformers\PreviewTransformers\UserRoleCompanyPreviewTransformer;
use App\PRS\Classes\Logged;

use App\Service;
use App\User;
use App\Role;

use Validator;
use DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\UserRoleCompany;
use App\Administrator;

class UserRoleCompanyController extends ApiController
{

    protected $urcTransformer;
    protected $urcPreviewTransformer;

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(UserRoleCompanyTransformer $urcTransformer, UserRoleCompanyPreviewTransformer $urcPreviewTransformer)
    {
        $this->urcTransformer = $urcTransformer;
        $this->urcPreviewTransformer = $urcPreviewTransformer;
    }

    /**
     * Display a listing of the resource.
     * tested
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'limit' => 'integer|between:1,25',
            'preview' => 'boolean',
            'role' => 'string|validRole',
        ]);

        if(Logged::user()->cannot('list', [UserRoleCompany::class, $request->role]))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        // make a preview transformation
        if($request->preview){
            return $this->indexPreview($request);
        }

        $limit = ($request->limit)?: 5;

        $urcs = Logged::company()->userRoleCompanies();
        if($request->has('role')){
            $urcs = $urcs->ofRole($request->role);
        }
        $urcs = $urcs->seqIdOrdered()->paginate($limit);

        return $this->respondWithPagination(
            $urcs,
            $this->urcTransformer->transformCollection($urcs)
        );
    }

    protected function indexPreview(Request $request)
    {
        $urcs = Logged::company()->userRoleCompanies();
        if($request->has('role')){
            $urcs = $urcs->ofRole($request->role);
        }
        $urcs = $urcs->seqIdOrdered()->get();

        return $this->respond([
                'data' => $this->urcPreviewTransformer->transformCollection($urcs)
            ]);
    }

    /**
     * Store a newly created resource in storage.
     * tested
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = Logged::company();
        $this->validate($request, [
            'name' => 'required|string|max:25',
            'last_name' => 'required|string|max:40',
            'email' => 'required|email',
            'language' => 'required|string|max:2',

            'cellphone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'about' => 'string|max:1000',

            'type' => 'required|integer',
            'role' => 'required|string|validRole',

            'add_services' => 'array',
            'add_services.*' => 'required|integer|existsBasedOnCompany:services,'.$company->id,
            'photo' => 'mimes:jpg,jpeg,png',
        ]);

        if(Logged::user()->cannot('create', [UserRoleCompany::class, $request->role]))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }


        $user = User::where('email', $request->email)->first();
        $role = Role::where('name', $request->role)->firstOrFail();

        //*****************
        //    Checks
        //*****************
        if($user){
            // Check that there is no other urc with the same user, company and role
            $contains = $company->userRoleCompanies()->where('user_id', '=', $user->id)->get()->contains('role_id', $role->id);
            if($contains){
                return $this->setStatusCode(400)->respondWithError('There is already another UserRoleCompany with that same User, Company and Role. That is not permited');
            }
        }
        // There can only be one System Administrator per Company
        $companyHasAdmin = $company->userRoleCompanies->contains('role_id', 1);
        if($companyHasAdmin && ($role->name == 'admin')){
            return $this->setStatusCode(400)->respondWithError('There is already a System Administrator for this company. There can only be one.');
        }

        //*****************
        //    Persist
        //*****************
        $urc = DB::transaction(function () use($request, $company, $user, $role){

            if($user == null){
                // Create the user
                $user = User::create(
                    array_map('htmlentities', $request->except('add_services', 'photo'))
                );
            }

            // Create UserRoleCompany
            $urc = $user->userRoleCompanies()->create(
                        array_map('htmlentities', [
                            'type' => $request->type,
                            'cellphone' => $request->cellphone,
                            'address' => $request->address,
                            'about' => $request->about,
                            'role_id' => $role->id,
                            'company_id' => $company->id,
                        ])
                    );

            if(isset($request->add_services)){ $urc->setServices($request->add_services);}

            // Add Photo to UserRoleCompany
            if($request->photo){
                $photo = $urc->addImageFromForm($request->file('photo'));
            }

            return $urc;
        });

        // throw a success message
        return $this->respondPersisted(
            'The user role company was successfuly created.',
            $this->urcTransformer->transform(UserRoleCompany::find($urc->id))
        );

    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($seq_id)
    {
        try {
            $urc = Logged::company()->userRoleCompanies()->bySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('UserRoleCompany with that id, does not exist.');
        }

        if(Logged::user()->cannot('view', $urc))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if($urc){
            return $this->respond([
                'data' => $this->urcTransformer->transform($urc),
            ]);
        }

        return $this->respondNotFound('UserRoleCompany with that id, does not exist.');
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $seq_id)
    {
        $company = Logged::company();
        try {
            $urc = $company->userRoleCompanies()->bySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('UserRoleCompany with that id, does not exist.');
        }

        if(Logged::user()->cannot('update', $urc))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        // ***** Validation *****
            $this->validate($request, [
                'type' => 'integer',
                'cellphone' => 'string|max:20',
                'address' => 'string|max:255',
                'about' => 'string|max:1000',

                'add_services' => 'array',
                'add_services.*' => 'required|integer|existsBasedOnCompany:services,'.$company->id,
                'remove_services' => 'array',
                'remove_services.*' => 'required|integer|existsBasedOnCompany:services,'.$company->id,

                'photo' => 'mimes:jpg,jpeg,png',

            ]);
        // end validation

        // ***** Persiting to the database *****
        $transaction = DB::transaction(function () use($request, $urc) {

            // set user role company values
            $urc->fill(array_map('htmlentities', [
                'type' => $request->type,
                'cellphone' => $request->cellphone,
                'address' => $request->address,
                'about' => $request->about,
            ]));

            if(isset($request->add_services)){ $urc->setServices($request->add_services); }
            if(isset($request->remove_services)){ $urc->unsetServices($request->remove_services); }

            // set photo
            if($request->photo){
                $urc->deleteImages();
                $photo = $urc->addImageFromForm($request->file('photo'));
            }

            $urc->save();

        });
        // end persistance

        // success message
        return $this->respondPersisted(
            'The user role company was successfully updated.',
            $this->urcTransformer->transform(UserRoleCompany::find($urc->id))
        );
    }

    /**
     * Remove the specified resource from storage.
     * tested
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($seq_id)
    {
        try {
            $urc = Logged::company()->userRoleCompanies()->bySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('UserRoleCompany with that id, does not exist.');
        }

        if(Logged::user()->cannot('delete', $urc))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if($urc->delete()){
            return $this->respondWithSuccess('UserRoleCompany was successfully deleted');
        }

        return $this->respondNotFound('UserRoleCompany with that id, does not exist.');
    }

}
