<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use Validator;
use Carbon\Carbon;
use DB;

use App\PRS\Transformers\FrontEnd\DataTables\ReportDatatableTransformer;
use App\PRS\Transformers\FrontEnd\DataTables\ClientDatatableTransformer;
use App\PRS\Transformers\FrontEnd\DataTables\ServiceDatatableTransformer;
use App\PRS\Transformers\FrontEnd\DataTables\InvoiceDatatableTransformer;
use App\PRS\Transformers\FrontEnd\DataTables\WorkOrderDatatableTransformer;
use App\PRS\Transformers\FrontEnd\DataTables\SupervisorDatatableTransformer;
use App\PRS\Transformers\FrontEnd\DataTables\TechnicianDatatableTransformer;
use App\PRS\Transformers\FrontEnd\DataTables\TodaysRouteDatatableTransformer;
use App\PRS\Transformers\FrontEnd\DataTables\UserRoleCompanyDatatableTransformer;
use App\PRS\Classes\Logged;

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
            'limit' => 'integer|between:1,25',
            'toggle' => 'boolean',
            'filter' => 'string'
        ]);

        $limit = ($request->limit)?: 10;

        $workOrders = WorkOrder::query();

        $workOrders = $workOrders->join('services', 'services.id', '=', 'work_orders.service_id')
                        ->select('work_orders.*', 'services.name as service_name', 'services.company_id');

        $workOrders = $workOrders->join('user_role_company', 'user_role_company.id', '=', 'work_orders.user_role_company_id')
                        ->select(
                                'work_orders.*',
                                'services.name as service_name',
                                'services.company_id',
                                'user_role_company.user_id as user_id'
                            );

        $workOrders = $workOrders->join('users', 'users.id', '=', 'user_id')
                        ->select(
                                'work_orders.*',
                                'services.name as service_name',
                                'services.company_id',
                                DB::raw('users.name || \' \' || users.last_name as person_name')
                            );

        if($request->filter){
            $escapedInput = str_replace('%', '\\%', $request->filter);
            $workOrders = $workOrders->where('services.name', 'ilike', '%'.$escapedInput.'%' )
                            ->orWhere(DB::raw('users.name || \' \' || users.last_name'), 'ilike', '%'.$escapedInput.'%')
                            ->orWhere('work_orders.title', 'ilike', '%'.$escapedInput.'%')
                            // ->orWhere('work_orders.start', 'ilike', '%'.$escapedInput.'%')
                            // ->orWhere('work_orders.end', 'ilike', '%'.$escapedInput.'%')
                            ->orWhere(DB::raw('(work_orders.price::text) || \' \' || work_orders.currency'), 'ilike', '%'.$escapedInput.'%');
            if(is_numeric($request->filter)){
                $workOrders = $workOrders->orWhere('work_orders.seq_id', (int) $request->filter);
            }
        }

        // Check if it has been paid
        if($request->has('toggle')){
            $workOrders = $workOrders->finished($request->toggle);
        }else{
            // Temporary
            $workOrders = $workOrders->finished(false);
        }

        // Only get URC from the company is logged in.
        $workOrders = $workOrders->where('user_role_company.company_id', Logged::company()->id);


        // Sort needs validation of some kind
        // Order the table by different columns
        if($request->has('sort')){
            $sort = explode('|', $request->sort);
            $workOrders = $workOrders->orderBy($sort[0], $sort[1]);
        }else{
            $workOrders = $workOrders->seqIdOrdered();
        }

        $workOrdersPaginated = $workOrders->paginate($limit);

        $data = array_merge(
            [
                'data' => $transformer->transformCollection($workOrdersPaginated),
            ],
            [
                'paginator' => [
                    'total' => $workOrdersPaginated->total(),
                    'per_page' => $workOrdersPaginated->perPage(),
                    'current_page' => $workOrdersPaginated->currentPage(),
                    'last_page' => $workOrdersPaginated->lastPage(),
                    'next_page_url' => $workOrdersPaginated->nextPageUrl(),
                    'prev_page_url' => $workOrdersPaginated->previousPageUrl(),
                    'from' => $workOrdersPaginated->firstItem(),
                    'to' => $workOrdersPaginated->lastItem(),
                ]
            ]
        );
        return response()->json($data);
    }

    public function services(Request $request, ServiceDatatableTransformer $transformer)
    {
        $this->authorize('list', Service::class);
        $this->validate($request, [
            'limit' => 'integer|between:1,25',
            'toggle' => 'boolean',
            'filter' => 'string'
        ]);

        $limit = ($request->limit)?: 10;

        $services = Service::query();

        // $services = $services->join('users', 'users.id', '=', 'user_role_company.user_id')
        //                 ->select('user_role_company.*', 'users.email', 'users.name', 'users.last_name');

        if($request->filter){
            // Searching for Full Name, Email and Cellphone
            $escapedInput = str_replace('%', '\\%', $request->filter);
            $services = $services->where('services.name', 'ilike', '%'.$escapedInput.'%' )
                            ->orWhere('services.address_line', 'ilike', '%'.$escapedInput.'%');
                            // ->orWhere('price', 'ilike', '%'.$escapedInput.'%')
            if(is_numeric($request->filter)){
                $services = $services->orWhere('services.seq_id', (int) $request->filter);
            }
        }

        // Check if it has been paid
        if($request->has('toggle')){
            if($request->toggle){
                $services = $services->withActiveContract();
            }else{
                $services = $services->withoutActiveContract();
            }
        }else{
            // Temporary
            $services = $services->withActiveContract();
        }

        // Only get URC from the company is logged in.
        $services = $services->where('services.company_id', Logged::company()->id);


        // Sort needs validation of some kind
        // Order the table by different columns
        if($request->has('sort')){
            $sort = explode('|', $request->sort);
            $services = $services->orderBy($sort[0], $sort[1]);
        }else{
            $services = $services->seqIdOrdered();
        }

        $servicesPaginated = $services->paginate($limit);

        $data = array_merge(
            [
                'data' => $transformer->transformCollection($servicesPaginated),
            ],
            [
                'paginator' => [
                    'total' => $servicesPaginated->total(),
                    'per_page' => $servicesPaginated->perPage(),
                    'current_page' => $servicesPaginated->currentPage(),
                    'last_page' => $servicesPaginated->lastPage(),
                    'next_page_url' => $servicesPaginated->nextPageUrl(),
                    'prev_page_url' => $servicesPaginated->previousPageUrl(),
                    'from' => $servicesPaginated->firstItem(),
                    'to' => $servicesPaginated->lastItem(),
                ]
            ]
        );
        return response()->json($data);
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

    public function clients(Request $request, UserRoleCompanyDatatableTransformer $transformer)
    {
        $this->authorize('list', [UserRoleCompany::class, 'client']);

        $this->validate($request, [
            'limit' => 'integer|between:1,25',
            'filter' => 'string'
        ]);

        $limit = ($request->limit)?: 10;

        $urcs = UserRoleCompany::query();

        $urcs = $urcs->join('users', 'users.id', '=', 'user_role_company.user_id')
                        ->select('user_role_company.*', 'users.email', 'users.name', 'users.last_name');

        if($request->filter){
            // Searching for Full Name, Email and Cellphone
            $escapedInput = str_replace('%', '\\%', $request->filter);
            $urcs = $urcs->where('users.name', 'ilike', '%'.$escapedInput.'%' )
                            ->orWhere('users.last_name', 'ilike', '%'.$escapedInput.'%')
                            ->orWhere('users.email', 'ilike', '%'.$escapedInput.'%')
                            ->orWhere('cellphone', 'ilike', '%'.$escapedInput.'%');
            if(is_numeric($request->filter)){
                $urcs = $urcs->orWhere('user_role_company.seq_id', (int) $request->filter);
            }
        }

        $urcs = $urcs->ofRole('client');

        // Only get URC from the company is logged in.
        $urcs = $urcs->where('user_role_company.company_id', Logged::company()->id);

        // Sort needs validation of some kind
        // Order the table by different columns
        if($request->has('sort')){
            $sort = explode('|', $request->sort);
            $urcs = $urcs->orderBy($sort[0], $sort[1]);
        }else{
            $urcs = $urcs->seqIdOrdered();
        }

        $urcPaginated = $urcs->paginate($limit);

        $data = array_merge(
            [
                'data' => $transformer->transformCollection($urcPaginated),
            ],
            [
                'paginator' => [
                    'total' => $urcPaginated->total(),
                    'per_page' => $urcPaginated->perPage(),
                    'current_page' => $urcPaginated->currentPage(),
                    'last_page' => $urcPaginated->lastPage(),
                    'next_page_url' => $urcPaginated->nextPageUrl(),
                    'prev_page_url' => $urcPaginated->previousPageUrl(),
                    'from' => $urcPaginated->firstItem(),
                    'to' => $urcPaginated->lastItem(),
                ]
            ]
        );
        return response()->json($data);
    }

    public function supervisors(Request $request, UserRoleCompanyDatatableTransformer $transformer)
    {
        $this->authorize('list', [UserRoleCompany::class, 'sup']);
            $this->validate($request, [
            'limit' => 'integer|between:1,25',
            'toggle' => 'boolean',
            'filter' => 'string'
        ]);

        $limit = ($request->limit)?: 10;

        $urcs = UserRoleCompany::query();

        $urcs = $urcs->join('users', 'users.id', '=', 'user_role_company.user_id')
                        ->select('user_role_company.*', 'users.email', 'users.name', 'users.last_name');

        if($request->filter){
            // Searching for Full Name, Email and Cellphone
            $escapedInput = str_replace('%', '\\%', $request->filter);
            $urcs = $urcs->where('users.name', 'ilike', '%'.$escapedInput.'%' )
                            ->orWhere('users.last_name', 'ilike', '%'.$escapedInput.'%')
                            ->orWhere('users.email', 'ilike', '%'.$escapedInput.'%')
                            ->orWhere('cellphone', 'ilike', '%'.$escapedInput.'%');
            if(is_numeric($request->filter)){
                $urcs = $urcs->orWhere('user_role_company.seq_id', (int) $request->filter);
            }
        }

        $urcs = $urcs->ofRole('sup');

        // Only get URC from the company is logged in.
        $urcs = $urcs->where('user_role_company.company_id', Logged::company()->id);

        // Check if it has been paid
        if($request->has('toggle')){
            $urcs = $urcs->paid($request->toggle);
        }else{
            // Temporary
            $urcs = $urcs->paid(true);
        }

        // Sort needs validation of some kind
        // Order the table by different columns
        if($request->has('sort')){
            $sort = explode('|', $request->sort);
            $urcs = $urcs->orderBy($sort[0], $sort[1]);
        }else{
            $urcs = $urcs->seqIdOrdered();
        }

        $urcPaginated = $urcs->paginate($limit);

        $data = array_merge(
            [
                'data' => $transformer->transformCollection($urcPaginated),
            ],
            [
                'paginator' => [
                    'total' => $urcPaginated->total(),
                    'per_page' => $urcPaginated->perPage(),
                    'current_page' => $urcPaginated->currentPage(),
                    'last_page' => $urcPaginated->lastPage(),
                    'next_page_url' => $urcPaginated->nextPageUrl(),
                    'prev_page_url' => $urcPaginated->previousPageUrl(),
                    'from' => $urcPaginated->firstItem(),
                    'to' => $urcPaginated->lastItem(),
                ]
            ]
        );
        return response()->json($data);
    }

    public function technicians(Request $request, UserRoleCompanyDatatableTransformer $transformer)
    {
        $this->authorize('list', [UserRoleCompany::class, 'tech']);
        $this->validate($request, [
            'limit' => 'integer|between:1,25',
            'toggle' => 'boolean',
            'filter' => 'string'
        ]);

        $limit = ($request->limit)?: 10;

        $urcs = UserRoleCompany::query();

        $urcs = $urcs->join('users', 'users.id', '=', 'user_role_company.user_id')
                        ->select('user_role_company.*', 'users.email', 'users.name', 'users.last_name');

        if($request->filter){
            $escapedInput = str_replace('%', '\\%', $request->filter);
            $urcs = $urcs->where('users.name', 'ilike', '%'.$escapedInput.'%' )
                            ->orWhere('users.last_name', 'ilike', '%'.$escapedInput.'%')
                            ->orWhere('users.email', 'ilike', '%'.$escapedInput.'%')
                            ->orWhere('cellphone', 'ilike', '%'.$escapedInput.'%');
            if(is_numeric($request->filter)){
                $urcs = $urcs->orWhere('user_role_company.seq_id', (int) $request->filter);
            }
        }

        $urcs = $urcs->ofRole('tech');

        // Only get URC from the company is logged in.
        $urcs = $urcs->where('user_role_company.company_id', Logged::company()->id);

        // Check if it has been paid
        if($request->has('toggle')){
            $urcs = $urcs->paid($request->toggle);
        }else{
            // Temporary
            $urcs = $urcs->paid(true);
        }

        // Sort needs validation of some kind
        // Order the table by different columns
        if($request->has('sort')){
            $sort = explode('|', $request->sort);
            $urcs = $urcs->orderBy($sort[0], $sort[1]);
        }else{
            $urcs = $urcs->seqIdOrdered();
        }

        $urcPaginated = $urcs->paginate($limit);

        $data = array_merge(
            [
                'data' => $transformer->transformCollection($urcPaginated),
            ],
            [
                'paginator' => [
                    'total' => $urcPaginated->total(),
                    'per_page' => $urcPaginated->perPage(),
                    'current_page' => $urcPaginated->currentPage(),
                    'last_page' => $urcPaginated->lastPage(),
                    'next_page_url' => $urcPaginated->nextPageUrl(),
                    'prev_page_url' => $urcPaginated->previousPageUrl(),
                    'from' => $urcPaginated->firstItem(),
                    'to' => $urcPaginated->lastItem(),
                ]
            ]
        );
        return response()->json($data);
    }

    public function invoices(Request $request, InvoiceDatatableTransformer $transformer)
    {
        $this->authorize('list', Invoice::class);
        $this->validate($request, [
            'limit' => 'integer|between:1,25',
            'toggle' => 'boolean',
            'filter' => 'string'
        ]);

        $limit = ($request->limit)?: 10;

        $invoices = Invoice::query();

        // $invoices = $invoices->join('service_contracts', function ($join) {
        //                 $join->on('service_contracts.id', '=', 'invoices.invoiceable_id')
        //                      ->where('invoices.invoiceable_type', '=', 'App\ServiceContract');
        //             })->select('invoices.id')->get()->pluck('id')->toArray();
        //                 // ->select('user_role_company.*', 'users.email', 'users.name', 'users.last_name');
        //
        // dd($invoices->get()->toArray());

        if($request->filter){
            // Searching for Full Name, Email and Cellphone
            if(is_numeric($request->filter)){
                $invoices = $invoices->where('invoices.amount', $request->filter)
                                    ->orWhere('invoices.seq_id', (int) $request->filter);
            }else{
                $escapedInput = str_replace('%', '\\%', $request->filter);
                $invoices = $invoices->where('invoices.currency', 'ilike', '%'.$escapedInput.'%' )
                            ->orWhere('invoices.invoiceable_type', 'ilike', '%'.$escapedInput.'%');
                            // ->orWhere('to_char(invoices.closed, \'DD Mon YYYY HH:MI:SS AM\')', 'ilike', '%'.$escapedInput.'%');
                            // ->orWhere('invoices.closed', 'ilike', '%'.$escapedInput.'%');
            }
        }


        // Only get URC from the company is logged in.
        $invoices = $invoices->where('invoices.company_id', Logged::company()->id);

        // Check if it has been paid
        if($request->has('toggle')){
            if($request->toggle){
                $invoices = $invoices->paid();
            }else{
                $invoices = $invoices->unpaid();
            }
        }else{
            // Temporary
            $invoices = $invoices->unpaid();
        }

        // Sort needs validation of some kind
        // Order the table by different columns
        if($request->has('sort')){
            $sort = explode('|', $request->sort);
            $invoices = $invoices->orderBy($sort[0], $sort[1]);
        }else{
            $invoices = $invoices->seqIdOrdered();
        }

        $invoicesPaginated = $invoices->paginate($limit);

        $data = array_merge(
            [
                'data' => $transformer->transformCollection($invoicesPaginated),
            ],
            [
                'paginator' => [
                    'total' => $invoicesPaginated->total(),
                    'per_page' => $invoicesPaginated->perPage(),
                    'current_page' => $invoicesPaginated->currentPage(),
                    'last_page' => $invoicesPaginated->lastPage(),
                    'next_page_url' => $invoicesPaginated->nextPageUrl(),
                    'prev_page_url' => $invoicesPaginated->previousPageUrl(),
                    'from' => $invoicesPaginated->firstItem(),
                    'to' => $invoicesPaginated->lastItem(),
                ]
            ]
        );
        return response()->json($data);
    }

}
