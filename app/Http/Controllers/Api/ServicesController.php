<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\PRS\Transformers\ServiceTransformer;
use App\PRS\Helpers\ServiceHelpers;

use App\Service;

use Auth;
use Validator;
use App\Http\Requests\CreateServiceRequest;

class ServicesController extends ApiController
{

    private $serviceTransformer;
    private $serviceHelpers;


    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(ServiceTransformer $serviceTransformer, ServiceHelpers $serviceHelpers)
    {
        $this->serviceTransformer = $serviceTransformer;
        $this->serviceHelpers = $serviceHelpers;
        $this->middleware(['api', 'auth:api']);
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $user = Auth::guard('api')->user();

        $services = $user->services;
        return $this->respond([
            'data' => $this->serviceTransformer->transformCollection($services),
        ]);

    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {

        $validator = $this->validateServiceRequestCreate($request);

        if ($validator->fails()) {
            // return error responce
            return $this->setStatusCode(422)->RespondWithError('Paramenters failed validation.', $validator->errors()->toArray());
        }

        $user = Auth::guard('api')->user();

        // get the service days number 0-127
        $service_days = $this->serviceHelpers->service_days_to_num(
            $request->service_day_monday,
            $request->service_day_tuesday,
            $request->service_day_wednesday,
            $request->service_day_thursday,
            $request->service_day_friday,
            $request->service_day_saturday,
            $request->service_day_sunday
        );

        $service = Service::create([
            'name' => $request->name,
            'address_line' => $request->address_line,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => strtoupper($request->country),
            'type' => $request->type,
            'service_days' => $service_days,
            'amount' => $request->amount,
            'currency' => strtoupper($request->currency),
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'comments' => $request->comments,
            'user_id' => $user->id,
        ]);

        if($service){
            return $this->respondPersisted(
                'The service was successfuly created.',
                $this->serviceTransformer->transform($service)
            );
        }

        return $this->respondInternalError();

    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($seq_id)
    {
        $user = Auth::guard('api')->user();

        $service = $user->serviceBySeqId($seq_id);

        if($service){
            return $this->respond([
                'data' => $this->serviceTransformer->transform($service),
            ]);
        }

        return $this->respondNotFound('Service with that id, does not exist.');

    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $seq_id)
    {
        $validator = $this->validateServiceRequestUpdate($request);

        if ($validator->fails()) {
            // return error responce
            return $this->setStatusCode(422)
                ->RespondWithError(
                    'Paramenters failed validation.',
                    $validator->errors()->toArray()
                );
        }

        $user = Auth::guard('api')->user();

        $service = $this->updateService($request, $user->serviceBySeqId($seq_id));

        $photo = true;
        if($request->photo){
            $service->images()->delete();
            $photo = $service->addImageFromForm($request->file('photo'));
        }

        if($service->save() && $photo){
            return $this->respondPersisted(
                'The service was successfully updated.',
                $this->serviceTransformer->transform($service)
            );
        }
        return $this->respondInternalError('The service could not be updated.');

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

    protected function updateService(Request $request, Service $service)
    {
        $days = $this->serviceHelpers->num_to_service_days($service->service_days);

        // get the service days number 0-127
        $service_days = $this->serviceHelpers->service_days_to_num(
            (isset($request->service_day_monday)) ? $request->service_day_monday : $days['monday'],
            (isset($request->service_day_tuesday)) ? $request->service_day_tuesday : $days['tuesday'],
            (isset($request->service_day_wednesday)) ? $request->service_day_wednesday : $days['wednesday'],
            (isset($request->service_day_thursday)) ? $request->service_day_thursday : $days['thursday'],
            (isset($request->service_day_friday)) ? $request->service_day_friday : $days['friday'],
            (isset($request->service_day_saturday)) ? $request->service_day_saturday : $days['saturday'],
            (isset($request->service_day_sunday)) ? $request->service_day_sunday : $days['sunday']
        );
        $service->service_days = $service_days;

        if(isset($request->name)){ $service->name = $request->name; }
        if(isset($request->address_line)){ $service->address_line = $request->address_line; }
        if(isset($request->city)){ $service->city = $request->city; }
        if(isset($request->state)){ $service->state = $request->state; }
        if(isset($request->postal_code)){ $service->postal_code = $request->postal_code; }
        if(isset($request->country)){ $service->country = strtoupper($request->country); }
        if(isset($request->type)){ $service->type = $request->type; }
        if(isset($request->amount)){ $service->amount = $request->amount; }
        if(isset($request->currency)){ $service->currency = strtoupper($request->currency); }
        if(isset($request->start_time)){ $service->start_time = $request->start_time; }
        if(isset($request->end_time)){ $service->end_time = $request->end_time; }
        if(isset($request->status)){ $service->status = $request->status; }
        if(isset($request->comments)){ $service->comments = $request->comments; }

        return $service;
    }

    protected function validateServiceRequestCreate(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:20',
            'address_line' => 'required|string|max:50',
            'city' => 'required|string|max:30',
            'state' => 'required|string|max:30',
            'postal_code' => 'required|string|max:15',
            'country' => 'required|string|size:2',
            'type' => 'required|numeric|between:1,2',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'boolean',
            'amount' => 'required|numeric|max:10000000',
            'currency' => 'required|string|size:3',
            'comments' => 'string|max:750',
            'service_day_monday' => 'required|boolean',
            'service_day_tuesday' => 'required|boolean',
            'service_day_wednesday' => 'required|boolean',
            'service_day_thursday' => 'required|boolean',
            'service_day_friday' => 'required|boolean',
            'service_day_saturday' => 'required|boolean',
            'service_day_sunday' => 'required|boolean',
            'photo' => 'mimes:jpg,jpeg,png',
        ]);
    }

    protected function validateServiceRequestUpdate(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'string|max:20',
            'address_line' => 'string|max:50',
            'city' => 'string|max:30',
            'state' => 'string|max:30',
            'postal_code' => 'string|max:15',
            'country' => 'string|size:2',
            'type' => 'numeric|between:1,2',
            'start_time' => 'date_format:H:i',
            'end_time' => 'date_format:H:i|after:start_time',
            'status' => 'boolean',
            'amount' => 'numeric|max:10000000',
            'currency' => 'string|size:3',
            'comments' => 'string|max:750',
            'service_day_monday' => 'boolean',
            'service_day_tuesday' => 'boolean',
            'service_day_wednesday' => 'boolean',
            'service_day_thursday' => 'boolean',
            'service_day_friday' => 'boolean',
            'service_day_saturday' => 'boolean',
            'service_day_sunday' => 'boolean',
            'photo' => 'mimes:jpg,jpeg,png',
        ]);
    }

}
