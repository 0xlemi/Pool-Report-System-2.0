<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CreateMeasurementRequest;
use App\Http\Requests\UpdateMeasurementRequest;
use App\Measurement;

class MeasurementsController extends PageController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($serviceSeqId)
    {
        $this->authorize('list', Measurement::class);

        $service = $this->loggedCompany()->services()->bySeqId($serviceSeqId);

        $measurements = $service->measurements()
                        ->get()
                        ->transform(function($item){
                            $globalMeasurement = $item->globalMeasurement;
                            $labels = $globalMeasurement->labels()->pluck('name')->toArray();
                            return (object) [
                                    'id' => $item->id,
                                    'name' => $globalMeasurement->name,
                                ];
                        });
        return response()->json([
            'data' => $measurements
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMeasurementRequest $request, $serviceSeqId)
    {
        $this->authorize('create', Measurement::class);

        $company = $this->loggedCompany();
        $service = $company->services()->bySeqId($serviceSeqId);

        $measurement = $service->measurements()->create([
                'global_measurement_id' => $request->global_measurement,
            ]);

        if($measurement){
            return response()->json([
                'message' => 'Measurement was successfully created.'
            ]);
        }
        return response()->json([
                'error' => 'Measurement was not created, please try again.'
            ], 500);
    }

    public function show(Measurement $measurement)
    {
        $this->authorize('view', $measurement);

        $globalMeasurement = $measurement->globalMeasurement;
        return response()->json([
            'data' => (object)[
                'name' => $globalMeasurement->name,
                'labels' => $globalMeasurement->labels,
            ]
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
        $this->authorize('delete', $measurement);

        if($measurement->delete()){
            return response()->json([
                'message' => 'Measurement was successfully deleted.'
            ]);
        }
        return response()->json([
                'error' => 'Measurement was not deleted, please try again.'
            ], 500);
    }
}
