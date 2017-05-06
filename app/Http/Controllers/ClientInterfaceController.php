<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JavaScript;
use App\PRS\Transformers\FrontEnd\ReportFrontTransformer;
use App\PRS\Transformers\FrontEnd\DataTables\ServiceDatatableTransformer;
use App\PRS\Transformers\FrontEnd\DataTables\WorkOrderDatatableTransformer;
use App\PRS\Transformers\ImageTransformer;
use App\PRS\Helpers\TechnicianHelpers;
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

    public function serviceTable(Request $request, ServiceDatatableTransformer $serviceTransformer)
    {
        $client = $request->user()->selectedUser;
        if(!$client->isRole('client')){
            return response('You are not a Client', 403);
        }

        $this->validate($request, [
            'contract' => 'required|boolean'
        ]);


        if($request->contract){
            $services = $client->services()->withActiveContract()->seqIdOrdered()->get();
        }else{
            $services = $client->services()->withoutActiveContract()->seqIdOrdered()->get();
        }

        return response($serviceTransformer->transformCollection($services));

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

}
