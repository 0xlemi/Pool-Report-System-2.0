<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Validator;

use App\Setting;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\SupervisorsController;
use App\Http\Controllers\Api\TechniciansController;
use App\PRS\Transformers\AdministratorTransformer;
use App\PRS\Traits\Controller\SettingsControllerTrait;

class SettingsController extends ApiController
{
    private $administratorTransformer;
    private $supervisorsController;
    private $techniciansController;
    private $settingsController;

    use SettingsControllerTrait;

    public function __construct(
            AdministratorTransformer $administratorTransformer,
            SupervisorsController $supervisorsController,
            TechniciansController $techniciansController)
    {
        $this->administratorTransformer = $administratorTransformer;
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
            // Validate administrator
            $validator = Validator::make($request->all(), [
                'name' => 'between:2,45',
                'language' => 'string|size:2',
                'getReportsEmails' => 'boolean',
                'email' => 'email|max:255|unique:users,email,'.$user->userable_id.',userable_id',
                'password' => 'string|between:6,255',
                'timezone' => 'string|between:3,255',
                'company_name' => 'between:2,30',
                'website' => 'regex:/^([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
                'facebook' => 'string|max:50',
                'twitter' => 'string|max:15',
            ]);
            if($validator->fails()) {
                // return error responce
                return $this->setStatusCode(422)
                    ->RespondWithError(
                        'Paramenters failed validation.',
                        $validator->errors()->toArray()
                    );
            }

            // Persist Administrator
            if(isset($request->timezone)){ $object->timezone = $request->timezone; }
            if(isset($request->company)){ $object->company_name = $request->company; }
            if(isset($request->website)){ $object->website = $request->website; }
            if(isset($request->facebook)){ $object->facebook = $request->facebook; }
            if(isset($request->twitter)){ $object->twitter = $request->twitter; }
            if(isset($request->name)){ $object->name = $request->name; }
            if(isset($request->language)){ $object->language = $request->language; }
            if(isset($request->getReportsEmails)){ $object->get_reports_emails = $request->getReportsEmails; }
            if(isset($request->email)){ $user->email = $request->email; }
            if(isset($request->password)){ $user->password = bcrypt($request->password); }

            // get the administratorTransformer
            $transformer = $this->administratorTransformer;
        }elseif($user->isSupervisor())
        {
            return $this->supervisorsController->update($request, $object->seq_id, false);
        }elseif($user->isTechnician())
        {
            return $this->techniciansController->update($request, $object->seq_id, false);
        }else
        {
            return $this->respondInternalError();
        }

        if($object->save() && $user->save()){
            $message = 'Account settings where updated';
            if($request->password){
                $message = 'Account setting and password where updated';
            }
            return $this->respondPersisted($message,
                                $transformer->transform($object));
        }
        return $this->respondInternalError('Account settings were not updated, there was an error.');
    }


}
