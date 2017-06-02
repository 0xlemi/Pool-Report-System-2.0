<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\PRS\Classes\Logged;
use App\PRS\Transformers\ServiceTransformer;
use App\Service;
use Carbon\Carbon;

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

    public function index(Request $request)
    {
        if(Logged::user()->cannot('list', Service::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request, [
            'days_from_today' => 'integer|between:0,6'
        ]);

        $daysFromToday = ($request->days_from_today) ?: 0;

        $company = Logged::company();

        $date = Carbon::now($company->timezone)->addDays($daysFromToday);

        $todayServices = $company->servicesDoIn($date);
        $numberTotalServices = $company->numberServicesDoIn($date);
        $numberMissingServices = $todayServices->count();
        return $this->respond(
            [
                'data' => [
                    'date' => $date->toDateString(),
                    'numberTotalServicesToday' => $numberTotalServices,
                    'numberServicesDoneToday' => $numberTotalServices - $numberMissingServices,
                    'missingServicesToday' => $this->serviceTransformer->transformCollection($todayServices),
                ]
            ]
        );
    }

}
