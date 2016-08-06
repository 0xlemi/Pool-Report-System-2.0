<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PRS\Transformers\UserTransformer;
use App\User;
use Auth;
use Validator;

class UserController extends ApiController
{

    protected $userTransformer;

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(UserTransformer $userTransformer)
    {
        $this->middleware(['api', 'throttle:10']);
        $this->userTransformer = $userTransformer;
    }

    // /**
    // * Get the information of the current user logged in
    // * @return [type] [description]
    // */
    // public function information()
    // {
    //     $user  = Auth::guard('api')->user();
    //     return $this->userTransformer->transform($user);
    // }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            // return error responce
            return $this->setStatusCode(422)->RespondWithError('Paramenters failed validation.', $validator->errors()->toArray());
        }

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




}
