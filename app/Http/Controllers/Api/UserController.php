<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PRS\Transformers\UserTransformer;
use Auth;

class UserController extends Controller
{

  protected $userTransformer;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(UserTransformer $userTransformer)
  {
      $this->middleware(['api', 'auth:api']);
      $this->userTransformer = $userTransformer;
  }

  /**
   * Get the information of the current user logged in
   * @return [type] [description]
   */
  public function information()
  {
    return Auth::guard('api')->user();
  }


  public function services()
  {
    $user = Auth::user();
    return $user->services;
  }




}
