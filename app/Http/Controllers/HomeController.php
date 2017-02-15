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
use App\PRS\Helpers\UserHelpers;

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

    public function emailOptions(string $token)
    {
        if($object = $this->urlSigner->validateToken($token)){

            $user = User::where('email', $object->email)->get()->first();

            // if the user is allready logged in send him to his settings
            if($user == Auth::user()){
                return redirect('/settings');
            }

            $getReportsEmails = $user->notificationSettings->hasPermission('notify_report_created', 'mail');

            return view('extras.emailSettings', compact('getReportsEmails', 'token'));
        }
        return redirect('/login');
    }

    public function changeEmailOptions(Request $request, UserHelpers $userHelpers)
    {
        if($object = $this->urlSigner->validateToken($request->token)){
            $user = User::where('email', $object->email)->get()->first();

            $value = ($request->get_reports_emails) ? true : false;
            $newNotificationNumber = $user->notificationSettings->notificationChanged('notify_report_created', 'mail', $value);
            $user->notify_report_created = $newNotificationNumber;
            if($user->save()){
                $title = 'Email Settings Changed!';
                $isSuccess = true;
                return view('extras.showMessage', compact('title', 'isSuccess'));
            }
            $title = 'Email Settings Where Not Changed!';
            $isSuccess = false;
            return view('extras.showMessage', compact('title', 'isSuccess'));
        }
    }

}
