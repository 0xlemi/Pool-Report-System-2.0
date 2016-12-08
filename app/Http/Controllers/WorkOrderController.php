<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JavaScript;
use Response;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Requests\CreateWorkOrderRequest;
use App\PRS\Helpers\ServiceHelpers;
use App\PRS\Helpers\SupervisorHelpers;
use App\PRS\Helpers\TechnicianHelpers;
use App\PRS\Transformers\ImageTransformer;
use App\WorkOrder;
use App\Notifications\NewWorkOrderNotification;


class WorkOrderController extends PageController
{

    private $serviceHelpers;
    private $supervisorHelpers;
    private $technicianHelpers;
    private $imageTransformer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ServiceHelpers $serviceHelpers,
                                    SupervisorHelpers $supervisorHelpers,
                                    TechnicianHelpers $technicianHelpers,
                                    ImageTransformer $imageTransformer)
    {
        $this->middleware('auth');
        $this->serviceHelpers = $serviceHelpers;
        $this->supervisorHelpers = $supervisorHelpers;
        $this->technicianHelpers = $technicianHelpers;
        $this->imageTransformer = $imageTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('list', WorkOrder::class);

        $default_table_url = url('datatables/workorders?finished=0');

        JavaScript::put([
            'workOrderTableUrl' => url('datatables/workorders?finished='),
            'click_url' => url('workorders').'/',
        ]);

        return view('workorders.index', compact('default_table_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', WorkOrder::class);

        $admin = $this->loggedUserAdministrator();

        $services = $this->serviceHelpers->transformForDropdown($admin->servicesInOrder()->get());
        $supervisors = $this->supervisorHelpers->transformForDropdown($admin->supervisorsInOrder()->get());

        return view('workorders.create', compact('services', 'supervisors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateWorkOrderRequest $request)
    {
        $this->authorize('create', WorkOrder::class);

        $admin = $this->loggedUserAdministrator();

        $startDate = (new Carbon($request->start, $admin->timezone))->setTimezone('UTC');
        $service = $this->loggedUserAdministrator()->serviceBySeqId($request->service);
        $supervisor = $this->loggedUserAdministrator()->supervisorBySeqId($request->supervisor);

        $workOrder = WorkOrder::create(array_merge(
                            array_map('htmlentities', $request->all()),
                            [
                                'start' => $startDate,
                                'service_id' => $service->id,
                                'supervisor_id' => $supervisor->id,
                            ])
                    );
        $photo = true;
        if($request->photo){
            $photo = $workOrder->addImageFromForm($request->file('photo'));
        }
        if($workOrder && $photo){
            flash()->success('Created', 'New Work Order was successfully created.');
            return redirect('workorders');
        }
        flash()->success('Not created', 'New Work Order was not created, please try again later.');
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($seq_id)
    {
        $admin = $this->loggedUserAdministrator();
        $workOrder = $admin->workOrderBySeqId($seq_id);

        $this->authorize('view', $workOrder);

        $imagesBeforeWork = $this->imageTransformer->transformCollection($workOrder->imagesBeforeWork());
        $imagesAfterWork = $this->imageTransformer->transformCollection($workOrder->imagesAfterWork());

        $technicians  = $this->technicianHelpers->transformForDropdown($admin->techniciansInOrder()->get());
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

        return view('workorders.show', compact('workOrder', 'default_table_url', 'technicians'));
    }

    public function finish(Request $request, $seq_id)
    {
        $this->validate($request, [
            'end' => 'required|date'
        ]);
        $admin = $this->loggedUserAdministrator();
        $workOrder = $admin->workOrderBySeqId($seq_id);

        $this->authorize('finish', $workOrder);

        $workOrder->end = (new Carbon($request->end, $admin->timezone))->setTimezone('UTC');
        $workOrder->save();

        return response()->json([
                'title' => 'Work Order Finished',
                'message' => 'The work order has been finalized successfully.'
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($seq_id)
    {
        $admin = $this->loggedUserAdministrator();
        $workOrder = $admin->workOrderBySeqId($seq_id);

        $this->authorize('update', $workOrder);

        $services = $this->serviceHelpers->transformForDropdown($admin->servicesInOrder()->get());
        $supervisors = $this->supervisorHelpers->transformForDropdown($admin->supervisorsInOrder()->get());
        $imagesBeforeWork = $this->imageTransformer->transformCollection($workOrder->imagesBeforeWork());

        $startDate = (new Carbon($workOrder->start, 'UTC'))->setTimezone($admin->timezone);
        JavaScript::put([
            'defaultDate' => $startDate,
            'serviceId' => $workOrder->service->seq_id,
            'supervisorId' => $workOrder->supervisor->seq_id,
            'workOrderId' => $workOrder->id,
            'workOrderPhotoBeforeUrl' => url('workorders/photos/before/'.$workOrder->id),
            'workOrderBeforePhotos' => $imagesBeforeWork,
        ]);

        return view('workorders.edit', compact('workOrder', 'services', 'supervisors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateWorkOrderRequest $request, $seq_id)
    {
        $admin = $this->loggedUserAdministrator();
        $workOrder = $admin->workOrderBySeqId($seq_id);

        $this->authorize('update', $workOrder);

        $startDate = (new Carbon($request->start, $admin->timezone))->setTimezone('UTC');
        $service = $this->loggedUserAdministrator()->serviceBySeqId($request->service);
        $supervisor = $this->loggedUserAdministrator()->supervisorBySeqId($request->supervisor);

        $workOrder->fill(array_merge(
                            array_map('htmlentities', $request->all()),
                            [
                                'start' => $startDate,
                                'service_id' => $service->id,
                                'supervisor_id' => $supervisor->id,
                            ]
                        ));

        $workOrder->save();

        flash()->success('Updated', 'Work Order was successfully updated.');
        return redirect('workorders/'.$workOrder->seq_id);
    }

    public function getPhotosBefore($seq_id)
    {
        $workOrder = $this->loggedUserAdministrator()->workOrderBySeqId($seq_id);
        $this->authorize('view', $workOrder);
        return $this->getPhoto($workOrder, 'before');
    }

    public function getPhotosAfter($seq_id)
    {
        $workOrder = $this->loggedUserAdministrator()->workOrderBySeqId($seq_id);
        $this->authorize('view', $workOrder);
        return $this->getPhoto($workOrder, 'after');
    }


    public function addPhotoBefore(Request $request, $seq_id)
    {
        $workOrder = $this->loggedUserAdministrator()->workOrderBySeqId($seq_id);
        $this->authorize('addPhoto', $workOrder);
        return $this->addPhoto($request, $workOrder, 1);
    }

    public function addPhotoAfter(Request $request, $seq_id)
    {
        $workOrder = $this->loggedUserAdministrator()->workOrderBySeqId($seq_id);
        $this->authorize('finish', $workOrder);
        return $this->addPhoto($request, $workOrder, 2);
    }

    public function removePhotoBefore($seq_id, $order)
    {
        $workOrder = $this->loggedUserAdministrator()->workOrderBySeqId($seq_id);
        $this->authorize('removePhoto', $workOrder);
        return $this->removePhoto($workOrder, $order, 1);
    }

    public function removePhotoAfter($seq_id, $order)
    {
        $workOrder = $this->loggedUserAdministrator()->workOrderBySeqId($seq_id);
        $this->authorize('finish', $workOrder);
        return $this->removePhoto($workOrder, $order, 2);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $seq_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($seq_id)
    {
        $admin = $this->loggedUserAdministrator();
        $workOrder = $admin->workOrderBySeqId($seq_id);

        $this->authorize('delete', $workOrder);

        if($workOrder->delete()){
            flash()->success('Deleted', 'The work order successfully deleted.');
            return response()->json([
                'message' => 'The work order was deleted successfully.'
            ]);
        }
        return response()->json([
                'error' => 'The work order was not deleted, please try again later.'
            ], 500);
    }

    private function getPhoto(WorkOrder $workOrder, $type)
    {
        if($type == 'after'){
            return $this->imageTransformer->transformCollection($workOrder->imagesAfterWork());
        }
        return $this->imageTransformer->transformCollection($workOrder->imagesBeforeWork());
    }

    private function addPhoto(Request $request, WorkOrder $workOrder, $type)
    {
        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png'
        ]);

        $file = $request->file('photo');
        if($image = $workOrder->addImageFromForm($file)){
            $image->type = $type;
            $image->save();
            return response()->json([
                'message' => 'The photo was added to the work order'
            ]);
        }
        return response()->json([
                'error' => 'The photo could not added to the work order'
            ], 500);

    }

    private function removePhoto(WorkOrder $workOrder, $order, $type)
    {
        $image = $workOrder->image($order, false, $type);

        if($image->delete()){
                return response()->json([
                'message' => 'The photo was deleted from the work order'
            ]);
        }
        return response()->json([
                'error' => 'The photo could not deleted from the work order'
            ], 500);
    }
}
