<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PRS\Classes\Logged;
use App\PRS\Transformers\CompanyTransformer;
use App\Company;

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

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|between:2,30',
            'timezone' => 'required|string|validTimezone',
            'website' => 'regex:/^([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'facebook' => 'string|max:50',
            'twitter' => 'string|max:15',
            'language' => 'string|validLanguage',
            'latitude' => 'numeric|between:-90,90',
            'longitude' => 'numeric|between:-180,180',
        ]);

        $company = Logged::company();
        if(Logged::user()->cannot('view', $company))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. Only System Admin can do this.');
        }

        $company->update($request->all());

        return $this->respondPersisted(
            'The company was successfuly updated.',
            $this->transformer->transform(Company::find($company->id))
        );

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
