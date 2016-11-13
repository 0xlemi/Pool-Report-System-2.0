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
    protected $clientHelpers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ReportHelpers $reportHelpers, ClientHelpers $clientHelpers)
    {
        $this->middleware('auth');
        $this->reportHelpers = $reportHelpers;
        $this->clientHelpers = $clientHelpers;
    }

    public function todaysroute()
    {

        $services = $this->loggedUserAdministrator()
                ->servicesDoToday()
                ->transform(function($item){
                        return (object) array(
                            'id' => $item->seq_id,
                            'name' => $item->name,
                            'address' => $item->address_line,
                            'end_time' => $item->serviceContract->EndTime()->colored(),
                            'price' => $item->serviceContract->amount.' <strong>'.$item->serviceContract->currency.'</strong>',
                        );
                    })
                ->flatten(1);

        return response()->json($services);
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
                            'on_time' => $item->onTime()->styled(),
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
                                'serviceDays' => $service->serviceContract->serviceDays()->shortNamesStyled(),
                                'price' => $service->serviceContract->amount.' <strong>'.$service->serviceContract->currency.'</strong>',
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
                        ->workOrdersInOrder()
                        ->get()
                        ->where('finished', (int) $request->finished)
                        ->transform(function($item){
                            $supervisor =  $item->supervisor;
                            return (object) array(
                                'id' => $item->seq_id,
                                'start' => $item->start()
                                                ->format('d M Y h:i:s A'),
                                'end' =>  $item->end()
                                                ->format('d M Y h:i:s A'),
                                'price' => $item->price.' <strong>'.$item->currency.'</strong>',
                                'service' => $item->service->name,
                                'supervisor' => $supervisor->name.' '.$supervisor->last_name,
                            );
                        })
                        ->flatten(1);
        return Response::json($workOrders , 200);
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

        $status = $request->status;
        $services = $this->loggedUserAdministrator()
                        ->servicesInOrder()
                        ->get()
                        ->filter(function($item) use ($status){
                            if($status){
                                return $item->hasServiceContract();
                            }
                            return !$item->hasServiceContract();
                        })
                        ->transform(function($item) use ($status){
                            $serviceDays = "<span class=\"label label-pill label-default\">No Contract</span>";
                            $price = "<span class=\"label label-pill label-default\">No Contract</span>";
                            if($status){
                                $serviceDays = $item->serviceContract->serviceDays()->shortNamesStyled();
                                $price = $item->serviceContract->amount.' <strong>'.$item->serviceContract->currency.'</strong>';
                            }
                            return (object) array(
                                'id' => $item->seq_id,
                                'name' => $item->name,
                                'address' => $item->address_line,
                                'serviceDays' => $serviceDays,
                                'price' => $price,
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
                        ->clientsInOrder()
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
                        ->supervisorsActive($request->status)
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
                            ->techniciansActive($request->status)
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

    public function invoices(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'closed' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return Response::json([
                    'message' => 'Paramenters failed validation.',
                    'errors' => $validator->errors()->toArray(),
                ],
                422
            );
        }

        $closed = $request->closed;
        $condition = ($closed)? '!=' : '=';
        $invoices = $this->loggedUserAdministrator()
                        ->invoices()
                        ->get()
                        ->where('closed', $condition , NULL)
                        ->transform(function($item) use ($closed){
                            $closedText = "<span class=\"label label-pill label-default\">Not Closed</span>";
                            if($closed){
                                $closedText = $item->closed()->format('d M Y h:i:s A');
                            }
                            return (object)[
                                'id' => $item->seq_id,
                                'service' => $item->invoiceable->service->name,
                                'type' => $item->type()->styled(true),
                                'amount' => "{$item->amount} {$item->currency}",
                                'closed' => $closedText,
                            ];
                        })
                        ->flatten(1);
        return response()->json($invoices);
    }

}
