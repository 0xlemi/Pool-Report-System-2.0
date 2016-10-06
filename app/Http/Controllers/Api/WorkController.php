<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use DB;
use App\Work;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PRS\Transformers\WorkTransformer;

class WorkController extends ApiController
{

    protected $workTransformer;

    public function __construct(WorkTransformer $workTransformer)
    {
        $this->workTransformer = $workTransformer;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $workOrderSeqId)
    {
        $this->validate($request, [
            'limit' => 'integer|between:1,25'
        ]);

        $workOrder = $this->loggedUserAdministrator()->workOrderBySeqId($workOrderSeqId);

        $limit = ($request->limit)?: 5;
        $works = $workOrder->works()->paginate($limit);

        return $this->respondWithPagination(
            $works,
            $this->workTransformer->transformCollection($works)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $workOrderSeqId)
    {
        // validation
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'required|numeric',
            'units' => 'required|string|max:255',
            'cost' => 'required|numeric',
            'technician_id' => 'required|integer|min:1',
            'photos.*' => 'mimes:jpg,jpeg,png',
        ]);

        $workOrder = $this->loggedUserAdministrator()->workOrderBySeqId($workOrderSeqId);
        $technician = $this->loggedUserAdministrator()->technicianBySeqId($request->technician_id);

        // ***** Persisting *****
        $work = DB::transaction(function () use($request, $workOrder, $technician){

            $work = Work::create(array_merge(
                                $request->all(),
                                [
                                    'work_order_id' => $workOrder->id,
                                    'technician_id' => $technician->id,
                                ]
                            ));

            // Add Photos
            if(isset($request->photos)){
                foreach ($request->photos as $photo) {
                    $work->addImageFromForm($photo);
                }
            }

            return $work;
        });

        if($work){
            return response()->json([
                'message' => 'Work created successfully.',
                'object' => $this->workTransformer->transform($work),
                ] , 200);
        }
        return response()->json(['message' => 'Work was not created.'] , 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Work $work)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Work $work)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Work $work)
    {
        //
    }
}
