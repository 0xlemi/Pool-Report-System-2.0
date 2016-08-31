<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\PageController;
use Illuminate\Http\Request;

use Auth;
use DB;
use Carbon\Carbon;
use App\User;
use App\PRS\Classes\UrlSigner;

class HomeController extends PageController
{

    private $urlSigner;

    public function __construct(UrlSigner $urlSigner)
    {
        $this->urlSigner = $urlSigner;
    }

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

    public function unsubscribeEmail(string $token)
    {
        if($object = $this->urlSigner->validateToken($token)){
            $user = User::where('email', $object->email)->get()->first();

            $getReportsEmails = $user->userable()->get_reports_emails;
            
            return view('extras.unsubscriptionEmail', compact('getReportsEmails'));
        }
        return redirect('/login');
    }

    public function makeLink()
    {
        $user = User::find(1);
        $this->urlSigner->create($user, 2);
    }

}
