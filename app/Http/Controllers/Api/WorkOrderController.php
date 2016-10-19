<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

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
        $this->validate($request, [
            'limit' => 'integer|between:1,25',
            'finished' => 'boolean',
        ]);

        $admin = $this->loggedUserAdministrator();

        $limit = ($request->limit)?: 5;
        if($request->has('finished')){
            $workOrders = $admin->workOrdersInOrder()
                            ->where('finished', $request->finished)
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
        // validation
        $this->validate($request,[
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'service_id' => 'required|integer|min:1',
            'supervisor_id' => 'required|integer|min:1',
            'start' => 'required|date',
            'price' => 'required|numeric|max:10000000',
            'currency' => 'required|string|size:3',
            'photosBeforeWork.*' => 'mimes:jpg,jpeg,png',
        ]);


        $admin = $this->loggedUserAdministrator();

        // send json friendly message if not found
        $service = $admin->serviceBySeqId($request->service_id);
        $supervisor = $admin->supervisorBySeqId($request->supervisor_id);


        // ***** Persisting *****
        $workOrder = DB::transaction(function () use($request, $service, $supervisor) {

            $workOrder = WorkOrder::create([
                'title' => $request->title,
                'description' => $request->description,
                'start' => (new Carbon( $request->start))->setTimezone('UTC'),
                'price' => $request->price,
                'currency' => $request->currency,
                'service_id' => $service->id,
                'supervisor_id' => $supervisor->id,
            ]);

            // Add Photos
            if(isset($request->photosBeforeWork)){
                foreach ($request->photosBeforeWork as $photo) {
                    $workOrder->addImageFromForm($photo);
                }
            }

            return $workOrder;
        });

        if($workOrder){
            return $this->respondPersisted(
                'Work Order was created successfully.',
                $this->workOrderTransformer->transform($admin->workOrdersInOrder('desc')->first())
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
        $workOrder = $this->loggedUserAdministrator()->workOrderBySeqId($seq_id);

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
        // validation
        $this->validate($request,[
            'title' => 'string|max:255',
            'description' => 'string',
            'service_id' => 'integer|min:1',
            'supervisor_id' => 'integer|min:1',
            'start' => 'date',
            'price' => 'numeric|max:10000000',
            'currency' => 'string|size:3',
            'photosBeforeWork.*' => 'mimes:jpg,jpeg,png',
            'photosBeforeWorkDelete.*' => 'integer|min:1',
        ]);


        $admin = $this->loggedUserAdministrator();
        // send json friendly message if not found
        $workOrder = $admin->workOrderBySeqId($seq_id);

        // check that work order is not marked as finished
        if($workOrder->finished){
            return response()->json([
                'error' => 'Work order cannot be changed once is finished.'
            ], 422);
        }


        // ***** Persisting *****
        DB::transaction(function () use($request, $workOrder, $admin) {

            $workOrder->fill(array_map('htmlentities',
                    $request->except([
                        'start',
                        'end',
                        'finished',
                        'service_id',
                        'supervisor_id',
                        'photosBeforeWork',
                        'photosBeforeWorkDelete',
                        ]
                    )
            ));

            if(isset($request->start)){
                $workOrder->start = (new Carbon($request->start))->setTimezone('UTC');
            }
            if(isset($request->service_id)){
                $workOrder->service_id = $admin->serviceBySeqId($request->service_id)->id;
            }
            if(isset($request->supervisor_id)){
                $workOrder->supervisor_id = $admin->supervisorBySeqId($request->supervisor_id)->id;
            }

            //Delete Photos
            if(isset($request->photosBeforeWorkDelete)){
                foreach ($request->photosBeforeWorkDelete as $order) {
                    $workOrder->deleteImage($order);
                }
            }

            // Add Photos
            if(isset($request->photosBeforeWork)){
                foreach ($request->photosBeforeWork as $photo) {
                    $workOrder->addImageFromForm($photo);
                }
            }

            $workOrder->save();
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
        // send json friendly message if not found
        $workOrder = $admin->workOrderBySeqId($seq_id);

        // check that work order is not marked as finished
        if($workOrder->finished){
            return response()->json([
                'error' => 'This Work Order was already finished.'
            ], 422);
        }

        $this->validate($request, [
            'end' => 'required|date|afterDB:work_orders,start,'.$workOrder->id,
            'photosAfterWork.*' => 'mimes:jpg,jpeg,png',
        ]);

        // ***** Persisting *****
        $save = DB::transaction(function () use($request, $workOrder, $admin) {
            $workOrder->end = (new Carbon( $request->end ))->setTimezone('UTC');
            $workOrder->finished = 1;

            // Add Photos
            if(isset($request->photosAfterWork)){
                foreach ($request->photosAfterWork as $photo) {
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
        $workOrder = $this->loggedUserAdministrator()->workOrderBySeqId($seq_id);

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
