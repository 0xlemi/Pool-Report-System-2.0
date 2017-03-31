<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Response;
use Storage;

use App\Http\Requests;
use App\Http\Requests\CreateWorkRequest;
use App\Http\Requests\UpdateWorkRequest;
use App\Work;
use App\PRS\Transformers\WorkTransformer;
use App\PRS\Transformers\ImageTransformer;

class WorkController extends PageController
{

    public $workTransformer;
    public $imageTransformer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(WorkTransformer $workTransformer,
                                ImageTransformer $imageTransformer)
    {
        $this->middleware('auth');
        $this->workTransformer = $workTransformer;
        $this->imageTransformer = $imageTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  int  $workOrderSeqId
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $workOrderSeqId)
    {
        $workOrder = $this->loggedCompany()->workOrderBySeqId($workOrderSeqId);
        if($request->user()->activeUser->isRole('client')){
            // Check if client owns workorder, preventing client from looking
            // at works from workorders that are not his
            $this->authorize('view', $workOrder);
        }else{
            $this->authorize('list', Work::class);
        }

        $works = $workOrder->works()
                        ->get()
                        ->transform(function($item){
                            $userRoleCompany = $item->userRoleCompany;
                            return (object) [
                                'id' => $item->id,
                                'title' => $item->title,
                                'quantity' => "{$item->quantity} {$item->units}",
                                'cost' => "{$item->cost} {$item->workOrder->currency}",
                                'technician' => $userRoleCompany->user->fullName,
                            ];
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
        $this->authorize('create', Work::class);

        $company  = $this->loggedCompany();

        $workOrder = $company->workOrderBySeqId($workOrderSeqId);
        $userRoleCompany = $company->userRoleCompanyBySeqId($request->technician);

        $work = $workOrder->works()->create(array_merge(
                    array_map('htmlentities', $request->all()),
                    [
                        // Getting Query Exception
                        'user_role_company_id' => $userRoleCompany->id,
                    ]
                ));

        if($work){
            return response()->json([
                'message' => 'The work was successfully created'
            ]);
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
        $this->authorize('view', $work);

        $userRoleCompany = $work->userRoleCompany;

        return response()->json([
            'title' => $work->title,
            'quantity' => $work->quantity,
            'units' => $work->units,
            'cost' => $work->cost,
            'description' => $work->description,
            'technician' => (object)[
                'id' => $userRoleCompany->seq_id,
                'fullName' => $userRoleCompany->user->fullName,
                'icon' => Storage::url($userRoleCompany->user->icon()),
            ],
            'photos' => $this->imageTransformer
                        ->transformCollection($work->images()->get())
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Work  $work
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWorkRequest $request, Work $work)
    {
        $this->authorize('update', $work);

        $work->update(array_map('htmlentities', $request->except('user_role_company')));

        if($request->has('technician')){
            $work->technician()->associate($this->loggedCompany()->technicianBySeqId($request->technician));
        }

        return response()->json([
                'title' => 'Work Updated',
                'message' => 'The work was successfully updated'
            ]);
    }

    public function addPhoto(Request $request, Work $work)
    {
        $this->authorize('addPhoto', $work);

        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png'
        ]);

        $file = $request->file('photo');
        if($work->addImageFromForm($file)){
            return response()->json([
                'message' => 'The photo was added to the work'
            ]);
        }
        return response()->json([
                'error' => 'The photo could not added to the work'
            ], 500);

    }

    public function removePhoto(Work $work, $order)
    {
        $this->authorize('removePhoto', $work);

        $image = $work->image($order, false);

        if($image->delete()){
                return response()->json([
                'message' => 'The photo was deleted from the work'
            ]);
        }
        return response()->json([
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
        $this->authorize('delete', $work);

        if($work->delete()){
            return response()->json([
                        'message' => 'The work was deleted successfully.'
                    ]);
        }
        return response()->json([
                        'error' => 'The work was not deleted, please try again.'
                    ], 500);
    }
}
