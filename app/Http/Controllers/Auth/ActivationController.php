<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ActivationToken;

class ActivationController extends Controller
{
    public function activate(ActivationToken $token)
    {
        $token->user()->update([
            'activated' => true
        ]);

        $token->delete();

        Auth::login($token->user);

        return redirect('/');
    }

    public function resend(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

    }

}
