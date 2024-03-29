<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JavaScript;
use Response;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Requests\CreateWorkOrderRequest;
use App\Http\Requests\UpdateWorkOrderRequest;
use App\PRS\Helpers\ServiceHelpers;
use App\PRS\Helpers\UserRoleCompanyHelpers;
use App\PRS\Transformers\ImageTransformer;
use App\PRS\Classes\Logged;
use App\WorkOrder;
use App\Notifications\NewWorkOrderNotification;


class WorkOrderController extends PageController
{

    private $serviceHelpers;
    private $userRoleCompanyHelpers;
    private $imageTransformer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ServiceHelpers $serviceHelpers,
                                    UserRoleCompanyHelpers $userRoleCompanyHelpers,
                                    ImageTransformer $imageTransformer)
    {
        $this->middleware('auth');
        $this->serviceHelpers = $serviceHelpers;
        $this->userRoleCompanyHelpers = $userRoleCompanyHelpers;
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

        return view('workorders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', WorkOrder::class);

        $company = $this->loggedCompany();

        $services = $this->serviceHelpers->transformForDropdown($company->services()->seqIdOrdered()->get());
        $persons = $this->userRoleCompanyHelpers->transformForDropdown(
                            $company->userRoleCompanies()
                                        ->ofRole('admin', 'sup', 'tech')
                                        ->seqIdOrdered()->get()
                        );
        $currencies = config('constants.currencies');

        return view('workorders.create', compact('services', 'persons', 'currencies'));
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

        $company = $this->loggedCompany();

        $startDate = (new Carbon($request->start, $company->timezone))->setTimezone('UTC');
        $service = $this->loggedCompany()->services()->bySeqId($request->service);

        $urc = Logged::user()->selectedUser;
        // Only Admins can set the person
        if($urc->isRole('admin') && $request->has('person')){
            if($request->has('person')){
                $person = $company->userRoleCompanies()->bySeqId($request->person);
            }else{
                flash()->error('Person is required', 'Person is required to create the Work Order, please try again.');
                return redirect()->back();
            }
        }else{
            $person = $urc;
        }

        $workOrder = $service->workOrders()->create(array_merge(
                            array_map('htmlentities', $request->all()),
                            [
                                'start' => $startDate,
                                'user_role_company_id' => $person->id,
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
        $company = $this->loggedCompany();
        $workOrder = $company->workOrders()->bySeqId($seq_id);

        $this->authorize('view', $workOrder);

        $imagesBeforeWork = $this->imageTransformer->transformCollection($workOrder->imagesBeforeWork());
        $imagesAfterWork = $this->imageTransformer->transformCollection($workOrder->imagesAfterWork());

        $userRoleCompanies  = $this->userRoleCompanyHelpers->transformForDropdown(
                                $company->userRoleCompanies()->ofRole('admin', 'sup', 'tech')->seqIdOrdered()->get()
                            );
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

        return view('workorders.show', compact('workOrder', 'default_table_url', 'userRoleCompanies'));
    }

    public function finish(Request $request, $seq_id)
    {
        $this->validate($request, [
            'end' => 'required|date'
        ]);
        $company = $this->loggedCompany();
        $workOrder = $company->workOrders()->bySeqId($seq_id);

        $this->authorize('finish', $workOrder);

        // check that work order is not marked as finished
        if($workOrder->end()->finished()){
            return response()->json([
                'title' => 'This Work Order was already finished.',
                'message' => 'You cannot finish a work order that is already finished.'
            ], 400);
        }

        $workOrder->end = (new Carbon($request->end, $company->timezone))->setTimezone('UTC');
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
        $company = $this->loggedCompany();
        $workOrder = $company->workOrders()->bySeqId($seq_id);

        $this->authorize('update', $workOrder);

        $persons = $this->userRoleCompanyHelpers->transformForDropdown(
                                $company->userRoleCompanies()
                                        ->ofRole('admin', 'sup', 'tech')
                                        ->seqIdOrdered()->get()
                            );

        $date = (new Carbon($workOrder->start, 'UTC'))
                    ->setTimezone($company->timezone)
                    ->format('m/d/Y h:i:s A');
        JavaScript::put([
            'defaultDate' => $date,
        ]);

        return view('workorders.edit', compact('workOrder', 'persons'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWorkOrderRequest $request, $seq_id)
    {
        $company = $this->loggedCompany();
        $workOrder = $company->workOrders()->bySeqId($seq_id);

        $this->authorize('update', $workOrder);

        // check that work order is not marked as finished
        if($workOrder->end()->finished()){
            return response()->json([
                'title' => 'This Work Order was already finished.',
                'message' => 'You cannot edit a workorder that is already finished.'
            ], 400);
        }

        $startDate = (new Carbon($request->start, $company->timezone))->setTimezone('UTC');

        $workOrder->fill(array_merge(
                            array_map('htmlentities', $request->except(['price', 'currency'])),
                            [
                                'start' => $startDate,
                            ]
                        ));

        $urc = Logged::user()->selectedUser;
        // Only System Administrator can change the person
        if($urc->isRole('admin')){
            if($request->has('person')){
                $person = $company->UserRoleCompanies()->bySeqId($request->person);
                $workOrder->user_role_company_id = $person->id;
            }
        }

        $workOrder->save();

        flash()->success('Updated', 'Work Order was successfully updated.');
        return redirect('workorders/'.$workOrder->seq_id);
    }

    public function getPhotosBefore($seq_id)
    {
        $workOrder = $this->loggedCompany()->workOrders()->bySeqId($seq_id);
        $this->authorize('view', $workOrder);
        return $this->getPhoto($workOrder, 'before');
    }

    public function getPhotosAfter($seq_id)
    {
        $workOrder = $this->loggedCompany()->workOrders()->bySeqId($seq_id);
        $this->authorize('view', $workOrder);
        return $this->getPhoto($workOrder, 'after');
    }


    public function addPhotoBefore(Request $request, $seq_id)
    {
        $workOrder = $this->loggedCompany()->workOrders()->bySeqId($seq_id);
        $this->authorize('addPhoto', $workOrder);
        return $this->addPhoto($request, $workOrder, 1);
    }

    public function addPhotoAfter(Request $request, $seq_id)
    {
        $workOrder = $this->loggedCompany()->workOrders()->bySeqId($seq_id);
        $this->authorize('finish', $workOrder);
        return $this->addPhoto($request, $workOrder, 2);
    }

    public function removePhotoBefore($seq_id, $order)
    {
        $workOrder = $this->loggedCompany()->workOrders()->bySeqId($seq_id);
        $this->authorize('removePhoto', $workOrder);
        return $this->removePhoto($workOrder, $order, 1);
    }

    public function removePhotoAfter($seq_id, $order)
    {
        $workOrder = $this->loggedCompany()->workOrders()->bySeqId($seq_id);
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
        $company = $this->loggedCompany();
        $workOrder = $company->workOrders()->bySeqId($seq_id);

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
