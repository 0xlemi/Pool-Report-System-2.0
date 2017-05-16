<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PRS\Transformers\UserTransformer;
use App\PRS\Transformers\ServiceTransformer;
use App\PRS\Helpers\UserHelpers;
use App\PRS\Classes\Logged;
use App\User;
use Auth;
use Mail;
use Validator;
use App\Service;
use App\Mail\SendVerificationToken;
use App\Mail\WelcomeVerificationMail;
use Carbon\Carbon;

class UserController extends ApiController
{

    private $urcController;
    protected $userTransformer;
    private $serviceTransformer;
    private $userHelpers;

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(
                                UserRoleCompanyController $urcController,
                                UserTransformer $userTransformer,
                                ServiceTransformer $serviceTransformer,
                                UserHelpers $userHelpers)
    {
        $this->urcController = $urcController;
        $this->userTransformer = $userTransformer;
        $this->serviceTransformer = $serviceTransformer;
        $this->userHelpers = $userHelpers;
    }

    /**
    * Get the information of the current user logged in
    * @return [type] [description]
    */
    public function show()
    {
        if($urc = Logged::user()->selectedUser){
            return $this->urcController->show($urc->seq_id);
        }
        return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this.');
    }

    public function update(Request $request){

        $this->validate($request, [
            'email' => 'email',
            'name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'language' => 'string|validLanguage',
            'password' => 'alpha_dash'
        ]);

        if($user = Logged::user()){
            $user->update(array_map('htmlentities', $request->all()));
            if($request->has('password')){
                $user->password = bcrypt($request->password);
                $user->save();
            }
            return $this->respondPersisted('The user was updated successfully.', $user);
        }
        return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this.');
    }

    public function notifications(Request $request, UserHelpers $userHelper)
    {
        $this->validate($request, [
            'name' => 'required|max:255|validNotification',
            'type' => 'required|max:255|validNotificationType:name',
            'value' => 'required|boolean'
        ]);

        $user = $this->getUser();
        $name = $request->name;
        $type = $request->type;
        $value = $request->value;

        $newNotificationNumber = $user->notificationSettings->notificationChanged($name, $type, $value);
        $user->$name = $newNotificationNumber;
        $user->save();

        $perssistedArray = $userHelper->notificationPermissonToArray($user->$name);
        $finalValue = $perssistedArray[$userHelper->notificationTypePosition($type)];

        return $this->respondWithSuccess("Notification {$name} of type {$type} has been changed to: {$finalValue}");
    }

    public function constants(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|validConstant'
        ]);
        return response(config('constants.'.$request->name, "Constant Not Found"));
    }

    // public function resendVerificationEmail(Request $request)
    // {
    //     $this->validate($request, [
    //         'email' => 'required|email|exists:users,email',
    //     ]);
    //
    //     $user = User::where('email', $request->email)->first();
    //
    //     // check if the user is activated (email verification)
    //     if($user->verified){
    //         return response('Your account is already verified, just login.', 400);
    //     }
    //
    //     $token = $user->verificationToken()->create([
    //         'token' => str_random(128),
    //     ]);
    //
    //     if($user->isAdministrator){
    //         Mail::to($user)->send(new SendVerificationToken($user->verificationToken));
    //     }
    //     Mail::to($user)->send(new WelcomeVerificationMail($user->verificationToken));
    //
    //     return response('Email sent, please check your inbox and verify your account.', 403);
    //
    // }

}
