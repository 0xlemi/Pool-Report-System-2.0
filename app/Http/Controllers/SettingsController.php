<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

use JavaScript;
use Schema;

use DateTimeZone;
use DateTime;

use App\User;
use App\Administrator;
use App\Setting;

use App\Http\Requests;

class SettingsController extends PageController
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
    public function index()
    {
        $user = $this->getUser();
        // SECURITY BUG, YOU SHOULD NOT SEND ALL THE ADMIN INFORMATION
        $admin = $user->admin();
        $setting = Setting::class;

        $timezones = $this->getTimezone();
        $url = (object) array(
            'permissions' => url('settings/permissions'),
            'email' => url('settings/email'),
        );

        return view('settings.index', compact('user', 'admin', 'timezones', 'setting', 'url'));
    }

    public function account(Request $request)
    {

        if($this->getUser()->cannot('account', Setting::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this.');
        }

        // needs refactor
        $user = $this->getUser();
        if($user->isAdministrator())
        {
            $this->validate($request, [
                'timezone' => 'required|string|between:3,255',
            ]);
            $object = $user->userable();
            $object->timezone = $request->timezone;

        }elseif($user->isSupervisor())
        {
            $this->validate($request, [
                'last_name' => 'required|string|between:2,45',
            ]);
            $object = $user->userable();
            $object->last_name = $request->last_name;

        }elseif($user->isTechnician())
        {
            $this->validate($request, [
                'last_name' => 'required|string|between:2,45',
            ]);
            $object = $user->userable();
            $object->last_name = $request->last_name;

        }

        $this->validate($request, [
            'name' => 'required|between:2,45',
            'language' => 'required|string|size:2',
        ]);


        $object->name = $request->name;
        $object->language = $request->language;

        if($object->save()){
            return $this->respondWithSuccess('Account information was updated successfully.');
        }
        return $this->respondInternalError('Account information was not updated, Please try again later.');
   }

    public function changeEmail(Request $request){

        if($this->getUser()->cannot('changeEmail', Setting::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this.');
        }

        $user = $this->getUser();
        $this->validate($request, [
            'old_password' => 'required|string|max:255',
            'new_email' => 'required|email|max:255|unique:users,email,'.$user->userable_id.',userable_id',
        ]);

        if($user->checkPassword($request->old_password)){
            $user->email = $request->new_email;
            if($user->save()){
                return $this->respondWithSuccess('Email was updated');
            }
            return $this->respondInternalError('Email was not updated, there was an error.');
        }
        return $this->respondWithValidationError('Email was not updated, the information is wrong');
    }

    public function changePassword(Request $request){

        if($this->getUser()->cannot('changePassword', Setting::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this.');
        }

        $this->validate($request, [
          'old_password' => 'required|string|max:255',
          'new_password' => 'required|string|between:6,255',
          'confirm_password' => 'required|string|between:6,255|same:new_password',
        ]);

            $user = $this->getUser();
            if($user->checkPassword($request->old_password)){
                $user->password = bcrypt($request->new_password);
                if($user->save()){
                    return $this->respondWithSuccess('Password was updated');
                }
            return $this->respondInternalError('Password not updated, there was an error.');
         }
         return $this->respondWithValidationError('Password not updated , the information is wrong');
    }

    public function company(Request $request){

        if($this->getUser()->cannot('company', Setting::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this.');
        }

        $this->validate($request, [
            'company_name' => 'required|between:2,30',
            'website' => 'regex:/^([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'facebook' => 'string|max:50',
            'twitter' => 'string|max:15',
        ]);
        $admin = $this->loggedUserAdministrator();

        $admin->company_name = $request->company_name;
        $admin->website = $request->website;
        $admin->facebook = $request->facebook;
        $admin->twitter = $request->twitter;

        if($admin->save()){
            return $this->respondWithSuccess('Company information was updated successfully.');
        }
        return $this->respondInternalError('Company information was not updated, Please try again later.');

    }

    public function email(Request $request)
    {
        if($this->getUser()->cannot('email', Setting::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this.');
        }

        $this->validate($request, [
            'id' => [
                'required',
                'max:255',
                'regex:/\w+\_\w+\_\w+/',
                ],
        ]);

        $person = $this->getUser()->userable();
        $attributes = $person->getAttributes();

        $column_name = $request->id;
        $checked_value = strtolower($request->checked);
        $checked = ($checked_value  == 'true' || $checked_value  == '1') ? false : true;

        //check whether the id they are sending us is a real email preference
        if(isset($attributes[$column_name]))
        {
            $person->$column_name = $checked;
            if($person->save()){
                return $this->respondWithSuccess('Permission has been saved.');
            }
            return $this->respondInternalError('Error while persisting the permission');
        }
        return $this->respondNotFound('There is no permission with that id');


    }

    public function billing(Request $request)
    {

    }



    public function permissions(Request $request)
    {

        if($this->getUser()->cannot('permissions', Setting::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this.');
        }

        $this->validate($request, [
            'id' => [
                'required',
                'max:255',
                'regex:/\w+\_\w+\_\w+/',
                ],
        ]);

        $admin = $this->loggedUserAdministrator();
        $attributes = $admin->getAttributes();

        $column_name = $request->id;
        $checked_value = strtolower($request->checked);
        $checked = ($checked_value  == 'true' || $checked_value  == '1') ? false : true;

        //check whether the id they are sending us is a real permission
        if(isset($attributes[$column_name]))
        {
            $admin->$column_name = $checked;
            if($admin->save()){
                return $this->respondWithSuccess('Permission has been saved.');
            }
            return $this->respondInternalError('Error while persisting the permission');
        }
        return $this->respondNotFound('There is no permission with that id');
    }

    private function getTimezone()
    {
        $regions = array(
            'Africa' => DateTimeZone::AFRICA,
            'America' => DateTimeZone::AMERICA,
            'Antarctica' => DateTimeZone::ANTARCTICA,
            'Aisa' => DateTimeZone::ASIA,
            'Atlantic' => DateTimeZone::ATLANTIC,
            'Europe' => DateTimeZone::EUROPE,
            'Indian' => DateTimeZone::INDIAN,
            'Pacific' => DateTimeZone::PACIFIC
        );
        $timezones = array();
        foreach ($regions as $name => $mask)
        {
            $zones = DateTimeZone::listIdentifiers($mask);
            foreach($zones as $timezone)
            {
        		// Lets sample the time there right now
        		$time = new DateTime(NULL, new DateTimeZone($timezone));
        		// Us dumb Americans can't handle millitary time
        		$ampm = $time->format('H') > 12 ? ' ('. $time->format('g:i a'). ')' : '';
        		// Remove region name and add a sample time
        		$timezones[$name][$timezone] = substr($timezone, strlen($name) + 1) . ' - ' . $time->format('H:i') . $ampm;
        	}
        }
        return $timezones;
    }



}
