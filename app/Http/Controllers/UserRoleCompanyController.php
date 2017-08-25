<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\UserRoleCompany;
use App\PRS\Classes\Logged;
use App\User;

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
        $user = $userRoleCompany->user;

        $values = $request->only(['name', 'last_name', 'email']);
        $valuesNoNulls = array_filter($values, function ($item) {
            return ($item != null);
        });
        $key = array_keys($valuesNoNulls)[0];
        $value = $valuesNoNulls[$key];

        // Check that the email is not already been used
        if(($key == 'email') && User::where('email', $value)->first()){
            return response('Request not sent. That email is already in use. Try a different one.', 400);
        }

        // Check that they dont't have another change request for the same thing
        if($user->requestUserChanges->contains('name', $key)){
            return response('Request not sent. User already has change request for this value.
                                That needs to be resolved before you can send another one.', 400);
        }

        $requestUserChange = $user->requestUserChanges()->create([
            'name' => $key,
            'value' => $value
        ]);

        return response([ 'message' => 'Request value change send successfully.']);
    }

}
