<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\User;

use App\Http\Requests;

class SettingsController extends Controller
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
        $admin = $user->admin();

        $company_info = (object) array(
            'website' => $user->admin()->website,
            'facebook' => $user->admin()->facebook,
            'twitter' => $user->admin()->twitter,
        );

        return view('settings.settings', compact('user', 'admin', 'company_info'));
    }


    public function updateCompany(Request $request){
      $this->validate($request, [
        'company_name' => 'required|between:2,30',
        'website' => 'regex:/^([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
        'facebook' => 'string|max:50',
        'twitter' => 'string|max:15',
      ]);
      $user = User::findOrFail($request->id);

      $user->company_name = $request->company_name;
      $user->website = $request->website;
      $user->facebook = $request->facebook;
      $user->twitter = $request->twitter;

      $user->save(); // render exceptions later


    }

    public function updateEmail(Request $request){

      $this->validate($request, [
        'old_password' => 'required|string|max:255',
        'new_email' => 'required|email|max:255',
      ]);
      $user = User::findOrFail($request->id);


      dd($request->all());
    }

    public function updatePassword(Request $request){
      $this->validate($request, [
        'old_password' => 'required|string|max:255',
        'new_email' => 'required|email|max:255',
      ]);

      dd($request->all());
    }



}
