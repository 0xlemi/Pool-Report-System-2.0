<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\PRS\Classes\Logged;
use App\PRS\Transformers\ServiceTransformer;
use App\Service;

class TodaysRouteController extends ApiController
{
    protected $serviceTransformer;

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(ServiceTransformer $serviceTransformer)
    {
        $this->serviceTransformer = $serviceTransformer;
    }

    public function index()
    {
        if(Logged::user()->cannot('list', Service::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $company = Logged::company();

        $todayServices = $company->servicesDoToday();
        $numberTotalServices = $company->numberServicesDoToday();
        $numberMissingServices = $todayServices->count();
        return $this->respond(
            [
                'data' => [
                    'numberTotalServicesToday' => $numberTotalServices,
                    'numberServicesDoneToday' => $numberTotalServices - $numberMissingServices,
                    'missingServicesToday' => $this->serviceTransformer->transformCollection($todayServices),
                ]
            ]
        );
    }

}
