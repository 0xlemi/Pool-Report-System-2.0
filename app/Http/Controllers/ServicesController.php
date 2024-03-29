<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use JavaScript;

use App\Service;
use App\PRS\Helpers\ServiceHelpers;
use App\PRS\Helpers\GlobalProductHelpers;
use App\PRS\Helpers\GlobalMeasurementHelpers;
use App\PRS\Transformers\ImageTransformer;

use App\Http\Requests;
use App\Http\Requests\CreateServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Http\Controllers\PageController;
use App\Notifications\NewServiceNotification;

class ServicesController extends PageController
{

    protected $serviceHelpers;
    protected $imageTransformer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(serviceHelpers $serviceHelpers, ImageTransformer $imageTransformer)
    {
        $this->serviceHelpers = $serviceHelpers;
        $this->imageTransformer = $imageTransformer;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('list', Service::class);

        $default_table_url = url('datatables/services?status=1');

        JavaScript::put([
            'serviceTableUrl' => url('datatables/services?status='),
            'click_url' => url('services').'/',
        ]);

        return view('services.index', compact('default_table_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Service::class);

        $company = $this->loggedCompany();
        $startLocation = [
            'latitude' => $company->latitude,
            'longitude' => $company->longitude,
        ];

        JavaScript::put([
            'latitude' => $request->old('latitude'),
            'longitude' => $request->old('longitude'),
            'addressLine' => $request->old('address_line'),
            'city' => $request->old('city'),
            'state' => $request->old('state'),
            'postalCode' => $request->old('postal_code'),
            'country' => $request->old('country'),
        ]);

        return view('services.create', compact('startLocation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateServiceRequest $request)
    {
        $this->authorize('create', Service::class);

        $service = $this->loggedCompany()->services()->create(
                        array_map('htmlentities', $request->all())
                    );

        $photo = true;
        if($request->photo){
            $photo = $service->addImageFromForm($request->file('photo'));
        }

        if($photo){
            flash()->success('Created', 'New service successfully created.');
            return redirect('services');
        }
        flash()->success('Not created', 'New service was not created, please try again later.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($seq_id, GlobalMeasurementHelpers $measurementHelper, GlobalProductHelpers $productHelper)
    {
        $company = $this->loggedCompany();
        $service = $company->services()->bySeqId($seq_id);

        $this->authorize('view', $service);

        $clients = $service->userRoleCompanies()->get();

        // Get Unused Global Measurements
        $usedMeasurementsIds = $service->measurements()
                ->join('global_measurements', 'global_measurements.id', '=', 'measurements.global_measurement_id')
                ->pluck('global_measurements.id')->toArray();
        $globalMeasurements = $measurementHelper->transformForDropdown($company->globalMeasurements()->whereNotIn('id', $usedMeasurementsIds )->get());

        // Get Unused Global Products
        $usedProductsIds = $service->products()
                ->join('global_products', 'global_products.id', '=', 'products.global_product_id')
                ->pluck('global_products.id')->toArray();
        $globalProducts = $productHelper->transformForDropdown($company->globalProducts()->whereNotIn('id', $usedProductsIds )->get());

        $image = null;
        if($service->images->count() > 0){
            $image = $this->imageTransformer->transform($service->images->first());
        }
        return view('services.show', compact('service', 'clients', 'image', 'globalMeasurements', 'globalProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($seq_id)
    {
        $service = $this->loggedCompany()->services()->bySeqId($seq_id);

        $this->authorize('update', $service);
        $company = $this->loggedCompany();
        $startLocation = [
            'latitude' => $company->latitude,
            'longitude' => $company->longitude,
        ];

        return view('services.edit',compact('service', 'startLocation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, $seq_id)
    {
        $service = $this->loggedCompany()->services()->bySeqId($seq_id);

        $this->authorize('update', $service);

        $service->fill(array_map('htmlentities', $request->all()));

        $photo = true;
        if($request->photo){
            $service->images()->delete();
            $service->addImageFromForm($request->file('photo'));
        }

        if($service->save()){
            flash()->success('Updated', 'New service successfully updated.');
            return redirect('services/'.$seq_id);
        }
        flash()->error('Not Updated', 'Service was not updated, please try again later.');
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($seq_id)
    {
        $service = $this->loggedCompany()->services()->bySeqId($seq_id);

        $this->authorize('delete', $service);

        if($service->delete()){
            flash()->success('Deleted', 'The service successfully deleted.');
            return response()->json([
                'message' => 'The service was deleted successfully.'
            ]);
        }
        return response()->json([
                'error' => 'The service was not deleted, please try again later.'
            ], 500);
    }

}
