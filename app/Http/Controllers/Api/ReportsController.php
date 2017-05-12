<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Report;

use Validator;
use DB;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PRS\Transformers\ReportTransformer;
use App\PRS\Helpers\ReportHelpers;
use App\PRS\Classes\Logged;

class ReportsController extends ApiController
{

    protected $reportTransformer;
    protected $reportHelpers;

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(ReportTransformer $reportTransformer, ReportHelpers $reportHelpers)
    {
        $this->reportTransformer = $reportTransformer;
        $this->reportHelpers = $reportHelpers;
    }

    /**
     * Display a listing of the resource.
     * tested
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Logged::user()->cannot('list', Report::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request, [
            'limit' => 'integer|between:1,25',
            'date' => 'validDateReportFormat'
        ]);

        $limit = ($request->limit)?: 5;

        if(isset($request->date)){
            return $this->indexByDate($request->date, $limit);
        }

        $reports = Logged::company()->reports()->seqIdOrdered()->paginate($limit);

        return $this->respondWithPagination(
            $reports,
            $this->reportTransformer->transformCollection($reports)
        );
    }

    /**
     * Get the reports by date
     * tested
     * @param  String $date format YYYY-MM-DD the timezone may not be UTC
     * @return $reports
     */
    public function indexByDate(String $date_str, int $limit)
    {
        if(Logged::user()->cannot('list', Report::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $company = Logged::company();

        $date = new Carbon($date_str, $company->timezone);

        $reports = $company->reportsByDate($date)->paginate($limit);

        return $this->respondWithPagination(
            $reports,
            $this->reportTransformer->transformCollection($reports)
        );
    }

    /**
     * Store a newly created resource in storage.
     * tested
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Logged::user()->cannot('create', Report::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $company = Logged::company();

        // Validate
        $this->validate($request, [
            'completed' => 'required|date',
            'service' => 'required|integer|existsBasedOnCompany:services,'.$company->id,
            'person' => 'required|integer|existsBasedOnCompany:user_role_company,'.$company->id,

            'readings' => 'array',
            'readings.*' => 'required|array|checkReportCanAcceptReading:service|validMeasurementValue:measurement',
            'readings.*.measurement' => 'required|integer',
            'readings.*.value' => 'required|integer',

            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'altitude' => 'numeric|between:-100,9000',
            'accuracy' => 'required|numeric|between:0,100000',

            'add_photos' => 'required|array|size:3',
            'add_photos.*' => 'required|mimes:jpg,jpeg,png',
        ]);

        $service = $company->services()->bySeqId($request->service);
        $person = $company->userRoleCompanies()->bySeqId($request->person);


        $completed_at = (new Carbon($request->completed_at, $company->timezone));
        // check if the report was made on time
        $on_time = 'noContract';
        if($service->hasServiceContract()){
            $on_time = $this->reportHelpers->checkOnTimeValue(
                $completed_at,
                $service->serviceContract->start_time,
                $service->serviceContract->end_time,
                $company->timezone
            );
        }

        // ***** Persisting *****
        $report = DB::transaction(function () use($request, $service, $person, $on_time, $completed_at, $company) {

            // create report
            $report = $service->reports()->create(array_map('htmlentities', [
                'user_role_company_id' => $person->id,
                'completed' => $completed_at->setTimezone('UTC'),
                'on_time' => $on_time,

                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'altitude' => $request->altitude,
                'accuracy' => $request->accuracy,
            ]));

            // Add Readings
            if(isset($request->readings)){
                foreach ($request->readings as $reading) {
                    $globalMeasurement = $company->globalMeasurements()->bySeqId($reading['measurement']);
                    $measurement = $service->measurements()->where('global_measurement_id', $globalMeasurement->id)->firstOrFail();
                    $report->readings()->create([
                        'measurement_id' => $measurement->id,
                        'value' => $reading['value'],
                    ]);
                }
            }

            // Add Photos
            if(isset($request->add_photos)){
                foreach ($request->add_photos as $photo) {
                    $report->addImageFromForm($photo);
                }
            }

            return $report;
        });

        return $this->respondPersisted(
            'The report was successfuly created.',
            $this->reportTransformer->transform(Report::findOrFail($report->id))
        );

    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($seq_id)
    {
        try {
            $report = Logged::company()->reports()->bySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Report with that id, does not exist.');
        }

        if(Logged::user()->cannot('view', $report))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if($report){
            return $this->respond([
                'data' => $this->reportTransformer->transform($report),
            ]);
        }

        return $this->respondInternalError();
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $seq_id)
    {
        $company = Logged::company();
        try {
            $report = $company->reports()->bySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Report with that id, does not exist.');
        }

        if(Logged::user()->cannot('update', $report))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $service = $report->service;
        // Validate
        $this->validate($request, [
            'person' => 'integer|existsBasedOnCompany:user_role_company,'.$company->id, // check that is not a client
            'completed' => 'date',

            'latitude' => 'numeric|between:-90,90',
            'longitude' => 'numeric|between:-180,180',
            'accuracy' => 'numeric|between:0,100000',

            'add_readings' => 'array',
            'add_readings.*' => 'required|array|checkReportCanAcceptReadingFromServiceId:'.$service->id.'|validMeasurementValue:measurement',
            'add_readings.*.measurement' => 'required|integer',
            'add_readings.*.value' => 'required|integer',

            'remove_readings' => 'array',
            'remove_readings.*' => 'required|array|checkReportCanAcceptReadingFromServiceId:'.$service->id,
            'remove_readings.*.measurement' => 'required|integer',

            'add_photos' => 'array',
            'add_photos.*' => 'required|mimes:jpg,jpeg,png',
            'remove_photos' => 'array',
            'remove_photos.*' => 'required|integer|min:4',
        ]);

        // ***** Persisting *****
        $transaction = DB::transaction(function () use($request, $report, $company, $service) {

            // $service and $person were checked allready
            $report->fill(array_map('htmlentities', [
                'completed' => $request->completed,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'accuracy' => $request->accuracy,
            ]));

            if($request->has('service')){
                $report->service()->associate($company->services()->bySeqId($request->service));
            }

            $person = $company->userRolecompanies()->bySeqId($request->person);
            if($request->has('person')){
                $report->userRoleCompany()->associate($person);
            }

            $report->save();

            // // Remove Readings
            // if($request->has('remove_readings')){
            //     foreach ($request->remove_readings as $reading) {
            //         $globalMeasurement = $company->globalMeasurements()->bySeqId($reading['measurement']);
            //         $measurement = $service->measurements()->where('global_measurement_id', $globalMeasurement->id)->firstOrFail();
            //         // dd($measurement->toArray());
            //         dd($service);
            //         dd($report->readings()->measurement()->get()->toArray());
            //         $reading = $report->readings()->where('measurement_id', $measurement->id)->firstOrFail();
            //         // dd([$measurement->id, $report->readings->toArray()]);
            //         $reading->delete();
            //     }
            // }
            //
            // // Add Readings
            // if($request->has('add_readings')){
            //     foreach ($request->add_readings as $reading) {
            //         $globalMeasurement = $company->globalMeasurements()->bySeqId($reading['measurement']);
            //         $measurement = $service->measurements()->where('global_measurement_id', $globalMeasurement->id)->firstOrFail();
            //         // if there is already a reading like this, dont create it
            //         if(!$report->readings->contains('measurement_id', $measurement->id)){
            //             $report->readings()->create([
            //                 'measurement_id' => $measurement->id,
            //                 'value' => $reading['value'],
            //             ]);
            //         }
            //     }
            // }


            //Delete Photos
            if($request->has('remove_photos') && Logged::user()->can('removePhoto', $report)){
                foreach ($request->remove_photos as $order) {
                    $report->deleteImage($order);
                }
            }

            // Add Photos
            if($request->has('add_photos') && Logged::user()->can('addPhotos', $report)){
                foreach ($request->add_photos as $photo) {
                    $report->addImageFromForm($photo);
                }
            }

        });

        return $this->respondPersisted(
            'The report was successfully updated.',
            $this->reportTransformer->transform(Report::find($report->id))
        );
    }

    /**
     * Remove the specified resource from storage.
     * tested
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($seq_id)
    {
        try{
            $report = Logged::company()->reports()->bySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Report with that id, does not exist.');
        }

        if(Logged::user()->cannot('delete', $report))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if($report->delete()){
            return $this->respondWithSuccess('Report was successfully deleted');
        }

        return $this->respondNotFound('Report with that id, does not exist.');
    }

}
