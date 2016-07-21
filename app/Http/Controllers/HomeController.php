<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\PageController;
use Illuminate\Http\Request;

use Auth;

class HomeController extends PageController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::check()){
            return view('landing.welcome');
    	}
        $user = $this->getUser();
        return view('home', compact('user'));
    }

}
