<?php

namespace App\Http\Controllers\Stripe;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;

class ConnectController extends Controller
{

    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function redirectToProvider()
    {
        return Socialite::with('stripe')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        $user = Socialite::driver('google')->user();
        dd($user);
    }

}
