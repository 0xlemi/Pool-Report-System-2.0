<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PRS\Transformers\GlobalMeasurementTransformer;
use App\PRS\Classes\Logged;
use App\GlobalMeasurement;
use DB;

class GlobalMeasurementController extends ApiController
{
        protected $measurementTransformer;

    public function __construct(GlobalMeasurementTransformer $measurementTransformer)
    {
        $this->measurementTransformer = $measurementTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($this->loggedUser()->cant('list', GlobalMeasurement::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request, [
            'limit' => 'integer|between:1,25',
        ]);

        $limit = ($request->limit)?: 5;
        $globalMeasurements = Logged::company()->globalMeasurements()->seqIdOrdered()->paginate($limit);

        return $this->respondWithPagination(
            $globalMeasurements,
            $this->measurementTransformer->transformCollection($globalMeasurements)
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
        if($this->loggedUser()->cant('create', GlobalMeasurement::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }
        $this->validate($request, [
            'name' => 'required|string',
            'labels' => 'array',
            'labels.*' => 'required|array',
            'labels.*.name' => 'required|string|max:50',
            'labels.*.value' => 'required|integer',
            'labels.*.color' => [
                'required',
                'regex:/^[A-Fa-f0-9]{6}+$/'
            ],
            'photos' => 'array',
            'photos.*' => 'required|mimes:jpg,jpeg,png',
        ]);

        $company = $this->loggedCompany();

        // Create global measurment
        $globalMeasurment = DB::transaction(function () use($request, $company) {

            $globalMeasurment = $company->globalMeasurements()->create(
                    array_map('htmlentities', $request->except('labels', 'photos'))
            );

            // Add Labels
            if($request->has('labels')){
                foreach($request->labels as $label) {
                    $globalMeasurment->labels()->create([
                        'name' => $label['name'],
                        'value' => $label['value'],
                        'color' => $label['color'],
                    ]);
                }
            }

            // Add Photos
            if(isset($request->photos)){
                foreach ($request->photos as $photo) {
                    $globalMeasurment->addImageFromForm($photo);
                }
            }

            return $globalMeasurment;
        });

        return $this->respondPersisted(
            'The global measurement was successfuly created.',
            $this->measurementTransformer->transform(GlobalMeasurement::find($globalMeasurment->id))
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($seqId)
    {
        try {
            $globalMeasurment = Logged::company()->globalMeasurements()->bySeqId($seqId);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Global Measurment with that id, does not exist.');
        }

        if(Logged::user()->cannot('view', $globalMeasurment))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if($globalMeasurment){
            return $this->respond([
                'data' => $this->measurementTransformer->transform($globalMeasurment),
            ]);
        }

        return $this->respondInternalError();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $seqId)
    {
        if($this->loggedUser()->cant('update', GlobalMeasurement::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }
        $this->validate($request, [
            'name' => 'string',
            'add_labels' => 'array',
            'add_labels.*' => 'required|array',
            'add_labels.*.name' => 'required|string|max:50',
            'add_labels.*.value' => 'required|integer',
            'add_labels.*.color' => [
                'required',
                'regex:/^[A-Fa-f0-9]{6}+$/'
            ],
            'remove_labels' => 'array',
            'remove_labels.*' => 'required|integer',
            'add_photos' => 'array',
            'add_photos.*' => 'required|mimes:jpg,jpeg,png',
            'remove_photos' => 'array',
            'remove_photos.*' => 'required|mimes:jpg,jpeg,png',
        ]);

        $company = $this->loggedCompany();

        // Create global measurment
        $globalMeasurment = DB::transaction(function () use($request, $company) {

            $globalMeasurment = $company->globalMeasurements()->create(
                    array_map('htmlentities', $request->except('labels', 'photos'))
            );

            // Add Labels
            if($request->has('labels')){
                foreach($request->labels as $label) {
                    $globalMeasurment->labels()->create([
                        'name' => $label['name'],
                        'value' => $label['value'],
                        'color' => $label['color'],
                    ]);
                }
            }

            // Add Photos
            if(isset($request->photos)){
                foreach ($request->photos as $photo) {
                    $globalMeasurment->addImageFromForm($photo);
                }
            }

            return $globalMeasurment;
        });

        return $this->respondPersisted(
            'The global measurement was successfuly created.',
            $this->measurementTransformer->transform(GlobalMeasurement::find($globalMeasurment->id))
        );
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
