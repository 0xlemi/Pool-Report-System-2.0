<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Http\Requests;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * The settings view.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
    	$user = Auth::user();
        return view('user.settings', compact('user'));
    }
}
