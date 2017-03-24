<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PRS\Transformers\UserTransformer;
use App\PRS\Transformers\ServiceTransformer;
use App\PRS\Helpers\UserHelpers;
use App\User;
use Auth;
use Mail;
use Validator;
use App\Service;
use App\Mail\SendActivationToken;
use App\Mail\WelcomeActivationMail;
use Carbon\Carbon;

class UserController extends ApiController
{

    protected $userTransformer;
    private $serviceTransformer;
    private $administratorsController;
    private $supervisorsController;
    private $techniciansController;
    private $userHelpers;

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(UserTransformer $userTransformer,
                                ServiceTransformer $serviceTransformer,
                                AdministratorsController $administratorsController,
                                SupervisorsController $supervisorsController,
                                TechniciansController $techniciansController,
                                UserHelpers $userHelpers)
    {
        $this->userTransformer = $userTransformer;
        $this->serviceTransformer = $serviceTransformer;
        $this->administratorsController = $administratorsController;
        $this->supervisorsController = $supervisorsController;
        $this->techniciansController = $techniciansController;
        $this->userHelpers = $userHelpers;
    }

    /**
    * Get the information of the current user logged in
    * @return [type] [description]
    */
    public function show()
    {
        $user = $this->getUser();
        if($user->isAdministrator())
        {
            return $this->administratorsController->show();
        }
        elseif($user->isSupervisor())
        {
            return $this->supervisorsController->show($user->userable()->seq_id, false);
        }
        elseif($user->isTechnician())
        {
            return $this->techniciansController->show($user->userable()->seq_id, false);
        }

        return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this.');
    }

    public function update(Request $request){

        $user = $this->getUser();

        $this->validate($request, [
            'password' => 'alpha_dash|between:6,200'
        ]);
        if($user->isAdministrator())
        {
            if($request->has('password')){
                $user->password =  bcrypt($request->password);
            }
            $user->save();
            return $this->administratorsController->update($request);
        }
        elseif($user->isSupervisor())
        {
            if($request->has('password')){
                $user->password =  bcrypt($request->password);
            }
            $user->save();
            return $this->supervisorsController->update($request, $user->userable()->seq_id, false);
        }
        elseif($user->isTechnician())
        {
            if($request->has('password')){
                $user->password =  bcrypt($request->password);
            }
            $user->save();
            return $this->techniciansController->update($request, $user->userable()->seq_id, false);
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

    public function todaysRoute()
    {
        if($this->getUser()->cannot('list', Service::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $admin = $this->loggedUserAdministrator();

        $todayServices = $admin->servicesDoToday();
        $numberTotalServices = $admin->numberServicesDoToday();
        $numberMissingServices = $todayServices->count();
        return $this->respond(
            [
                'data' => [
                    'numberTotalServicesToday' => $numberTotalServices,
                    'numberServicesDoneToday' => $numberTotalServices - $numberMissingServices,
                    'missingServicesToday' => $this->serviceTransformer->transformCollection($todayServices),
                ]
            ]
        );
    }

    public function constants(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|validConstant'
        ]);
        return response(config('constants.'.$request->name, "Constant Not Found"));
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|max:255',
            'password' => 'required|string|between:6,200',
        ]);

        $user = User::where('email', $request->email)->first();


        if($user && $user->checkPassword($request->password)){

            // disable client login
            if($user->isClient()){
                    return response('This app currently does not support client login, you can log in through the web app.', 403);
            }

            // check if the user is active (payed)
            if(!$user->active){
                return response('You cannot login because this user is set to inactive. Ask the system administrator to activate your account.', 402);
            }
            // check if the user is activated (email verification)
            if(!$user->activated){
                return response('You cannot login until you verify your email. Check you inbox.', 403);
            }

            return $this->respond([
                'message' => 'logged in successfull.',
                'type' => $this->userHelpers->styledType($user->userable_type, true),
                'api_token' => $user->api_token,
            ]);
        }
        return $this->setStatusCode(401)->respond([
            'message' => 'Email or/and Password are incorrect'
        ]);

    }

    public function resendVerificationEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // check if the user is activated (email verification)
        if($user->activated){
            return response('Your account is already verified, just login.', 400);
        }

        $token = $user->activationToken()->create([
            'token' => str_random(128),
        ]);

        if($user->isAdministrator){
            Mail::to($user)->send(new SendActivationToken($user->activationToken));
        }
        Mail::to($user)->send(new WelcomeActivationMail($user->activationToken));

        return response('Email sent, please check your inbox and verify your account.', 403);

    }

    public function resetToken()
    {
        $user = $this->getUser();

        $user->api_token = str_random(60);
        if($user->save()){
            return $this->respond([
                'message' => 'Token reset successfull.',
                'api_token' => $user->api_token,
            ]);
        }
        return $this->respondInternalError();
    }




}
