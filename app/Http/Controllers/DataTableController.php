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
use App\PRS\Transformers\FrontEnd\DataTables\UserRoleCompanyDatatableTransformer;

use App\Http\Requests;
use App\UserRoleCompany;
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
        $services = $this->loggedCompany()
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

        $company = $this->loggedCompany();

        $date = (new Carbon($request->date, $company->timezone));

        $reports =  $company->reportsByDate($date)->get();

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

        $workOrders = $this->loggedCompany()
                        ->workOrders()
                        ->finished($request->finished)
                        ->seqIdOrdered()->get();

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

        $company = $this->loggedCompany();

        if($request->status){
            $services = $company->servicesWithActiveContract()->get();
        }else{
            $services = $company->serviceWithNoContractOrInactive()->get();
        }
        return response()->json(
                    $transformer->transformCollection($services)
                );
    }

    public function userRoleCompanies(UserRoleCompanyDatatableTransformer $transformer)
    {
        // $this->authorize('list', [UserRoleCompany::class, 'client']);

        $userRoleCompanies = $this->loggedCompany()
                                    ->userRoleCompanies()
                                    ->seqIdOrdered()->get();

        return response()->json(
                    $transformer->transformCollection($userRoleCompanies)
                );
    }

    public function clients(UserRoleCompanyDatatableTransformer $transformer)
    {
        $this->authorize('list', [UserRoleCompany::class, 'client']);

        $userRoleCompanies = $this->loggedCompany()
                                    ->userRoleCompanies()
                                    ->ofRole('client')
                                    ->seqIdOrdered()->get();

        return response()->json(
                    $transformer->transformCollection($userRoleCompanies)
                );
    }

    public function supervisors(Request $request, UserRoleCompanyDatatableTransformer $transformer)
    {
        $this->authorize('list', [UserRoleCompany::class, 'sup']);

        $this->validate($request, [
            'status' => 'required|boolean',
        ]);

        $userRoleCompanies = $this->loggedCompany()
                                ->userRoleCompanies()
                                ->ofRole('sup')
                                ->paid($request->status)
                                ->seqIdOrdered()->get();

        return response()->json(
                    $transformer->transformCollection($userRoleCompanies)
                );
    }

    public function technicians(Request $request, UserRoleCompanyDatatableTransformer $transformer)
    {
        $this->authorize('list', [UserRoleCompany::class, 'tech']);

        $this->validate($request, [
            'status' => 'required|boolean',
        ]);

        $userRoleCompanies = $this->loggedCompany()
                                ->userRoleCompanies()
                                ->ofRole('tech')
                                ->paid($request->status)
                                ->seqIdOrdered()->get();

        return response()->json(
                    $transformer->transformCollection($userRoleCompanies)
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
        $invoices = $this->loggedCompany()
                        ->invoices()
                        ->where('closed', $condition , NULL)
                        ->seqIdOrdered()->get();

        return response()->json(
                    $transformer->transformCollection($invoices)
                );
    }

}
