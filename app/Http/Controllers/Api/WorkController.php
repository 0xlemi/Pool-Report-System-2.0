<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use DB;
use App\Work;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PRS\Transformers\WorkTransformer;
use App\PRS\Classes\Logged;

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
        if(Logged::user()->cannot('list', Work::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request, [
            'limit' => 'integer|between:1,25'
        ]);

        try {
            $workOrder = Logged::company()->workOrders()->bySeqId($workOrderSeqId);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Work Order with that id, does not exist.');
        }

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
        if(Logged::user()->cannot('create', Work::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $company = Logged::company();
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'required|numeric',
            'units' => 'required|string|max:20',
            'cost' => 'required|numeric|max:10000000',
            'person' => 'required|integer|existsBasedOnCompany:user_role_company,'.$company->id,
            'photos' => 'array',
            'photos.*' => 'required|mimes:jpg,jpeg,png',
        ]);

        try {
            $workOrder = $company->workOrders()->bySeqId($workOrderSeqId);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Work Order with that id, does not exist.');
        }

        $person = $company->userRoleCompanies()->bySeqId($request->person);

        // ***** Persisting *****
        $work = DB::transaction(function () use($request, $workOrder, $person){

            $work = $workOrder->works()->create(array_merge(
                                array_map('htmlentities', $request->except('photos')),
                                [
                                    'user_role_company_id' => $person->id,
                                ]
                            ));

            // Add Photos
            if(isset($request->photos)){
                foreach ($request->photos as $photo){
                    $work->addImageFromForm($photo);
                }
            }

            return $work;
        });

        if($work){
            return $this->respondPersisted(
                'Work created successfully.',
                $this->workTransformer->transform($work)
            );
        }
        return response()->json(['error' => 'Work was not created.'] , 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Work $work)
    {
        if(Logged::user()->cannot('view', $work))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        return $this->respond([
            'data' => $this->workTransformer->transform($work)
        ]);
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
        if(Logged::user()->cannot('update', $work))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $company = Logged::company();
        $this->validate($request, [
            'title' => 'string|max:255',
            'description' => 'string',
            'quantity' => 'numeric',
            'units' => 'string|max:255',
            'cost' => 'numeric',
            'person' => 'integer|existsBasedOnCompany:user_role_company,'.$company->id,
            'add_photos' =>'array',
            'add_photos.*' => 'required|mimes:jpg,jpeg,png',
            'remove_photos' =>'array',
            'remove_photos.*' => 'required|integer|min:1',
        ]);


        // ***** Persisting *****
        DB::transaction(function () use($request, $work, $company){

            $work->fill(array_map('htmlentities',
                    $request->except([
                        'user_role_company_id',
                        'add_photos',
                        'remove_photos',
                    ])
            ));

            if($request->has('person')){
                $work->userRoleCompany()->associate($company->userRoleCompanies()->bySeqId($request->person));
            }

            $work->save();

            //Delete Photos
            if(isset($request->remove_photos) && Logged::user()->can('removePhoto', $work)){
                foreach ($request->remove_photos as $order) {
                    $work->deleteImage($order);
                }
            }

            // Add Photos
            if(isset($request->add_photos) && Logged::user()->can('addPhoto', $work)){
                foreach ($request->add_photos as $photo) {
                    $work->addImageFromForm($photo);
                }
            }

        });

        return $this->respondPersisted(
            'Work updated successfully.',
            $this->workTransformer->transform($work)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Work $work)
    {
        if(Logged::user()->cannot('delete', $work))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if($work->delete()){
            return response()->json([
                'message' => 'Work deleted successfully.',
                ] , 200);
        }
        return response()->json(['error' => 'Work was not deleted.'] , 500);
    }
}
