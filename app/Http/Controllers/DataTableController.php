<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use Validator;
use Carbon\Carbon;

use App\PRS\Transformers\FrontEnd\DataTables\ReportDatatableTransformer;
use App\PRS\Transformers\FrontEnd\DataTables\ClientDatatableTransformer;
use App\PRS\Transformers\FrontEnd\DataTables\ServiceDatatableTransformer;
use App\PRS\Transformers\FrontEnd\DataTables\InvoiceDatatableTransformer;
use App\PRS\Transformers\FrontEnd\DataTables\WorkOrderDatatableTransformer;
use App\PRS\Transformers\FrontEnd\DataTables\SupervisorDatatableTransformer;
use App\PRS\Transformers\FrontEnd\DataTables\TechnicianDatatableTransformer;
use App\PRS\Transformers\FrontEnd\DataTables\TodaysRouteDatatableTransformer;

use App\Http\Requests;
use App\Supervisor;
use App\Technician;
use App\Service;
use App\Invoice;
use App\Report;
use App\Client;
use App\WorkOrder;

class DataTableController extends PageController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function todaysroute(Request $request, TodaysRouteDatatableTransformer $transformer)
    {
        $this->validate($request, [
            'daysFromToday' => 'integer|between:0,6'
        ]);
        $daysFromToday = ($request->daysFromToday) ?: 0;
        $services = $this->loggedUserAdministrator()
                        ->servicesDoIn(Carbon::now()->addDays($daysFromToday));

        return response()->json([
            'list' => $transformer->transformCollection($services)
        ]);
    }

    public function reports(Request $request, ReportDatatableTransformer $transformer)
    {
        $this->authorize('list', Report::class);

        $this->validate($request, [
            'date' => 'validDateReportFormat'
        ]);

        $admin = $this->loggedUserAdministrator();

        $date = (new Carbon($request->date, $admin->timezone));

        $reports =  $admin
                    ->reportsByDate($date)
                    ->get();

        return response()->json(
                    $transformer->transformCollection($reports)
                );
    }

    public function workOrders(Request $request, WorkOrderDatatableTransformer $transformer)
    {
        $this->authorize('list', WorkOrder::class);

        $this->validate($request, [
            'finished' => 'required|boolean',
        ]);

        $operator = ($request->finished) ? '!=' : '=';
        $workOrders = $this->loggedUserAdministrator()
                        ->workOrdersInOrder()
                        ->get()
                        ->where('end', $operator, null);

        return response()->json(
                    $transformer->transformCollection($workOrders)
                );
    }

    public function services(Request $request, ServiceDatatableTransformer $transformer)
    {
        $this->authorize('list', Service::class);

        $this->validate($request, [
            'status' => 'required|boolean',
        ]);

        if($request->status){
            $services = $this->loggedUserAdministrator()
                            ->servicesWithActiveContract()
                            ->get();
        }else{
            $services = $this->loggedUserAdministrator()
                            ->serviceWithNoContractOrInactive()
                            ->get();
        }
        return response()->json(
                    $transformer->transformCollection($services)
                );
    }

    public function clients(ClientDatatableTransformer $transformer)
    {
        $this->authorize('list', Client::class);

        $clients = $this->loggedUserAdministrator()
                        ->clientsInOrder()
                        ->get();

        return response()->json(
                    $transformer->transformCollection($clients)
                );
    }

    public function supervisors(Request $request, SupervisorDatatableTransformer $transformer)
    {
        $this->authorize('list', Supervisor::class);

        $this->validate($request, [
            'status' => 'required|boolean',
        ]);

        $supervisors = $this->loggedUserAdministrator()
                        ->supervisorsActive($request->status)
                        ->get();

        return response()->json(
                    $transformer->transformCollection($supervisors)
                );
    }

    public function technicians(Request $request, TechnicianDatatableTransformer $transformer)
    {
        $this->authorize('list', Technician::class);

        $this->validate($request, [
            'status' => 'required|boolean',
        ]);

        $technicians = $this->loggedUserAdministrator()
                            ->techniciansActive($request->status)
                            ->get();

        return response()->json(
                    $transformer->transformCollection($technicians)
                );
    }

    public function invoices(Request $request, InvoiceDatatableTransformer $transformer)
    {
        $this->authorize('list', Invoice::class);

        $this->validate($request, [
            'closed' => 'required|boolean',
        ]);

        $closed = $request->closed;
        $condition = ($request->closed)? '!=' : '=';
        $invoices = $this->loggedUserAdministrator()
                        ->invoices()
                        ->where('closed', $condition , NULL)
                        ->orderBy('seq_id', 'desc')
                        ->get();

        return response()->json(
                    $transformer->transformCollection($invoices)
                );
    }

}
