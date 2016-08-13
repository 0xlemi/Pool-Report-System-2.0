<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PRS\Transformers\UserTransformer;
use App\PRS\Transformers\ServiceTransformer;
use App\User;
use Auth;
use Validator;
use Carbon\Carbon;

class UserController extends ApiController
{

    protected $userTransformer;
    private $serviceTransformer;

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(UserTransformer $userTransformer,
                                ServiceTransformer $serviceTransformer)
    {
        $this->userTransformer = $userTransformer;
        $this->serviceTransformer = $serviceTransformer;
    }

    /**
    * Get the information of the current user logged in
    * @return [type] [description]
    */
    public function information()
    {
        $user = $this->getUser();

        if($user->isAdministrator()){

        }elseif($user->isSupervisor()){

        }elseif($user->isTechnician()){

        }else{
            return $this->respondInternalError();
        }



    }

    public function todaysRoute()
    {
        $user = $this->getUser();
        if(!($user->isAdministrator() || $user->isTechnician() || $user->isSupervisor())){
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this.');
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


    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        $user = User::where('email', $request->email)->first();

        if($user && $user->checkPassword($request->password)){
            return $this->respond([
                'message' => 'logged in successfull.',
                'api_token' => $user->api_token,
            ]);
        }
        return $this->setStatusCode(401)->respond([
            'message' => 'Email or/and Password are incorrect'
        ]);

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
