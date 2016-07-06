<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Report;

use Validator;
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
        $this->middleware(['api', 'auth:api']);
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

        $reports = $this->loggedUserAdministrator()->reports()->get();

        return $this->respond([
            'data' => $this->reportTransformer->transformCollection($reports),
        ]);
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
        if($this->getUser()->cannot('create', Report::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $validator = $this->validateReportRequest($request);

        if ($validator->fails()) {
            // return error responce
            return $this->setStatusCode(422)->RespondWithError('Paramenters failed validation.', $validator->errors()->toArray());
        }

        $admin = $this->loggedUserAdministrator();

        try {
            $service = $admin->serviceBySeqId($request->service_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Service with that id, does not exist.');
        }

        try {
            $technician = $admin->technicianBySeqId($request->technician_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Technician with that id, does not exist.');
        }

        $on_time = $this->reportHelpers->checkOnTime(
                $request->completed,
                $service->start_time,
                $service->end_time
            );

        $report = Report::create([
            'service_id' => $service->id,
            'technician_id' => $technician->id,
            'completed' => $request->completed,
            'on_time' => $on_time,
            'ph' => $request->ph,
            'clorine' => $request->clorine,
            'temperature' => $request->temperature,
            'turbidity' => $request->turbidity,
            'salt' => $request->salt,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'altitude' => $request->altitude,
            'accuracy' => $request->accuracy,
        ]);

        if($report){
            return $this->respondPersisted(
                'The report was successfuly created.',
                $this->reportTransformer->transform($admin->reports(true)->first())
            );
        }

        return $this->respondInternalError();
    }

    /**
     * Display the specified resource.
     * tested
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
     * tested
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $seq_id)
    {
        if($this->getUser()->cannot('edit', Report::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $validator = $this->validateReportRequest($request);

        if ($validator->fails()) {
            // return error responce
            return $this->setStatusCode(422)
                ->RespondWithError(
                    'Paramenters failed validation.',
                    $validator->errors()->toArray()
                );
        }

        try{
            $report = $this->updateReport($request, $this->loggedUserAdministrator()->reportsBySeqId($seq_id));
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Report with that id, does not exist.');
        }

        // $photo = true;
        // if($request->photo){
        //     $report->images()->delete();
        //     $photo = $report->addImageFromForm($request->file('photo'));
        // }

        if($report->save()){
            return $this->respondPersisted(
                'The report was successfully updated.',
                $this->reportTransformer->transform($this->loggedUserAdministrator()->reportsBySeqId($seq_id))
            );
        }
        return $this->respondInternalError('The report could not be updated.');
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

    protected function validateReportRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'service_id' => 'required|integer|min:1',
            'technician_id' => 'required|integer|min:1',
            'completed' => 'required|date',
            'ph' => 'required|integer|between:1,5',
            'clorine' => 'required|integer|between:1,5',
            'temperature' => 'required|integer|between:1,5',
            'turbidity' => 'required|integer|between:1,4',
            'salt' => 'required|integer|between:1,5',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'altitude' => 'required|numeric|between:0,100000',
            'accuracy' => 'required|numeric|between:0,100000',
            // 'photo1' => 'required|mimes:jpg,jpeg,png',
            // 'photo2' => 'required|mimes:jpg,jpeg,png',
            // 'photo3' => 'required|mimes:jpg,jpeg,png',
        ]);
    }


    protected function updateReport(Request $request, Report $report)
    {
        if(isset($request->service_id)){
            $report->service_id = $request->service_id;
            $service = $this->loggedUserAdministrator()->serviceBySeqId($request->service_id);
        }else{
            $service = $report->service();
        }

        if(isset($request->completed)){
            $report->completed = $request->completed;
            $report->on_time = $this->reportHelpers->checkOnTime(
                                    $request->completed,
                                    $service->start_time,
                                    $service->end_time);
        }

        if(isset($request->ph)){ $report->ph = $request->ph; }
        if(isset($request->clorine)){ $report->clorine = $request->clorine; }
        if(isset($request->temperature)){ $report->temperature = $request->temperature; }
        if(isset($request->turbidity)){ $report->turbidity = $request->turbidity; }
        if(isset($request->salt)){ $report->salt = $request->salt; }
        if(isset($request->latitude)){ $report->latitude = $request->latitude; }
        if(isset($request->longitude)){ $report->longitude = $request->longitude; }
        if(isset($request->altitude)){ $report->altitude = $request->altitude; }
        if(isset($request->accuracy)){ $report->accuracy = $request->accuracy; }
        if(isset($request->technician_id)){ $report->technician_id = $request->technician_id; }

        return $report;
    }



}
