<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PRS\Classes\Logged;
use App\PRS\Transformers\CompanyTransformer;

class CompanyController extends ApiController
{

    protected $transformer;

    public function __construct(CompanyTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function show()
    {
        $company = Logged::company();
        if(Logged::user()->cannot('view', $company))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. Only System Admin can do this.');
        }

        return response()->json([
                    'data' => $this->transformer->transform($company)
                ]);
    }

    public function destroy(Request $request)
    {
        $this->validate($request, [
          'password' => 'required|string|max:200',
        ]);

        $user = Logged::user();
        $company = Logged::company();
        if($user->cannot('delete', $company))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. Only System Admin can do this.');
        }

        if(!$user->checkPassword($request->password)){
            sleep(6); // avoid password fishing
            return response()->json([
                'error' => 'Company not deleted, the password is wrong.'
            ], 400);
        }

        if($company->delete()){
            return $this->respondWithSuccess('Company was successfully deleted');
        }

        return $this->respondNotFound('Company with that id, does not exist.');

    }

}
