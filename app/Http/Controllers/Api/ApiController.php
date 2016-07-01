<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;

use Validator;

use Response;
use Auth;

class ApiController extends Controller
{

    /**
     * @var int
     */
    protected $statusCode = 200;




    /**
     * Get the value of Status Code
     *
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set the value of Status Code
     *
     * @param mixed statusCode
     *
     * @return self
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function respondWithSuccess($message)
    {
        return $this->respond([
            'success' => [
                'message' => $message,
            ]
        ]);
    }

    public function respondNotFound($message = 'Not Found!'){
        return $this->setStatusCode(404)->respondWithError($message);
    }

    public function respondInternalError($message = 'Internal Error!'){
        return $this->setStatusCode(500)->respondWithError($message);
    }

    public function respondPersisted($message, $object){
        return $this->respond([
            'message' => $message,
            'object' => $object,
        ]);
    }

    public function respondWithError($message, $errors = []){
        return $this->respond([
            'error' => [
                'message' => $message,
                'errors' => $errors,
            ]
        ]);
    }

    public function respond($data, $headers = []){
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    public function loggedUserAdministrator()
    {
        $user = Auth::guard('api')->user();
        if($user->isAdministrator()){
            return $user->userable();
        }
        return $user->userable()->admin();
    }

    // public function checkValidation($validator)
    // {
    //     if ($validator->fails()) {
    //         // return error response
    //         return $this->setStatusCode(422)->RespondWithError('Paramenters failed validation.', $validator->errors()->toArray());
    //     }
    // }

}
