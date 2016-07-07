<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;

use Validator;

use Response;
use Auth;

class PageController extends Controller
{


    public function loggedUserAdministrator()
    {
        $user = Auth::user();
        if($user->isAdministrator()){
            return $user->userable();
        }
        return $user->userable()->admin();
    }

}
