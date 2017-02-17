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
use Validator;
use App\Service;
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
        if($user->isAdministrator()){
            return $this->administratorsController->show();
        }elseif($user->isSupervisor()){
            return $this->supervisorsController->show($user->userable()->seq_id, false);
        }elseif($user->isTechnician()){
            return $this->techniciansController->show($user->userable()->seq_id, false);
        }

        return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this.');
    }

    public function update(Request $request){

        $user = $this->getUser();
        if($user->isAdministrator())
        {
            return $this->administratorsController->update($request);
        }elseif($user->isSupervisor())
        {
            return $this->supervisorsController->update($request, $user->userable()->seq_id, false);
        }elseif($user->isTechnician())
        {
            return $this->techniciansController->update($request, $user->userable()->seq_id, false);
        }

        return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this.');
    }

    public function todaysRoute()
    {
        if($this->getUser()->cannot('list', Service::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

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
                'type' => $this->userHelpers->styledType($user->userable_type, true),
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
