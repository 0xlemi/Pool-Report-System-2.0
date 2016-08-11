<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Validator;

use App\Setting;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\SupervisorsController;
use App\Http\Controllers\Api\TechniciansController;
use App\Http\Controllers\Api\AdministratorsController;
use App\PRS\Traits\Controller\SettingsControllerTrait;

class SettingsController extends ApiController
{
    private $administratorsController;
    private $supervisorsController;
    private $techniciansController;
    private $settingsController;

    use SettingsControllerTrait;

    public function __construct(
            AdministratorsController $administratorsController,
            SupervisorsController $supervisorsController,
            TechniciansController $techniciansController)
    {
        $this->administratorsController = $administratorsController;
        $this->supervisorsController = $supervisorsController;
        $this->techniciansController = $techniciansController;
    }

    public function account(Request $request){

        // check that the user has permissions
        if($this->getUser()->cannot('account', Setting::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this.');
        }

        $user = $this->getUser();
        $object = $user->userable();
        if($user->isAdministrator())
        {
            return $this->administratorsController->update($request);    
        }elseif($user->isSupervisor())
        {
            return $this->supervisorsController->update($request, $object->seq_id, false);
        }elseif($user->isTechnician())
        {
            return $this->techniciansController->update($request, $object->seq_id, false);
        }

        return $this->respondInternalError('Account settings were not updated, there was an error.');
    }


}
