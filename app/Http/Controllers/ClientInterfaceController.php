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
    
    // ************IMPORTANT****************
    // NEED TO ADD AUTHORIZATION TO ALL THE METHODS
    // ************IMPORTANT****************

    public function reports(Request $request)
    {
        if(!$request->user()->isClient()){
            abort(403, 'Only clients can view this page.');
        }

        $admin = $request->user()->admin();
        $client = $request->user()->userable();
        $today = Carbon::today($admin->timezone)->toDateString();

        JavaScript::put([
            'enabledDates' => $client->datesWithReport(),
            'todayDate' => $today,
        ]);

        return view('clientInterface.reports', compact('today'));
    }

    public function reportsByDate(Request $request, ReportFrontTransformer $reportTransformer)
    {
        if(!$request->user()->isClient()){
            return response('You are not a Client', 403);
        }

        $this->validate($request, [
            'date' => 'validDateReportFormat'
        ]);

        $admin = $request->user()->admin();
        $client = $request->user()->userable();
        $date = (new Carbon($request->date, $admin->timezone));
        $reports = $reportTransformer->transformCollection($client->reportsByDate($date));

        return response([
            'reports' => $reports
        ]);
    }

    public function workOrders(Request $request)
    {
        if(!$request->user()->isClient()){
            abort(403, 'Only clients can view this page.');
        }
        return view('clientInterface.workorder.index');
    }

    public function workOrderTable(Request $request, WorkOrderDatatableTransformer $workOrderTransformer)
    {
        if(!$request->user()->isClient()){
            return response('You are not a Client', 403);
        }

        $this->validate($request, [
            'finished' => 'required|boolean'
        ]);

        $admin = $request->user()->admin();
        $client = $request->user()->userable();
        $workOrders = $client->workOrders($request->finished);

        return response($workOrderTransformer->transformCollection($workOrders));
    }

    public function workOrderShow(Request $request,
                            ImageTransformer $imageTransformer,
                            TechnicianHelpers $technicianHelpers,
                            $seq_id)
    {
        if(!$request->user()->isClient()){
            abort(403, 'Only clients can view this page.');
        }

        $admin = $this->loggedUserAdministrator();
        $workOrder = $admin->workOrderBySeqId($seq_id);

        $imagesBeforeWork = $imageTransformer->transformCollection($workOrder->imagesBeforeWork());
        $imagesAfterWork = $imageTransformer->transformCollection($workOrder->imagesAfterWork());

        $technicians  = $technicianHelpers->transformForDropdown($admin->techniciansInOrder()->get());
        $default_table_url = url('datatables/works/'.$seq_id);

        JavaScript::put([
            'worksUrl' => url('/works').'/',
            'worksAddPhotoUrl' => url('/works/photos').'/',
            'workOrderId' => $workOrder->id,
            'workOrderFinished' => $workOrder->end()->finished(),
            'workOrderUrl' => url('workorders/'.$workOrder->seq_id),
            'workOrderBeforePhotos' => $imagesBeforeWork,
            'workOrderAfterPhotos' => $imagesAfterWork,
            'workOrderPhotoAfterUrl' => url('workorders/photos/after/'.$workOrder->id),
            'finishWorkOrderUrl' => url('workorders/finish/'.$workOrder->seq_id),
        ]);

        return view('clientInterface.workorder.show', compact('workOrder', 'default_table_url', 'technicians'));
    }

    public function services(Request $request)
    {
        if(!$request->user()->isClient()){
            abort(403, 'Only clients can view this page.');
        }
        return view('clientInterface.service.index');
    }

    public function serviceTable(Request $request, ServiceDatatableTransformer $serviceTransformer)
    {
        if(!$request->user()->isClient()){
            return response('You are not a Client', 403);
        }

        $this->validate($request, [
            'contract' => 'required|boolean'
        ]);

        $client = $request->user()->userable();

        if($request->contract){
            $services = $client->servicesWithActiveContract()->get();
        }else{
            $services = $client->serviceWithNoContractOrInactive()->get();
        }

        return response($serviceTransformer->transformCollection($services));

    }

    public function serviceShow(Request $request,
                            ImageTransformer $imageTransformer,
                            $seq_id)
    {
        if(!$request->user()->isClient()){
            abort(403, 'Only clients can view this page.');
        }

        $service = $this->loggedUserAdministrator()->serviceBySeqId($seq_id);
        $image = $imageTransformer->transform($service->images->first());

        return view('clientInterface.service.show', compact('service', 'image'));

    }

    public function statement(Request $request)
    {
        if(!$request->user()->isClient()){
            abort(403, 'Only clients can view this page.');
        }

        return view('clientInterface.statement');
    }

}
