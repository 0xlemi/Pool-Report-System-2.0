<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Mail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;
use App\Http\Controllers\Controller;
use App\ActivationToken;
use App\Mail\SendActivationToken;

class ActivationController extends Controller
{
    public function activate(ActivationToken $token)
    {
        $user = $token->user;
        if($user->isAdministrator()){
            $user->activated = 1;
            $user->save();

            $token->delete();
            Auth::login($user);
            return redirect('/dashboard');
        }
        return view('auth.passwords.activation', compact('token'));
    }

    public function setPassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|alpha_dash|confirmed|between:6,100',
            'token' => 'required|string',
        ]);

        try {
            $token = ActivationToken::where('token', $request->token)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return response("Activation Token don't match.", 403);
        }

        $user  = $token->user;
        $user->activated = 1;
        $user->password = bcrypt($request->password);
        $user->save();

        $token->delete();

        Auth::login($user);

        return redirect('/dashboard');
    }

    public function resend(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        // check if the user is activated (email verification)
        if($user->activated){
            return redirect('/login')
                ->withInfo('Your account is already verified, just login.');
        }

        if($request->wantsJson() && $user->activationToken){
            $hoursSinceSent = Carbon::parse($user->activationToken->created_at)->diffInHours();
            if($hoursSinceSent < 24){
                $hoursLeft = 24 - $hoursSinceSent;
                return response("You Need to wait {$hoursLeft} hours, for you to be able to send another activation email. (spam protection)", 409);
            }
        }

        $token = $user->activationToken()->create([
            'token' => str_random(128),
        ]);

        Mail::to($user)->send(new SendActivationToken($user->activationToken));

        return redirect('/login')->withInfo('Email sent, please check your inbox and verify your account.');
    }

}
