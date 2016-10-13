<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;

use App\PRS\Transformers\ServiceTransformer;
use App\PRS\Transformers\PreviewTransformers\ServicePreviewTransformer;
use App\PRS\Helpers\ServiceHelpers;

use App\Service;

use Auth;
use DB;
use Validator;
use Illuminate\View\View;
use App\Http\Requests\CreateServiceRequest;
use App\Administrator;

class ServicesController extends ApiController
{

    private $serviceTransformer;
    private $servicePreviewTransformer;
    private $serviceHelpers;


    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(ServiceTransformer $serviceTransformer,
                                ServicePreviewTransformer $servicePreviewTransformer,
                                ServiceHelpers $serviceHelpers)
    {
        $this->serviceTransformer = $serviceTransformer;
        $this->servicePreviewTransformer = $servicePreviewTransformer;
        $this->serviceHelpers = $serviceHelpers;
    }

    /**
    * Display a listing of the resource.
    * tested
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        if($this->getUser()->cannot('index', Service::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request, [
            'preview' => 'boolean',
            'status' => 'boolean',
            // dont validate limit if preview is true
            'limit' => 'integer|between:1,25',
        ]);

        $admin = $this->loggedUserAdministrator();

        // make a preview transformation
        if($request->preview){
            return $this->indexPreview($request, $admin);
        }

        $limit = ($request->limit)?: 5;
        if($request->has('status')){
            $services = $admin->services()
                            ->where('status', $request->status)
                            ->paginate($limit);
        }else{
            $services = $admin->services()
                            ->paginate($limit);
        }

        return $this->respondWithPagination(
            $services,
            $this->serviceTransformer->transformCollection($services)
        );

    }

    protected function indexPreview(Request $request, Administrator $admin)
    {
        if($request->has('status')){
            $services = $admin->services()
                                ->where('status', $request->status)
                                ->get();
        }else{
            $services = $admin->services()->get();
        }

        return $this->respond([
                'data' => $this->servicePreviewTransformer->transformCollection($services)
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
        // check that the user has permissions
        if($this->getUser()->cannot('create', Service::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        // validation
        $this->validateServiceCreate($request);

        $admin = $this->loggedUserAdministrator();

        // get the service days number 0-127 from request
        $service_days = $this->serviceHelpers->service_days_to_num(
            $request->service_day_monday,
            $request->service_day_tuesday,
            $request->service_day_wednesday,
            $request->service_day_thursday,
            $request->service_day_friday,
            $request->service_day_saturday,
            $request->service_day_sunday
        );

        // Create service
        $transaction = DB::transaction(function () use($request, $admin, $service_days) {

            $service = Service::create(
                array_merge(
                    array_map('htmlentities', $request->all()),
                    [
                        'service_days' => $service_days,
                        'currency' => strtoupper(htmlentities($request->currency)),
                        'country' => strtoupper(htmlentities($request->country)),
                        'admin_id' => $admin->id,
                    ]
                )
            );

            $service->save();

            // Add Photo
            if($request->photo){
                $photo = $service->addImageFromForm($request->file('photo'));
            }

        });

        return $this->respondPersisted(
            'The service was successfuly created.',
            $this->serviceTransformer->transform($admin->services(true)->first())
        );

    }

    /**
    * Display the specified resource.
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($seq_id)
    {
        if($this->getUser()->cannot('show', Service::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        try {
            $service = $this->loggedUserAdministrator()->serviceBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Service with that id, does not exist.');
        }

        if($service){
            return $this->respond([
                'data' => $this->serviceTransformer->transform($service),
            ]);
        }

        return $this->respondNotFound('Service with that id, does not exist.');

    }

    /**
    * Update the specified resource in storage.
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $seq_id)
    {
        // check that user has permission
        if($this->getUser()->cannot('edit', Service::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        // Validate
            $this->validateServiceUpdate($request);
            // getting and validating service
            try{
                $service = $this->loggedUserAdministrator()->serviceBySeqId($seq_id);
            }catch(ModelNotFoundException $e){
                return $this->respondNotFound('Service with that id, does not exist.');
            }

        $service_days = $this->getServiceDaysNumberFromRequest($service->service_days, $request);
        // ***** Persist *****
        $transaction = DB::transaction(function () use($request, $service, $service_days) {

            $service->fill(
                array_merge(
                    array_map('htmlentities', $request->except('admin_id')),
                    [
                        'currency' => strtoupper(htmlentities($request->currency)),
                        'country' => strtoupper(htmlentities($request->country)),
                        'service_days' => $service_days,
                    ]
                ));

            $service->save();

            if($request->photo){
                $service->images()->delete();
                $photo = $service->addImageFromForm($request->file('photo'));
            }

        });

        return $this->respondPersisted(
            'The service was successfully updated.',
            $this->serviceTransformer->transform($this->loggedUserAdministrator()->serviceBySeqId($seq_id))
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
        if($this->getUser()->cannot('destroy', Service::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        try{
            $service = $this->loggedUserAdministrator()->serviceBySeqId($seq_id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Service with that id, does not exist.');
        }

        if($service->delete()){
            return $this->respondWithSuccess('Service was successfully deleted');
        }

        return $this->respondNotFound('Service with that id, does not exist.');

    }

    /**
     * Get the service_days number from the request arguments not changing the dates that where not sent as arguments
     * @param  int      $originalNum     service_days num that the unchanged service has
     * @param  Request  $request
     * @return  int                      final service_days num for persisting
     */
    protected function getServiceDaysNumberFromRequest($originalNum, $request)
    {
        // get days from the number
        $days = $this->serviceHelpers->num_to_service_days($originalNum);
        // get the get number from the service days ignoring the unset ones
        return $this->serviceHelpers->service_days_to_num(
            (isset($request->service_day_monday)) ? $request->service_day_monday : $days['monday'],
            (isset($request->service_day_tuesday)) ? $request->service_day_tuesday : $days['tuesday'],
            (isset($request->service_day_wednesday)) ? $request->service_day_wednesday : $days['wednesday'],
            (isset($request->service_day_thursday)) ? $request->service_day_thursday : $days['thursday'],
            (isset($request->service_day_friday)) ? $request->service_day_friday : $days['friday'],
            (isset($request->service_day_saturday)) ? $request->service_day_saturday : $days['saturday'],
            (isset($request->service_day_sunday)) ? $request->service_day_sunday : $days['sunday']
        );
    }

    protected function validateServiceCreate(Request $request)
    {
        return $this->validate($request, [
            'name' => 'required|string|max:20',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
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

    protected function validateServiceUpdate(Request $request)
    {
        return $this->validate($request, [
            'name' => 'string|max:20',
            'latitude' => 'numeric|between:-90,90',
            'longitude' => 'numeric|between:-180,180',
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
