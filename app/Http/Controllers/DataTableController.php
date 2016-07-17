<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;

use Yajra\Datatables\Facades\Datatables;

use App\Service;
use App\Technician;

use App\PRS\Helpers\ReportHelpers;
use App\PRS\Helpers\ServiceHelpers;
use App\PRS\Helpers\ClientHelpers;

use App\Http\Requests;

class DataTableController extends PageController
{

    protected $reportHelpers;
    protected $serviceHelpers;
    protected $clientHelpers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ReportHelpers $reportHelpers, ServiceHelpers $serviceHelpers, ClientHelpers $clientHelpers)
    {
        $this->middleware('auth');
        $this->reportHelpers = $reportHelpers;
        $this->serviceHelpers = $serviceHelpers;
        $this->clientHelpers = $clientHelpers;
    }

    public function reports(Request $request)
    {
        if(!validateDate($request->date))
        {
            return Response::json('Date is not valid', 422);
        }

        $reports = $this->loggedUserAdministrator()
                    ->reportsByDate($request->date)
                    ->get()
                    ->transform(function($item){
                        $service = Service::find($item->service_id);
                        $technician = Technician::find($item->technician_id);
                        return (object) array(
                            'id' => $item->seq_id,
                            'service' => $service->name,
                            'on_time' => $this->reportHelpers->styleOnTime($item->on_time),
                            'technician' => $technician->name.' '.$technician->last_name,
                        );
                    });

        return Response::json($reports, 200);
    }

    public function services()
    {
        $services = $this->loggedUserAdministrator()
                        ->services()
                        ->get()
                        ->transform(function($item){
                            return (object) array(
                                'id' => $item->seq_id,
                                'name' => $item->name,
                                'address' => $item->address_line,
                                'type' => $this->serviceHelpers->get_styled_type($item->type),
                                'serviceDays' => $this->serviceHelpers
                                                    ->get_styled_service_days($item->service_days),
                                'price' => $item->amount.' <strong>'.$item->currency.'</strong>',
                            );
                        });
        return Response::json($services, 200);
    }

    public function clients()
    {
        $clients = $this->loggedUserAdministrator()
                        ->clients()
                        ->get()
                        ->transform(function($item){
                            return (object) array(
                                'id' => $item->seq_id,
                                'name' => $item->name.' '.$item->last_name,
                                'email' => $item->user()->email,
                                'type' => $this->clientHelpers->styledType($item->type, true, false),
                                'cellphone' => $item->cellphone,
                            );
                        });
        return Response::json($clients, 200);
    }

}
