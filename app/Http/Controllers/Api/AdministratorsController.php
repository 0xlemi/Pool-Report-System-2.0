<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Validator;
use DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PRS\Transformers\AdministratorTransformer;
use App\PRS\Traits\Controller\SettingsControllerTrait;
use App\Administrator;
use App\User;

class AdministratorsController extends ApiController
{

    private $adminTransformer;

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(AdministratorTransformer $adminTransformer)
    {
        $this->adminTransformer = $adminTransformer;
    }

    /**
     * Store a newly created resource in storage.
     * This is an open function (no one is logged in)
     * There is no permission checking, anyone can sign up.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $this->validate($request, [
            'name' => 'required|between:2,45',
            'timezone' => 'required|string|validTimezone',
            'company_name' => 'required|between:2,30',
            'website' => 'regex:/^([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'facebook' => 'string|max:50',
            'twitter' => 'string|max:15',
            'language' => 'string|size:2',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|between:6,255',
            'photo' => 'mimes:jpg,jpeg,png',
        ]);

        // ***** Persiting *****
        $user = DB::transaction(function () use($request) {
            // create Supervisor
            $admin = Administrator::create(array_map('htmlentities', $request->all()));

            // create User
            $user = $admin->user()->create([
                'email' => htmlentities($request->email),
                'password' => bcrypt($request->password),
                'api_token' => str_random(60),
            ]);

            // add photo
            if($request->photo){
                $photo = $supervisor->addImageFromForm($request->file('photo'));
            }

            return $user;
        });

        return $this->respond([
            'message' => 'Your Account was successfully created.',
            'api_token' => $user->api_token,
        ]);

    }


}
