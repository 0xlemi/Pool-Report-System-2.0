<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PRS\Classes\Logged;
use App\PRS\Transformers\PermissionRoleCompanyTransformer;
use App\PRS\Transformers\PermissionTransformer;
use App\Permission;
use App\Role;

class PermissionController extends ApiController
{
    protected $prcTransformer;
    protected $permissionTransformer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PermissionRoleCompanyTransformer $prcTransformer,
                                    PermissionTransformer $permissionTransformer)
    {
        $this->prcTransformer = $prcTransformer;
        $this->permissionTransformer = $permissionTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'limit' => 'integer|between:1,25',
            'role' => 'string|validRole',
        ]);

        $company = Logged::company();

        $limit = ($request->limit)?: 5;

        $permissions = $company->permissionRoleCompanies();
        if($request->has('role')){
            $permissions = $permissions->ofRole($request->role);
        }
        $permissions = $permissions->paginate($limit);

        return $this->respondWithPagination(
            $permissions,
            $this->prcTransformer->transformCollection($permissions)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $this->validate($request, [
            'limit' => 'integer|between:1,25',
        ]);

        $limit = ($request->limit)?: 5;

        $permissions = Permission::query()->paginate($limit);

        return $this->respondWithPagination(
            $permissions,
            $this->permissionTransformer->transformCollection($permissions)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'role' => 'required|string|validRole',
            'element' => 'required|string|validPermissionElement',
            'action' => 'required|string|validPermissionAction',
        ]);

        $company = Logged::company();
        $role = Role::where('name', $request->role)->firstOrFail();
        // check if there is permission with bouth element and action
        $permission = Permission::where('element', '=', $request->element)->where('action', '=', $request->action)->first();
        if(!$permission){
            $this->setStatusCode(400)->respondWithError('There is not permission with that combination of element and action.');
        }

        // check that there is not already a PermissiorRoleCompany with the same Role, Pemission and Company
        if($company->permissionRoleCompanies()->where('permission_id', '=', $permission->id)->get()->contains('role_id', '=', $role->id)){
            return response()->json([ 'message' => 'This Role already has this permission, no need to add it twice.']);
        }

        $prc = $company->permissionRoleCompanies()->create([
            'role_id' => $role->id,
            'permission_id' => $permission->id,
        ]);

        // throw a success message
        return $this->respondPersisted(
            'The permission was added successfuly created.',
            $this->prcTransformer->transform($prc)
        );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $this->validate($request, [
            'role' => 'required|string|validRole',
            'element' => 'required|string|validPermissionElement',
            'action' => 'required|string|validPermissionAction',
        ]);

        $company = Logged::company();
        $role = Role::where('name', $request->role)->firstOrFail();

        // check if there is permission with bouth element and action
        $permission = Permission::where('element', '=', $request->element)->where('action', '=', $request->action)->first();
        if(!$permission){
            $this->setStatusCode(400)->respondWithError('There is not permission with that combination of element and action.');
        }

        // check that there is not already a PermissiorRoleCompany with the same Role, Pemission and Company
        $contains  = $company->permissionRoleCompanies()
                            ->where('permission_id', '=', $permission->id)
                            ->get()->contains('role_id', '=', $role->id);
        return response()->json([ 'data' => $contains]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'role' => 'required|string|validRole',
            'element' => 'required|string|validPermissionElement',
            'action' => 'required|string|validPermissionAction',
        ]);

        $company = Logged::company();
        $role = Role::where('name', $request->role)->firstOrFail();
        // check if there is permission with bouth element and action
        $permission = Permission::where('element', '=', $request->element)->where('action', '=', $request->action)->first();
        if(!$permission){
            $this->setStatusCode(400)->respondWithError('There is not permission with that combination of element and action.');
        }

        $prc = $company->permissionRoleCompanies()
                                ->where('permission_id', '=', $permission->id)
                                ->where('role_id', '=', $role->id)->first();
        // check that there is not already a PermissiorRoleCompany with the same Role, Pemission and Company
        if(!$prc){
            return response()->json([ 'message' => 'This Role dosn\'t have this permission, no need to remove it.']);
        }

        if($prc->delete()){
            return response()->json([ 'message' => 'This Permission was successfully removed']);
        }
        return response()->json([ 'message' => 'This Permission was could not be removed, please try again.'], 500);
    }
}
