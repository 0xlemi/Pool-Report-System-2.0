<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use Validator;
use Carbon\Carbon;

use Yajra\Datatables\Facades\Datatables;

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

        $admin = $this->loggedUserAdministrator();

        $date = (new Carbon($request->date, $admin->timezone));

        $reports =  $admin
                    ->reportsByDate($date)
                    ->get()
                    ->transform(function($item){
                        $service = $item->service();
                        $technician = $item->technician();
                        return (object) array(
                            'id' => $item->seq_id,
                            'service' => $service->name,
                            'on_time' => $this->reportHelpers->styleOnTime($item->on_time),
                            'technician' => $technician->name.' '.$technician->last_name,
                        );
                    });

        return Response::json($reports, 200);
    }

    public function missingServices(Request $request)
    {
        if(!validateDate($request->date))
        {
            return Response::json('Date is not valid', 422);
        }

        $services = $this->loggedUserAdministrator()
                        ->servicesDoIn((new Carbon($request->date)))
                        ->transform(function($service){
                            return (object) array(
                                'id' => $service->seq_id,
                                'name' => $service->name,
                                'address' => $service->address_line,
                                'type' => $this->serviceHelpers->get_styled_type($service->type),
                                'serviceDays' => $this->serviceHelpers
                                                    ->get_styled_service_days($service->service_days),
                                'price' => $service->amount.' <strong>'.$service->currency.'</strong>',
                            );
                        })
                        ->flatten(1);

        return Response::json($services, 200);

    }

    public function missingServicesInfo(Request $request)
    {
        if(!validateDate($request->date))
        {
            return Response::json('Date is not valid', 422);
        }

        $admin = $this->loggedUserAdministrator();

        $date = (new Carbon($request->date));

        $numServicesMissing = $admin->numberServicesMissing($date);
        $numServicesToDo = $admin->numberServicesDoIn($date);
        $numServicesDone = $numServicesToDo - $numServicesMissing;

        $result = (object) array(
            'numServicesMissing' => $numServicesMissing,
            'numServicesToDo' => $numServicesToDo,
            'numServicesDone' => $numServicesDone,
        );

        return Response::json($result, 200);

    }

    public function services(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return Response::json([
                    'message' => 'Paramenters failed validation.',
                    'errors' => $validator->errors()->toArray(),
                ],
                422
            );
        }

        $services = $this->loggedUserAdministrator()
                        ->services()
                        ->get()
                        ->where('status', (int) $request->status)
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
                        })
                        ->flatten(1);
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

    public function supervisors()
    {
        $supervisors = $this->loggedUserAdministrator()
                        ->supervisors()
                        ->get()
                        ->transform(function($item){
                            return (object) array(
                                'id' => $item->seq_id,
                                'name' => $item->name.' '.$item->last_name,
                                'email' => $item->user()->email,
                                'cellphone' => $item->cellphone,
                            );
                        });
        return Response::json($supervisors, 200);
    }

    public function technicians()
    {
        $technicians = $this->loggedUserAdministrator()
                            ->technicians()
                            ->get()
                            ->transform(function($item){
                                $supervisor = $item->supervisor();
                                return (object) array(
                                    'id' =>  $item->seq_id,
                                    'name' => $item->name.' '.$item->last_name,
                                    'username' => $item->user()->email,
                                    'cellphone' => $item->cellphone,
                                    'supervisor' => $supervisor->name.' '.$supervisor->last_name,
                                );
                            });
        return Response::json($technicians, 200);
    }

}
