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
        // check permissions

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
        // check permissions

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
        // check permissions

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
        $workOrder->end = (new Carbon($request->end, $admin->timezone))->setTimezone('UTC');
        $workOrder->save();

        return Response::json([
                'title' => 'Work Order Finished',
                'message' => 'The work order has been finalized successfully.'
            ], 200);
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

        if($workOrder->end()->finished()){
            return $this->respondWithValidationError('Work Order can\'t be changed once finilized.');
        }

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

    public function getPhotosBefore($id)
    {
        return $this->getPhoto($id, 'before');
    }

    public function getPhotosAfter($id)
    {
        return $this->getPhoto($id, 'after');
    }


    public function addPhotoBefore(Request $request, $id)
    {
        return $this->addPhoto($request, $id, 1);
    }

    public function addPhotoAfter(Request $request, $id)
    {
        return $this->addPhoto($request, $id, 2);
    }

    public function removePhotoBefore($id, $order)
    {
        return $this->removePhoto($id, $order, 1);
    }

    public function removePhotoAfter($id, $order)
    {
        return $this->removePhoto($id, $order, 2);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($seq_id)
    {
        $admin = $this->loggedUserAdministrator();
        $workOrder = $admin->workOrderBySeqId($seq_id);

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

    private function getPhoto($id, $type)
    {
        try{
            $workOrder = WorkOrder::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Work Order with that id, does not exist.');
        }

        if($type == 'after'){
            return $this->imageTransformer->transformCollection($workOrder->imagesAfterWork());
        }
        return $this->imageTransformer->transformCollection($workOrder->imagesBeforeWork());
    }

    private function addPhoto(Request $request, $id, $type)
    {
        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png'
        ]);

        // refactor this
        try {
            $workOrder = WorkOrder::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Work Order with that id, does not exist.');
        }

        $file = $request->file('photo');
        if($image = $workOrder->addImageFromForm($file)){
            $image->type = $type;
            $image->save();
            return Response::json([
                'message' => 'The photo was added to the work order'
            ], 200);
        }
        return Response::json([
                'error' => 'The photo could not added to the work order'
            ], 500);

    }

    private function removePhoto($id, $order, $type)
    {
        try {
            $workOrder = WorkOrder::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Work with that id, does not exist.');
        }

        $image = $workOrder->image($order, false, $type);

        if($image->delete()){
                return Response::json([
                'message' => 'The photo was deleted from the work order'
            ], 200);
        }
        return Response::json([
                'error' => 'The photo could not deleted from the work order'
            ], 500);
    }
}
