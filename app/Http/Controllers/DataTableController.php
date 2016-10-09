<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use Validator;
use Carbon\Carbon;


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

    public function workOrders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'finished' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return Response::json([
                    'message' => 'Paramenters failed validation.',
                    'errors' => $validator->errors()->toArray(),
                ],
                422
            );
        }

        $workOrders = $this->loggedUserAdministrator()
                        ->workOrders()
                        ->get()
                        ->where('finished', (int) $request->finished)
                        ->transform(function($item){
                            $supervisor =  $item->supervisor();
                            $timezone = $supervisor->admin()->timezone;
                            return (object) array(
                                'id' => $item->seq_id,
                                'start' => (new Carbon($item->start, 'UTC'))
                                                ->setTimezone($timezone)
                                                ->format('d M Y h:i:s A'),
                                'end' => (new Carbon($item->end, 'UTC'))
                                                ->setTimezone($timezone)
                                                ->format('d M Y h:i:s A'),
                                'price' => $item->price.' <strong>'.$item->currency.'</strong>',
                                'service' => $item->service()->name,
                                'supervisor' => $supervisor->name.' '.$supervisor->last_name,
                            );
                        })
                        ->flatten(1);
        return Response::json($workOrders , 200);
    }

    public function works(int $workOrderSeqId)
    {
        try {
            $workOrder = $this->loggedUserAdministrator()->workOrderBySeqId($workOrderSeqId);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Work Order with that id, does not exist.');
        }

        $works = $workOrder->works()
                    ->get()
                    ->transform(function($item){
                        $service = $item->service();
                        $technician = $item->technician();
                        return [
                            'id' => $item->id,
                            'title' => $item->title,
                            'quantity' => $item->quantity.' '.$item->units,
                            'cost' => $item->cost.' '.$service->currency,
                            'technician' => $technician->name.' '.$technician->last_name,
                        ];
                    });

        return Response::json($works, 200);
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

    public function equipment($service_seq_id)
    {
        try {
            $service = $this->loggedUserAdministrator()->serviceBySeqId($service_seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Service with that id, does not exist.');
        }

        $equipment = $service->equipment()
                        ->get()
                        ->transform(function($item){
                            return (object) array(
                                'id' => $item->id,
                                'kind' => '<strong>'.$item->kind.'</strong>',
                                'type' => $item->type,
                                'brand' => $item->brand,
                                'model' => $item->model,
                                'capacity' => $item->capacity.' '.$item->units,
                            );
                        });
        return Response::json($equipment, 200);
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

    public function supervisors(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|boolean',
        ]);

        $supervisors = $this->loggedUserAdministrator()
                        ->supervisors()
                        ->get()
                        ->where('status', (int) $request->status)
                        ->transform(function($item){
                            return (object) array(
                                'id' => $item->seq_id,
                                'name' => $item->name.' '.$item->last_name,
                                'email' => $item->user()->email,
                                'cellphone' => $item->cellphone,
                            );
                        })
                        ->flatten(1);
        return Response::json($supervisors, 200);
    }

    public function technicians(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|boolean',
        ]);

        $technicians = $this->loggedUserAdministrator()
                            ->technicians()
                            ->get()
                            ->where('status', (int) $request->status)
                            ->transform(function($item){
                                $supervisor = $item->supervisor();
                                return (object) array(
                                    'id' =>  $item->seq_id,
                                    'name' => $item->name.' '.$item->last_name,
                                    'username' => $item->user()->email,
                                    'cellphone' => $item->cellphone,
                                    'supervisor' => $supervisor->name.' '.$supervisor->last_name,
                                );
                            })
                            ->flatten(1);
        return Response::json($technicians, 200);
    }

}
