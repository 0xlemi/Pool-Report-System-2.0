<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\PageController;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Auth;
use DB;
use Carbon\Carbon;
use App\User;
use App\PRS\Helpers\UserHelpers;
use App\PRS\Classes\Logged;
use App\UrlSigner;

class HomeController extends PageController
{

    /**
     * Show the landing page, even if he is logged in.
     * @return view
     */
    public function landingPage()
    {
        return view('landing.welcome');
    }

    /**
     * Go to the dashboard
     */
    public function home()
    {
        return redirect('/dashboard');
    }

    /**
     * Show the application dashboard.
     *
     * @return view
     */
    public function dashboard(Request $request)
    {
        $user = $request->user();
        return view('home', compact('user'));
    }

    /**
     * Magic Login
     * @param  string $token
     */
    public function signIn(Request $request, string $token)
    {
        try {
            $signer = UrlSigner::where('token', $token)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect('/login');
        }

        $user = $signer->user;

        $signer->delete();
        Auth::login($user);
        if($request->has('location')){
            return redirect($request->location);
        }
        return redirect('/dashboard');
    }

    public function emailOptions(string $token)
    {
        try {
            $signer = UrlSigner::where('token', $token)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect('/login');
        }

        $user = $signer->user;

        // if the user is allready logged in send him to his settings
        if($user == Logged::user()){
            return redirect('/settings');
        }

        $notifications = $user->selectedUser->allNotificationSettings();

        return view('extras.emailSettings', compact('notifications', 'token'));
    }

    public function changeEmailOptions(Request $request, UserHelpers $userHelpers)
    {
        try {
            $signer = UrlSigner::where('token', $request->token)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect('/login');
        }

        $user = $signer->user;

        $validNames = $user->notificationSettings->validNames();
        $requestNames = array_keys($request->except('token','_token'));

        // validate that the names sent are real notification settings
        foreach ($requestNames as $name) {
            if(!in_array($name, $validNames)){
                $signer->delete();
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
            $signer->delete();
            return view('extras.showMessage', compact('title', 'isSuccess'));
        }
        $title = 'Email Settings Where Not Changed!';
        $isSuccess = false;
        return view('extras.showMessage', compact('title', 'isSuccess'));
    }

    public function terms()
    {
        return view('landing.terms');
    }

    public function features()
    {
        return view('landing.features');
    }

    public function pricing()
    {
        return view('landing.pricing');
    }

    public function tutorials()
    {
        return view('landing.tutorials');
    }

    public function support()
    {
        return view('landing.support');
    }



}
