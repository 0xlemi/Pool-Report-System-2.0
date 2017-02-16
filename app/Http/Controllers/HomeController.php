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
            $notifications = $user->notificationSettings->getAll();

            return view('extras.emailSettings', compact('notifications', 'token'));
        }
        return redirect('/login');
    }

    public function changeEmailOptions(Request $request, UserHelpers $userHelpers)
    {
        if($object = $this->urlSigner->validateToken($request->token)){
            $user = User::where('email', $object->email)->get()->first();

            $validNames = $user->notificationSettings->validNames();
            $requestNames = array_keys($request->except('token','_token'));

            // validate that the names sent are real notification settings
            foreach ($requestNames as $name) {
                if(!in_array($name, $validNames)){
                    $this->urlSigner->removeSigner($request->token);
                    return response("Something funny is going on, go away.", 422);
                }
            }
            // run though all the valid notification
            // set true or false depending if was sent in the request
            foreach ($validNames as $validName) {
                $value = in_array($validName, $requestNames);
                $newNumber = $user->notificationSettings->notificationChanged($validName, 'mail', $value);
                $user->$validName = $newNumber;
            }

            if($user->save()){
                $title = 'Email Settings Changed!';
                $isSuccess = true;
                $this->urlSigner->removeSigner($request->token);
                return view('extras.showMessage', compact('title', 'isSuccess'));
            }
            $title = 'Email Settings Where Not Changed!';
            $isSuccess = false;
            return view('extras.showMessage', compact('title', 'isSuccess'));
        }
    }

}
