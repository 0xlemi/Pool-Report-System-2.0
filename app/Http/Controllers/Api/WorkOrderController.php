<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PRS\Transformers\WorkOrderTransformer;
use App\PRS\Classes\Logged;
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
        if(Logged::user()->cannot('list', WorkOrder::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request, [
            'limit' => 'integer|between:1,25',
            'finished' => 'boolean',
        ]);

        $company = Logged::company();

        $limit = ($request->limit)?: 5;
        if($request->has('finished')){
            $workOrders = $company->workOrders()
                                ->finished($request->finished)
                                ->seqIdOrdered()
                                ->paginate($limit);
        }else{
            $workOrders = $company->workOrders()->seqIdOrdered()
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
        if(Logged::user()->cannot('create', WorkOrder::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $company = Logged::company();

        $this->validate($request,[
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'service' => 'required|integer|existsBasedOnCompany:services,'.$company->id,
            'person' => 'integer|existsBasedOnCompany:user_role_company,'.$company->id,
            'start' => 'required|date',
            'price' => 'required|numeric|max:10000000',
            'currency' => 'required|string|size:3',
            'photos' => 'array',
            'photos.*' => 'required|mimes:jpg,jpeg,png',
        ]);

        $service = $company->services()->bySeqId($request->service);
        $urc = Logged::user()->selectedUser;
        // Only Admins can set the person
        if($urc->isRole('admin')){
            if($request->has('person')){
                $person = $company->userRoleCompanies()->bySeqId($request->person);
            }else{
                return response()->json([ 'person' => ['The person field is required'] ] , 422);
            }
        }else{
            $person = $urc;
        }

        // ***** Persisting *****
        $workOrder = DB::transaction(function () use($request, $service, $person) {

            $workOrder = $service->workOrders()->create([
                'title' => $request->title,
                'description' => $request->description,
                'start' => (new Carbon($request->start))->setTimezone('UTC'),
                'price' => $request->price,
                'currency' => $request->currency,
                'user_role_company_id' => $person->id,
            ]);

            // Add Photos before work
            if(isset($request->photos)){
                foreach ($request->photos as $photo) {
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
            $workOrder = Logged::company()->workOrders()->bySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('WorkOrder with that id, does not exist.');
        }

        if(Logged::user()->cannot('view', $workOrder))
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
        $company = Logged::company();
        try{
            $workOrder = $company->workOrders()->bySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('WorkOrder with that id, does not exist.');
        }

        if(Logged::user()->cannot('update', $workOrder))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request,[
            'title' => 'string|max:255',
            'description' => 'string',
            'start' => 'date',
            'person' => 'integer|existsBasedOnCompany:user_role_company,'.$company->id,
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
        DB::transaction(function () use($request, $workOrder, $company) {

            $workOrder->fill(array_map('htmlentities',
                    $request->except([
                        'start',
                        'user_role_company_id',
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

            $urc = Logged::user()->selectedUser;
            if($urc->isRole('admin') && $request->has('person')){
                $workOrder->userRoleCompany()->associate($company->userRolecompanies()->bySeqId($request->person));
            }

            $workOrder->save();

            //Delete Photos
            if(isset($request->remove_photos) && Logged::user()->can('removePhoto', $workOrder)){
                foreach ($request->remove_photos as $order) {
                    $workOrder->deleteImage($order);
                }
            }

            // Add Photos
            if(isset($request->add_photos) && Logged::user()->can('addPhoto', $workOrder)){
                foreach ($request->add_photos as $photo) {
                    $workOrder->addImageFromForm($photo);
                }
            }
        });

        return $this->respondPersisted(
            'Work Order was updated successfully.',
            $this->workOrderTransformer->transform($company->workOrders()->bySeqId($seq_id))
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
        $company = Logged::company();
        try{
            $workOrder = $company->workOrders()->bySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('WorkOrder with that id, does not exist.');
        }

        if(Logged::user()->cannot('finish', $workOrder))
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
        $save = DB::transaction(function () use($request, $workOrder, $company) {
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
            $workOrder = Logged::company()->workOrders()->bySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('WorkOrder with that id, does not exist.');
        }

        if(Logged::user()->cannot('delete', $workOrder))
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
