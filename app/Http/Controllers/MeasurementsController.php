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
                            return (object) [
                                    'id' => $item->id,
                                    'name' => $globalMeasurement->name,
                                    'amount' => $item->amount,
                                    'units' => $globalMeasurement->units,
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
                'amount' => $request->amount,
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMeasurementRequest $request, Measurement $measurement)
    {
        $this->authorize('update', $measurement);

        $measurement->update([
            'amount' => $request->amount,
        ]);

        return response()->json([
            'message' => 'Measurement was successfully updated.'
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
