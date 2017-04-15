<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Mail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;
use App\Http\Controllers\Controller;
use App\Mail\SendVerificationToken;
use App\Mail\WelcomeVerificationMail;
use App\VerificationToken;

class VerificationController extends Controller
{
    public function activate(VerificationToken $token)
    {
        $userRoleCompany = $token->userRoleCompany;
        if($userRoleCompany->isRole('admin')){
            $user = $userRoleCompany->user;

            $user->verified = 1;
            $user->save();

            $user->selectUserRoleCompany($userRoleCompany);

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
            $token = VerificationToken::where('token', $request->token)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return response("Verification Token don't match.", 403);
        }

        $userRoleCompany = $token->userRoleCompany;
        $user = $userRoleCompany->user;
        $user->verified = 1;
        $user->password = bcrypt($request->password);
        $user->save();

        $user->selectUserRoleCompany($userRoleCompany);

        $token->delete();

        Auth::login($user);

        return redirect('/dashboard');
    }

    // ******* Needs to work with UserRoleCompany
    // public function resend(Request $request)
    // {
    //     $this->validate($request, [
    //         'email' => 'required|email|exists:users,email'
    //     ]);
    //
    //     $user = User::where('email', $request->email)->first();
    //
    //     // check if the user is activated (email verification)
    //     if($user->verified){
    //         return redirect('/login')
    //             ->withInfo('Your account is already verified, just login.');
    //     }
    //
    //     if($request->wantsJson() && $user->verificationToken){
    //         $hoursSinceSent = Carbon::parse($user->verificationToken->created_at)->diffInHours();
    //         if($hoursSinceSent < 24){
    //             $hoursLeft = 24 - $hoursSinceSent;
    //             return response("You Need to wait {$hoursLeft} hours, for you to be able to send another verification email. (spam protection)", 409);
    //         }
    //     }
    //
    //     if($user->verificationToken){
    //         $token = $user->verificationToken;
    //     }else{
    //         $token = $user->verificationToken()->create([
    //             'token' => str_random(128),
    //         ]);
    //     }
    //
    //     if($user->isAdministrator()){
    //         Mail::to($user)->send(new SendVerificationToken($token));
    //     }
    //     else{
    //         if($request->wantsJson()){
    //             Mail::to($user)->send(new WelcomeVerificationMail($token, $user->userable()->admin()));
    //         }
    //     }
    //
    //     return redirect('/login')->withInfo('Email sent, please check your inbox and verify your account.');
    // }

}
