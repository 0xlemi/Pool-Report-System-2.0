<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Response;

use App\Http\Requests;
use App\Http\Requests\CreateWorkRequest;
use App\Work;
use App\PRS\Transformers\WorkTransformer;

class WorkController extends PageController
{

    public $workTransformer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(WorkTransformer $workTransformer)
    {
        $this->middleware('auth');
        $this->workTransformer = $workTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  int  $workOrderSeqId
     * @return \Illuminate\Http\Response
     */
    public function index($workOrderSeqId)
    {
        $workOrder = $this->loggedUserAdministrator()->workOrderBySeqId($workOrderSeqId);

        $works = $workOrder->works()
                        ->get()
                        ->transform(function($item){
                            $technician = $item->technician();
                            return (object) array(
                                'id' => $item->id,
                                'title' => $item->title,
                                'quantity' => "{$item->quantity} {$item->units}",
                                'cost' => "{$item->cost} {$item->workOrder()->currency}",
                                'technician' => "{$technician->name} {$technician->last_name}",
                            );
                        });
        return response()->json([
            'list' => $works,
            'currency' => $workOrder->currency,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $workOrderSeqId
     * @return \Illuminate\Http\Response
     */
    public function store(CreateWorkRequest $request, $workOrderSeqId)
    {
        $workOrder = $this->loggedUserAdministrator()->workOrderBySeqId($workOrderSeqId);

        $work = $workOrder->works()->create(array_map('htmlentities', $request->all()));

        if($work){
            return response()->json([
                'message' => 'The work was successfully created'
            ], 200);
        }
        return response()->json([
                'error' => 'The work was not created created, please try again.'
            ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  Work  $work
     * @return \Illuminate\Http\Response
     */
    public function show(Work $work)
    {
        $technician = $work->technician();

        return response()->json([
            'title' => $work->title,
            'quantity' => $work->quantity,
            'units' => $work->units,
            'cost' => $work->cost,
            'description' => $work->description,
            'technician' => (object)[
                'id' => $technician->seq_id,
                'fullName' => "{$technician->name} {$technician->last_name}",
                'icon' => url($technician->icon()),
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Work  $work
     * @return \Illuminate\Http\Response
     */
    public function update(CreateWorkRequest $request, Work $work)
    {
        $work->update(array_map('htmlentities', $request->except('work_order_id')));

        return Response::json([
                'title' => 'Work Updated',
                'message' => 'The work was successfully updated'
            ], 200);
    }

    public function addPhoto(Request $request, Work $work)
    {
        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png'
        ]);

        $file = $request->file('photo');
        if($work->addImageFromForm($file)){
            return Response::json([
                'message' => 'The photo was added to the work'
            ], 200);
        }
        return Response::json([
                'error' => 'The photo could not added to the work'
            ], 500);

    }

    public function removePhoto(Work $work, $order)
    {
        $image = $work->image($order, false);

        if($image->delete()){
                return Response::json([
                'message' => 'The photo was deleted from the work'
            ], 200);
        }
        return Response::json([
                'error' => 'The photo could not deleted from the work'
            ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Work  $work
     * @return \Illuminate\Http\Response
     */
    public function destroy(Work $work)
    {
        if($work->delete()){
            return response()->json([
                        'message' => 'The work was deleted successfully.'
                    ], 200);
        }
        return response()->json([
                        'error' => 'The work was not deleted, please try again.'
                    ], 500);
    }
}
