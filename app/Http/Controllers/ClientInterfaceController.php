<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JavaScript;
use DB;
use App\PRS\Transformers\FrontEnd\ReportFrontTransformer;
use App\PRS\Transformers\FrontEnd\DataTables\ServiceDatatableTransformer;
use App\PRS\Transformers\FrontEnd\DataTables\InvoiceDatatableTransformer;
use App\PRS\Transformers\FrontEnd\DataTables\WorkOrderDatatableTransformer;
use App\PRS\Transformers\ImageTransformer;
use App\PRS\Helpers\TechnicianHelpers;
use App\PRS\Classes\Logged;
use App\WorkOrder;
use App\Service;
use Carbon\Carbon;

class ClientInterfaceController extends PageController
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


    public function reports(Request $request)
    {
        $client = $request->user()->selectedUser;
        if(!$client->isRole('client')){
            abort(403, 'Only clients can view this page.');
        }

        $company = $client->company;
        $today = Carbon::today($company->timezone)->toDateString();

        JavaScript::put([
            'enabledDates' => $client->datesWithReport(),
            'todayDate' => $today,
        ]);

        return view('clientInterface.reports', compact('today'));
    }

    public function reportsByDate(Request $request, ReportFrontTransformer $reportTransformer)
    {
        $client = $request->user()->selectedUser;
        if(!$client->isRole('client')){
            return response('You are not a Client', 403);
        }

        $this->validate($request, [
            'date' => 'validDateReportFormat'
        ]);

        $company = $client->company;
        $date = (new Carbon($request->date, $company->timezone));
        $reports = $reportTransformer->transformCollection($client->reportsByDate($date));

        return response([
            'reports' => $reports
        ]);
    }

    public function workOrders(Request $request)
    {
        if(!$request->user()->selectedUser->isRole('client')){
            abort(403, 'Only clients can view this page.');
        }
        return view('clientInterface.workorder.index');
    }

    public function workOrderTable(Request $request, WorkOrderDatatableTransformer $transformer)
    {
        $client = $request->user()->selectedUser;
        if(!$client->isRole('client')){
            return response('You are not a Client', 403);
        }

        $this->validate($request, [
            'limit' => 'integer|between:1,25',
            'toggle' => 'boolean',
            'filter' => 'string'
        ]);

        $limit = ($request->limit)?: 10;

        $company = Logged::company();

        $workOrders = $client->clientWorkOrders();

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

        if($filter = $request->filter){
            $timezone = $company->timezone;
            $workOrders = $workOrders->where(function ($query) use ($filter, $timezone) {
                $escapedInput = str_replace('%', '\\%', $filter);
                $query->where('services.name', 'ilike', '%'.$escapedInput.'%' )
                        ->orWhere(DB::raw('users.name || \' \' || users.last_name'), 'ilike', '%'.$escapedInput.'%')
                        ->orWhere('work_orders.title', 'ilike', '%'.$escapedInput.'%')
                        ->orWhere( // Convert the time to string and to the admin timezone
                                DB::raw(
                                    'to_char(
                                        CONVERT_TZ(work_orders.start,\'UTC\',\''.$timezone.'\'),
                                        \'DD Mon YYYY HH12:MI:SS PM\')'
                                ),
                                'ilike',
                                '%'.$escapedInput.'%')
                        ->orWhere( // Convert the time to string and to the admin timezone
                                DB::raw(
                                    'to_char(
                                        CONVERT_TZ(work_orders.end,\'UTC\',\''.$timezone.'\'),
                                        \'DD Mon YYYY HH12:MI:SS PM\')'
                                ),
                                'ilike',
                                '%'.$escapedInput.'%')
                        ->orWhere(DB::raw('(work_orders.price::text) || \' \' || work_orders.currency'), 'ilike', '%'.$escapedInput.'%');
                        // ->orWhere('services.seq_id', (int) $filter);
                    if(is_numeric($filter)){
                        $query->orWhere('work_orders.seq_id', (int) $filter);
                    }
            });

        }

        // Check if it has been paid
        if($request->has('toggle')){
            $workOrders = $workOrders->finished($request->toggle);
        }else{
            // Temporary
            $workOrders = $workOrders->finished(false);
        }

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

    public function workOrderShow(Request $request,
                            ImageTransformer $imageTransformer, $seq_id)
    {
        $client = $request->user()->selectedUser;
        if(!$client->isRole('client')){
            abort(403, 'Only clients can view this page.');
        }

        $company = $client->company;
        $workOrder = $company->workOrders()->bySeqId($seq_id);

        $this->authorize('view', $workOrder);

        return view('clientInterface.workorder.show', compact('workOrder'));
    }

    public function services(Request $request)
    {
        if(!$request->user()->selectedUser->isRole('client')){
            abort(403, 'Only clients can view this page.');
        }
        return view('clientInterface.service.index');
    }

    public function serviceTable(Request $request, ServiceDatatableTransformer $transformer)
    {
        $client = $request->user()->selectedUser;
        if(!$client->isRole('client')){
            return response('You are not a Client', 403);
        }

        $this->validate($request, [
            'limit' => 'integer|between:1,25',
            'toggle' => 'boolean',
            'filter' => 'string'
        ]);

        $limit = ($request->limit)?: 10;

        $services = Service::query();

        $services = $services->join('urc_service', 'services.id', '=', 'urc_service.service_id')
                        ->select(
                                'services.*',
                                'urc_service.urc_id as client_id'
                            );

        // Missing search by price
        if($filter = $request->filter){
            $escapedInput = str_replace('%', '\\%', $filter);
            if(is_numeric($filter)){
                $services  = $services->where(function ($query) use ($filter, $escapedInput) {
                    $query->where('services.name', 'ilike', '%'.$escapedInput.'%')
                        ->orWhere('services.address_line', 'ilike', '%'.$escapedInput.'%')
                        ->orWhere('services.seq_id', (int) $filter);
                });
            }else{
                $services = $services->where(function ($query) use ($escapedInput) {
                    $query->where('services.name', 'ilike', '%'.$escapedInput.'%')
                        ->orWhere('services.address_line', 'ilike', '%'.$escapedInput.'%');
                });
            }

        }

        // Only get URC from the company is logged in.
        $services = $services->where('urc_service.urc_id', $client->id);

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

    public function serviceShow(Request $request, ImageTransformer $imageTransformer, $seq_id)
    {
        if(!$request->user()->selectedUser->isRole('client')){
            abort(403, 'Only clients can view this page.');
        }

        $service = $this->loggedCompany()->services()->bySeqId($seq_id);
        $image = $imageTransformer->transform($service->images->first());
        $contract = null;
        if($service->hasServiceContract()){
            $contract = $service->serviceContract;
        }

        $this->authorize('view', $service);

        return view('clientInterface.service.show', compact('service', 'contract', 'image'));

    }

    public function statement(Request $request)
    {
        if(!$request->user()->selectedUser->isRole('client')){
            abort(403, 'Only clients can view this page.');
        }

        return view('clientInterface.statement');
    }

    public function invoicesTable(Request $request, InvoiceDatatableTransformer $transformer)
    {
        if(!$request->user()->selectedUser->isRole('client')){
            abort(403, 'Only clients can view this page.');
        }

    }


}
