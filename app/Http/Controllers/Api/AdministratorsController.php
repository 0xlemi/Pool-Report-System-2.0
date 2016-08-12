<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Validator;
use DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PRS\Transformers\AdministratorTransformer;
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
                    'email' => 'required|email|max:255|unique:users,email',
                    'password' => 'required|string|between:6,255',
                    'timezone' => 'required|string|between:3,255',
                    'companyName' => 'required|between:2,30',
                    'website' => 'regex:/^([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
                    'facebook' => 'string|max:50',
                    'twitter' => 'string|max:15',
                    'language' => 'string|size:2',
                    'getReportsEmails' => 'boolean',
                    'photo' => 'mimes:jpg,jpeg,png',
                ]);

        // ***** Persiting *****
        $user = DB::transaction(function () use($request) {
            // create Supervisor
            $admin = Administrator::create([
                'name' => $request->name,
                'timezone' => $request->timezone,
                'company_name' => $request->companyName,
                'website' => $request->website,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'language' => $request->language,
            ]);

            // Optional values
            if(isset($request->getReportsEmails)){ $admin->get_reports_emails = $request->getReportsEmails; }
            $admin->save();

            // create User
            $user = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'api_token' => str_random(60),
                'userable_type' => 'App\Administrator',
                'userable_id' => $admin->id,
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    }

    /**
     * Update the specified resource in storage.
     * This Function should not be accessed from Routes
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // check if is administrator
        $user = $this->getUser();
        if(!$user->isAdministrator()){
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. Only system administrators');
        }

        // Validation
            $this->validate($request, [
                'name' => 'between:2,45',
                'email' => 'email|max:255|unique:users,email,'.$user->userable_id.',userable_id',
                'password' => 'string|between:6,255',
                'timezone' => 'string|between:3,255',
                'companyName' => 'between:2,30',
                'website' => 'regex:/^([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
                'facebook' => 'string|max:50',
                'twitter' => 'string|max:15',
                'language' => 'string|size:2',
                'getReportsEmails' => 'boolean',
                'photo' => 'mimes:jpg,jpeg,png',
            ]);

            $admin = $user->userable();

            // ***** Persisting *****
            $report = DB::transaction(function () use($request, $admin, $user) {

                if(isset($request->timezone)){ $admin->timezone = $request->timezone; }
                if(isset($request->company)){ $admin->company_name = $request->company; }
                if(isset($request->website)){ $admin->website = $request->website; }
                if(isset($request->facebook)){ $admin->facebook = $request->facebook; }
                if(isset($request->twitter)){ $admin->twitter = $request->twitter; }
                if(isset($request->name)){ $admin->name = $request->name; }
                if(isset($request->language)){ $admin->language = $request->language; }
                if(isset($request->getReportsEmails)){ $admin->get_reports_emails = $request->getReportsEmails; }

                if(isset($request->email)){ $user->email = $request->email; }
                if(isset($request->password)){ $user->password = bcrypt($request->password); }

                $admin->save();
                $user->save();

                // add photo
                if($request->photo){
                    $admin->images()->delete();
                    $admin->addImageFromForm($request->file('photo'));
                }
            });

            $message = 'Administrator account settings where updated';
            if($request->password){
                $message = 'Administrator account settings and password where updated';
            }
            return $this->respondPersisted(
                            $message,
                            $this->adminTransformer->transform($admin)
                        );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
