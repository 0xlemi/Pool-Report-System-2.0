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

    public function workOrderTable(Request $request, WorkOrderDatatableTransformer $workOrderTransformer)
    {
        $client = $request->user()->selectedUser;
        if(!$client->isRole('client')){
            return response('You are not a Client', 403);
        }

        $this->validate($request, [
            'finished' => 'required|boolean'
        ]);

        $workOrders = $client->clientWorkOrders()
                            ->finished($request->finished)
                            ->seqIdOrdered('desc')->get();

        return response($workOrderTransformer->transformCollection($workOrders));
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
