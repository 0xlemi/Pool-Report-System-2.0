<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Service;
use App\PRS\Transformers\FrontEnd\DataTables\ServiceDatatableTransformer;

class MissingServicesController extends PageController
{

    public function index(Request $request, ServiceDatatableTransformer $transformer)
    {
        $this->authorize('list', Service::class);

        $this->validate($request,[
            'date' => 'date_format:Y-m-d',
        ]);

        $company = $this->loggedCompany();
        $date = Carbon::today();
        if($request->has('date')){
            $date = Carbon::parse($request->date);
        }

        if($history = $company->missingHistories()->byDate($date)){
            $numServicesMissing = $history->num_services_missing;
            $numServicesDone = $history->num_services_done;
            $services = $history->services;
        }else{
            $numServicesMissing = $company->numberServicesMissing($date);
            $numServicesDone = $company->numberServicesDoIn($date) - $numServicesMissing;
            $services = $company->servicesDoIn($date);
        }

        return response()->json([
            'services' => $transformer->transformCollection($services),
            'numServicesMissing' => $numServicesMissing,
            'numServicesDone' => $numServicesDone,
        ]);

    }

}
