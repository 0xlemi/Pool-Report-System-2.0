<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Service;

class MissingServicesController extends PageController
{

    public function index(Request $request)
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

        $numServicesMissing = $admin->numberServicesMissing($date);
        $numServicesDone = $admin->numberServicesDoIn($date) - $numServicesMissing;

        $services = $this->loggedUserAdministrator()
                        ->servicesDoIn($date)
                        ->transform(function($service){
                            return (object) [
                                'id' => $service->seq_id,
                                'name' => $service->name,
                                'address' => $service->address_line,
                                'serviceDays' => $service->serviceContract->serviceDays()->shortNamesStyled(),
                                'price' => $service->serviceContract->amount.' <strong>'.$service->serviceContract->currency.'</strong>',
                            ];
                        })
                        ->flatten(1);

        return response()->json([
            'services' => $services,
            'numServicesMissing' => $numServicesMissing,
            'numServicesDone' => $numServicesDone,
        ]);
    }

}
