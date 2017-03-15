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

        $admin = $this->loggedUserAdministrator();
        $date = Carbon::today();
        if($request->has('date')){
            $date = Carbon::parse($request->date);
        }

        if($history = $admin->missingHistoriesByDate($date)){
            $numServicesMissing = $history->num_services_missing;
            $numServicesDone = $history->num_services_done;
            $services = $history->services;
        }else{
            $numServicesMissing = $admin->numberServicesMissing($date);
            $numServicesDone = $admin->numberServicesDoIn($date) - $numServicesMissing;
            $services = $this->loggedUserAdministrator()->servicesDoIn($date);
        }

        return response()->json([
            'services' => $transformer->transformCollection($services),
            'numServicesMissing' => $numServicesMissing,
            'numServicesDone' => $numServicesDone,
        ]);

    }

}
