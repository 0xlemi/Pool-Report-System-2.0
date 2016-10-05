<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PRS\Transformers\WorkOrderTransformer;
use App\Work;

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
            'limit' => 'integer|between:1,25'
        ]);

        $limit = ($request->limit)?: 5;
        $workOrders= $this->loggedUserAdministrator()->workOrders()->paginate($limit);

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
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
