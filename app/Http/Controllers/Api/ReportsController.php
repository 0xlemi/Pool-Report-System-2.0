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
        if($this->getUser()->cannot('index', Report::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if(isset($request->date)){
            return $this->indexByDate($request->date);
        }

        $validator = Validator::make($request->all(), [
            'limit' => 'numeric|between:0,25'
        ]);

        if ($validator->fails()) {
            // return error responce
            return $this->setStatusCode(422)->RespondWithError('Paramenters failed validation.', $validator->errors()->toArray());
        }

        $limit = ($request->limit)?: 5;
        $reports = $this->loggedUserAdministrator()->reports()->paginate($limit);

        return $this->respondWithPagination(
            $reports,
            $this->reportTransformer->transformCollection($reports)
        );
    }

    /**
     * Get the reports by date
     * tested
     * @param  String $date format YYYY-MM-DD
     * @return $reports
     */
    public function indexByDate(String $date)
    {
        if($this->getUser()->cannot('index', Report::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if(!validateDate($date))
        {
            return $this->setStatusCode(422)->RespondWithError('The date is invalid');
        }

        // Needs pagination
        $reports = $this->loggedUserAdministrator()->reportsByDate($date)->get();

        return $this->respond([
            'data' => $this->reportTransformer->transformCollection($reports),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * tested
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // check that user has permission
        if($this->getUser()->cannot('create', Report::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $admin = $this->loggedUserAdministrator();

        // Validate
            $this->validateReportCreate($request);
            // validate and get the service
            try {
                $service = $admin->serviceBySeqId($request->service_id);
            }catch(ModelNotFoundException $e){
                return $this->respondNotFound('Service with that id, does not exist.');
            }
            // validate and get the technician_id
            try {
                $technician_id = $admin->technicianBySeqId($request->technician_id)->id;
            }catch(ModelNotFoundException $e){
                return $this->respondNotFound('Technician with that id, does not exist.');
            }

        // check if the report was made on time
        $on_time = $this->reportHelpers->checkOnTime(
                $request->completed,
                $service->start_time,
                $service->end_time
            );

        // ***** Persisting *****
        $report = DB::transaction(function () use($request, $service, $technician_id, $on_time) {

            // create report
            $report = Report::create([
                'service_id' => $service->id,
                'technician_id' => $technician_id,
                'completed' => $request->completed,
                'on_time' => $on_time,
                'ph' => $request->ph,
                'chlorine' => $request->chlorine,
                'temperature' => $request->temperature,
                'turbidity' => $request->turbidity,
                'salt' => $request->salt,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'altitude' => $request->altitude,
                'accuracy' => $request->accuracy,
            ]);

            // add photos
            $report->addImageFromForm($request->file('photo1'));
            $report->addImageFromForm($request->file('photo2'));
            $report->addImageFromForm($request->file('photo3'));

            return $report;

        });

        //send email
        $report->sendEmailAllClients();
        $report->sendEmailSupervisor();

        return $this->respondPersisted(
            'The report was successfuly created.',
            $this->reportTransformer->transform($admin->reports(true)->first())
        );

    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($seq_id)
    {
        if($this->getUser()->cannot('show', Report::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        try {
            $report = $this->loggedUserAdministrator()->reportsBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Report with that id, does not exist.');
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
        // check if user has permission
        if($this->getUser()->cannot('edit', Report::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $admin = $this->loggedUserAdministrator();

        // Validate
            // validate core attributes
            $this->validateReportUpdate($request);
            // validate and get the Report
            try {
                $report = $admin->reportsBySeqId($seq_id);
            }catch(ModelNotFoundException $e){
                return $this->respondNotFound('Report with that id, does not exist.');
            }
            // validate and get the service
            try {
                if(isset($request->service_id)){
                    $service = $admin->serviceBySeqId($request->service_id);
                }else{
                    $service = $report->service();
                }
            }catch(ModelNotFoundException $e){
                return $this->respondNotFound('Service with that id, does not exist.');
            }
            // validate and get the technician_id
            try {
                if(isset($request->technician_id)){
                    $technician_id = $admin->technicianBySeqId($request->technician_id)->id;
                }else{
                    $technician_id = $report->technician_id;
                }
            }catch(ModelNotFoundException $e){
                return $this->respondNotFound('Technician with that id, does not exist.');
            }
        // end validation

        // If they are changing the completed time, check that the report was made on time
        if(isset($request->completed)){
            $on_time = $this->reportHelpers->checkOnTime(
                    $request->completed,
                    $service->start_time,
                    $service->end_time
                );
        }else{
            $on_time = $report->on_time;
        }

        // ***** Persisting *****
        $transaction = DB::transaction(function () use($request, $report, $service, $technician_id, $on_time) {
            // $service and $technician_id were checked allready
            $report->service_id = $service->id;
            $report->technician_id = $technician_id;
            $report->on_time = $on_time;

            // if(isset($request->completed)){ $report->completed = $request->completed; }
            // if(isset($request->ph)){ $report->ph = $request->ph; }
            // if(isset($request->chlorine)){ $report->chlorine = $request->chlorine; }
            // if(isset($request->temperature)){ $report->temperature = $request->temperature; }
            // if(isset($request->turbidity)){ $report->turbidity = $request->turbidity; }
            // if(isset($request->salt)){ $report->salt = $request->salt; }
            // if(isset($request->latitude)){ $report->latitude = $request->latitude; }
            // if(isset($request->longitude)){ $report->longitude = $request->longitude; }
            // if(isset($request->altitude)){ $report->altitude = $request->altitude; }
            // if(isset($request->accuracy)){ $report->accuracy = $request->accuracy; }

            $report->fill($request->all());

            $report->save();

            if(isset($request->photo1)){
                $report->deleteImage(1);
                $report->addImageFromForm($request->file('photo1'));
            }
            if(isset($request->photo2)){
                $report->deleteImage(2);
                $report->addImageFromForm($request->file('photo2'));
            }
            if(isset($request->photo3)){
                $report->deleteImage(3);
                $report->addImageFromForm($request->file('photo3'));
            }

        });

        return $this->respondPersisted(
            'The report was successfully updated.',
            $this->reportTransformer->transform($this->loggedUserAdministrator()->reportsBySeqId($seq_id))
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
        if($this->getUser()->cannot('destroy', Report::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        try{
            $report = $this->loggedUserAdministrator()->reportsBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Report with that id, does not exist.');
        }

        if($report->delete()){
            return $this->respondWithSuccess('Report was successfully deleted');
        }

        return $this->respondNotFound('Report with that id, does not exist.');
    }

    protected function validateReportCreate(Request $request)
    {
        return $this->validate($request, [
            'service_id' => 'required|integer|min:1',
            'technician_id' => 'required|integer|min:1',
            'completed' => 'required|date',
            'ph' => 'required|integer|between:1,5',
            'chlorine' => 'required|integer|between:1,5',
            'temperature' => 'required|integer|between:1,5',
            'turbidity' => 'required|integer|between:1,4',
            'salt' => 'required|integer|between:1,5',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'altitude' => 'required|numeric|between:0,100000',
            'accuracy' => 'required|numeric|between:0,100000',
            'photo1' => 'required|mimes:jpg,jpeg,png',
            'photo2' => 'required|mimes:jpg,jpeg,png',
            'photo3' => 'required|mimes:jpg,jpeg,png',
        ]);
    }

    protected function validateReportUpdate(Request $request)
    {
        return $this->validate($request, [
            'service_id' => 'integer|min:1',
            'technician_id' => 'integer|min:1',
            'completed' => 'date',
            'ph' => 'integer|between:1,5',
            'chlorine' => 'integer|between:1,5',
            'temperature' => 'integer|between:1,5',
            'turbidity' => 'integer|between:1,4',
            'salt' => 'integer|between:1,5',
            'latitude' => 'numeric|between:-90,90',
            'longitude' => 'numeric|between:-180,180',
            'altitude' => 'numeric|between:0,100000',
            'accuracy' => 'numeric|between:0,100000',
            'photo1' => 'mimes:jpg,jpeg,png',
            'photo2' => 'mimes:jpg,jpeg,png',
            'photo3' => 'mimes:jpg,jpeg,png',
        ]);
    }

}
