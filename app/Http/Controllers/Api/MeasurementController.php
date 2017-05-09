<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\PRS\Transformers\MeasurementTransformer;
use App\PRS\Classes\Logged;
use App\Measurement;

class MeasurementController extends ApiController
{

    protected $measurementTransformer;

    public function __construct(MeasurementTransformer $measurementTransformer)
    {
        $this->measurementTransformer = $measurementTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $serviceSeqId)
    {
        if(Logged::user()->cannot('list', Measurement::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request, [
            'limit' => 'integer|between:1,25'
        ]);

        try {
            $service = Logged::company()->services()->bySeqId($serviceSeqId);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Service with that id, does not exist.');
        }

        $limit = ($request->limit)?: 5;
        $measurements = $service->measurements()->paginate($limit);

        return $this->respondWithPagination(
            $measurements,
            $this->measurementTransformer->transformCollection($measurements)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $serviceSeqId)
    {
        if(Logged::user()->cannot('create', Measurement::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $company = Logged::company();
        try {
            $service = $company->services()->bySeqId($serviceSeqId);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Service with that id, does not exist.');
        }

        // validation
        $this->validate($request, [
            'global_measurement' => 'required|integer|existsBasedOnCompany:global_measurements,'.$company->id
        ]);

        $globalMeasurementId = $company->globalMeasurements()->bySeqId($request->global_measurement)->id;

        if($service->measurements->contains('global_measurement_id', $globalMeasurementId)){
            return $this->setStatusCode(400)->respondWithError('This service already has this measurement');
        }

        $measurement = $service->measurements()->create([
            'global_measurement_id' => $globalMeasurementId,
        ]);

        if($measurement){
            return $this->respondPersisted(
                'Measurement created successfully.',
                $this->measurementTransformer->transform($measurement)
            );
        }
        return response()->json(['message' => 'Measurement was not created.'] , 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Measurement $measurement)
    {
        if(Logged::user()->cannot('view', $measurement))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        return $this->respond([
            'data' =>$this->measurementTransformer->transform($measurement)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Measurement $measurement)
    {
        if(Logged::user()->cannot('delete', $measurement))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if($measurement->delete()) {
            return response()->json(['message' => 'Measurement was deleted.'] , 200);
        }
        return response()->json(['message' => 'Measurement was not deleted.'] , 500);
    }
}
