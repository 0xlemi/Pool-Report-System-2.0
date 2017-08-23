<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\UserRoleCompany;
use App\PRS\Classes\Logged;

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

    public function requestValueChange(Request $request, $seq_id)
    {
        $this->middleware('auth');

        $this->validate($request, [
            'name' => 'filled|string|max:30',
            'last_name' => 'filled|string|max:60',
            'email' => 'filled|string|email',
        ]);

        $userRoleCompany = Logged::company()->userRoleCompanies()->bySeqId($seq_id);



    }

}
