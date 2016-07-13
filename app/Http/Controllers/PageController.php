<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;

use App\PRS\Traits\ControllerTrait;

use Validator;

use Response;
use Auth;

class PageController extends Controller
{

    /**
     * @var int
     */
    protected $statusCode = 200;

    use ControllerTrait;


}
