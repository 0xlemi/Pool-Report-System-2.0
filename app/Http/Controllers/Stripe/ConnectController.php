<?php

namespace App\Http\Controllers\Stripe;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use App\PRS\Classes\Logged;

class ConnectController extends Controller
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

    public function redirectToProvider()
    {
        if(Logged::user()->selectedUser->isRole('admin')){
            return Socialite::with('stripe')->redirect();
        }
        abort(403, 'You need to be System Administrator to do this operation');
    }

    public function handleProviderCallback()
    {
        if(Logged::user()->selectedUser->isRole('admin')){
            $user = Socialite::driver('stripe')->stateless()->user();
            dd($user);
        }
        abort(403, 'You need to be System Administrator to do this operation');
    }

}
