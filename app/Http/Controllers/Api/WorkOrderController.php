<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PRS\Transformers\WorkOrderTransformer;
use App\WorkOrder;
use App\Work;
use Carbon\Carbon;
use DB;

class WorkOrderController extends ApiController
{
    protected $workOrderTransformer;

    public function __construct(WorkOrderTransformer $workOrderTransformer)
    {
        $this->workOrderTransformer = $workOrderTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($this->getUser()->cannot('list', WorkOrder::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request, [
            'limit' => 'integer|between:1,25',
            'finished' => 'boolean',
        ]);

        $admin = $this->loggedUserAdministrator();

        $limit = ($request->limit)?: 5;
        $operator = ($request->finished) ? '!=' : '=';
        if($request->has('finished')){
            $workOrders = $admin->workOrdersInOrder()
                            ->where('end', $operator, null)
                            ->paginate($limit);
        }else{
            $workOrders = $admin->workOrdersInOrder()
                            ->paginate($limit);
        }

        return $this->respondWithPagination(
            $workOrders,
            $this->workOrderTransformer->transformCollection($workOrders)
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($this->getUser()->cannot('create', WorkOrder::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $admin = $this->loggedUserAdministrator();

        $this->validate($request,[
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'service' => 'required|integer|existsBasedOnAdmin:services,'.$admin->id,
            'supervisor' => 'required|integer|existsBasedOnAdmin:supervisors,'.$admin->id,
            'start' => 'required|date',
            'price' => 'required|numeric|max:10000000',
            'currency' => 'required|string|size:3',
            'add_photos' => 'array',
            'add_photos.*' => 'required|mimes:jpg,jpeg,png',
        ]);

        $service = $admin->serviceBySeqId($request->service);
        $supervisor = $admin->supervisorBySeqId($request->supervisor);

        // ***** Persisting *****
        $workOrder = DB::transaction(function () use($request, $service, $supervisor) {

            $workOrder = $service->workOrders()->create([
                'title' => $request->title,
                'description' => $request->description,
                'start' => (new Carbon( $request->start))->setTimezone('UTC'),
                'price' => $request->price,
                'currency' => $request->currency,
                'supervisor_id' => $supervisor->id,
            ]);

            // Add Photos before work
            if(isset($request->add_photos)){
                foreach ($request->add_photos as $photo) {
                    $workOrder->addImageFromForm($photo);
                }
            }

            return $workOrder;
        });

        if($workOrder){
            return $this->respondPersisted(
                'Work Order was created successfully.',
                $this->workOrderTransformer->transform(WorkOrder::findOrFail($workOrder->id))
            );
        }
        return response()->json([
            'error' => 'Work Order was not created.',
        ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($seq_id)
    {
        try{
            $workOrder = $this->loggedUserAdministrator()->workOrderBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('WorkOrder with that id, does not exist.');
        }

        if($this->getUser()->cannot('view', $workOrder))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        return $this->respond([
            'data' => $this->workOrderTransformer->transform($workOrder),
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $seq_id)
    {
        $admin = $this->loggedUserAdministrator();
        try{
            $workOrder = $admin->workOrderBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('WorkOrder with that id, does not exist.');
        }

        if($this->getUser()->cannot('update', $workOrder))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request,[
            'title' => 'string|max:255',
            'description' => 'string',
            'start' => 'date',
            'supervisor' => 'integer|existsBasedOnAdmin:supervisors,'.$admin->id,
            'add_photos' => 'array',
            'add_photos.*' => 'required|mimes:jpg,jpeg,png',
            'remove_photos' => 'array',
            'remove_photos.*' => 'required|integer|min:1',
        ]);

        // check that work order is not marked as finished
        if($workOrder->end()->finished()){
            return response()->json([
                'error' => 'Work order cannot be changed once is finished.'
            ], 422);
        }

        // ***** Persisting *****
        DB::transaction(function () use($request, $workOrder, $admin) {

            $workOrder->fill(array_map('htmlentities',
                    $request->except([
                        'start',
                        'supervisor_id',
                        'add_photos',
                        'remove_photos',
                        'price',
                        'currency'
                        ]
                    )
            ));

            if(isset($request->start)){
                $workOrder->start = (new Carbon($request->start))->setTimezone('UTC');
            }
            if(isset($request->supervisor)){
                $workOrder->supervisor()->associate($admin->supervisorBySeqId($request->supervisor));
            }

            $workOrder->save();

            //Delete Photos
            if(isset($request->remove_photos) && $this->getUser()->can('removePhoto', $workOrder)){
                foreach ($request->remove_photos as $order) {
                    $workOrder->deleteImage($order);
                }
            }

            // Add Photos
            if(isset($request->add_photos) && $this->getUser()->can('addPhoto', $workOrder)){
                foreach ($request->add_photos as $photo) {
                    $workOrder->addImageFromForm($photo);
                }
            }
        });

        return $this->respondPersisted(
            'Work Order was updated successfully.',
            $this->workOrderTransformer->transform($admin->workOrderBySeqId($seq_id))
        );
    }

    /**
     * Mark WorkOrder as finished
     * @param  Request $request
     * @param  int  $seq_id
     * @return \Illuminate\Http\Response
     */
    public function finish(Request $request, $seq_id)
    {
        $admin = $this->loggedUserAdministrator();
        try{
            $workOrder = $admin->workOrderBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('WorkOrder with that id, does not exist.');
        }

        if($this->getUser()->cannot('finish', $workOrder))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        // check that work order is not marked as finished
        if($workOrder->end()->finished()){
            return response()->json([
                'error' => 'This Work Order was already finished.'
            ], 422);
        }

        $this->validate($request, [
            'end' => 'required|date|afterDB:work_orders,start,'.$workOrder->id,
            'photos' => 'array',
            'photos.*' => 'required|mimes:jpg,jpeg,png',
        ]);

        // ***** Persisting *****
        $save = DB::transaction(function () use($request, $workOrder, $admin) {
            $workOrder->end = (new Carbon( $request->end ))->setTimezone('UTC');

            // Add Photos
            if(isset($request->photos)){
                foreach ($request->photos as $photo) {
                    $workOrder->addImageFromForm($photo, null, 2);
                }
            }
            return $workOrder->save();
        });

        if($save){
            return response()->json([
                'message' => 'Work Order was marked as finished successfully.',
            ]);
        }
        return response()->json([
            'error' => 'Work Order was not marked as finished.',
        ], 500);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($seq_id)
    {
        try{
            $workOrder = $this->loggedUserAdministrator()->workOrderBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('WorkOrder with that id, does not exist.');
        }

        if($this->getUser()->cannot('delete', $workOrder))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if($workOrder->delete()){
            return response()->json([
                'message' => 'Work Order was deleted successfully.',
            ]);
        }
        return response()->json([
            'error' => 'Work Order was not deleted.',
        ], 500);
    }
}
