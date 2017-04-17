<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\UserRoleCompany;

class UserRoleCompanyController extends Controller
{

    public function change(Request $request, $id)
    {
        $user = $request->user();
        try {
            $userRoleCompany = $user->userRoleCompanies()->where('user_role_company.id', $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return request()->json([ 'error' => 'Logged user don\'t have UserRoleCompany with that Id'], 401);
        }

        if($user->selectUserRoleCompany($userRoleCompany)){
            return redirect('/dashboard');
        }
            return back();
    }

}
