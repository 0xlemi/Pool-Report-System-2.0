<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;

use App\PRS\Traits\ControllerTrait;
use App\PRS\Classes\Logged;

use Validator;

use Response;
use Auth;

class PageController extends Controller
{

    use ControllerTrait;

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

    public function respondWithSuccess($message = 'Operation Successfull')
    {
        return $this->respond($message);
    }

    public function respondNotFound($error = 'Not Found!'){
        return $this->setStatusCode(404)->respond($error);
    }

    public function respondInternalError($error = 'Internal Error!'){
        return $this->setStatusCode(500)->respond($error);
    }

    public function respondWithValidationError($error = 'Some or all fields are not correct'){
        return $this->setStatusCode(422)->respond($error);
    }

    public function respondWithError($error = 'Error'){
        return $this->respond($error);
    }

    public function respond($data, $headers = []){
        return Response::json(['data' => $data], $this->getStatusCode(), $headers);
    }


}
