<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

class UserApiController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware(['api', 'auth:api']);
  }

  /**
   * Get the information of the current user logged in
   * @return [type] [description]
   */
  public function information()
  {
    return Auth::guard('api')->user();
  }




}
