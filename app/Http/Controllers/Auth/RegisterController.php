<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Auth;
use App\Http\Controllers\Controller;
use App\UserRoleCompany;
use App\Company;
use App\Administrator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'company_name' => 'required|max:255',
            'timezone' => 'required|validTimezone',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|alpha_dash|between:6,200'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $company = Company::create([
            'name' => $data['company_name'],
            'timezone' => $data['timezone'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
        $user->password = bcrypt($data['password']);
        $user->save();

        $urc = $company->userRoleCompanies()->create([
            'user_id' => $user->id,
            'role_id' => 1,
            'about' => "System Administrator of {$company->name}"
        ]);

        return $user;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $timezoneList = timezoneList();
        return view('auth.register', compact('timezoneList'));
    }

/**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        Auth::logout();

        return redirect('/login')->withInfo('Email sent, please check your inbox and verify your account.');
    }

}
