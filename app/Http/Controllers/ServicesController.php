<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use JavaScript;

use App\Service;
use App\PRS\Helpers\ServiceHelpers;

use App\Http\Requests;
use App\Http\Requests\CreateServiceRequest;
use App\Http\Controllers\PageController;
use App\Notifications\NewServiceNotification;

class ServicesController extends PageController
{

    protected $serviceHelpers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(serviceHelpers $serviceHelpers)
    {
        $this->serviceHelpers = $serviceHelpers;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->checkPermissions('index');

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
        $this->checkPermissions('create');

        JavaScript::put([
            'latitude' => $request->old('latitude'),
            'longitude' => $request->old('longitude'),
            'addressLine' => $request->old('address_line'),
            'city' => $request->old('city'),
            'state' => $request->old('state'),
            'postalCode' => $request->old('postal_code'),
            'country' => $request->old('country'),
        ]);

        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateServiceRequest $request)
    {
        $this->checkPermissions('create');

        $admin  = $this->loggedUserAdministrator();

        $serviceId = Service::create(
                            array_merge(
                                array_map('htmlentities', $request->all()),
                                [
                                    'admin_id' => $admin->id,
                                ]
                            )
                    )->id;
        $service = Service::findOrFail($serviceId);

        $photo = true;
        if($request->photo){
            $photo = $service->addImageFromForm($request->file('photo'));
        }

        if($photo){
            $admin->user()->notify(new NewServiceNotification($service, $request->user()));
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
    public function show($seq_id)
    {
        $this->checkPermissions('show');

        $service = $this->loggedUserAdministrator()->serviceBySeqId($seq_id);

        JavaScript::put([
            'showLatitude' => $service->latitude,
            'showLongitude' => $service->longitude,
            'hasContract' => $service->hasServiceContract(),
            'equipmentUrl' => url('/equipment').'/',
            'equipmentAddPhotoUrl' => url('/equipment/photos').'/',
            'serviceId' => $service->id,
            'click_url' => url('clients').'/',
        ]);

        $clients = $service->clients()->get();
        $default_table_url = url('/datatables/equipment').'/'.$service->seq_id;

        return view('services.show', compact('service', 'clients', 'default_table_url'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($seq_id)
    {
        $this->checkPermissions('edit');

        $service = $this->loggedUserAdministrator()->serviceBySeqId($seq_id);

        JavaScript::put([
            'latitude' => $service->latitude,
            'longitude' => $service->longitude,
            'addressLine' => $service->address_line,
            'city' => $service->city,
            'state' => $service->state,
            'postalCode' => $service->postal_code,
            'country' => $service->country,
        ]);

        $default_table_url = url('/datatables/equipment').'/'.$service->seq_id;

        return view('services.edit',compact('service', 'default_table_url'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateServiceRequest $request, $seq_id)
    {
        $this->checkPermissions('edit');

        $service = $this->loggedUserAdministrator()->serviceBySeqId($seq_id);

        $service->fill(array_map('htmlentities', $request->except('admin_id')));

        $photo = true;
        if($request->photo){
            $service->images()->delete();
            $photo = $service->addImageFromForm($request->file('photo'));
        }

        if($service->save() && $photo){
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
        $this->checkPermissions('destroy');
        $service = $this->loggedUserAdministrator()->serviceBySeqId($seq_id);

        if($service->delete()){
            flash()->success('Deleted', 'The service successfully deleted.');
            return response()->json([
                'message' => 'The service was deleted successfully.'
            ]);
        }
        return response()->json([
                'error' => 'The service was not deleted.'
            ], 500);
    }

    protected function checkPermissions($typePermission)
    {
        $user = Auth::user();
        if($user->cannot($typePermission, Service::class))
        {
            abort(403, 'If you really need to see this. Ask system administrator for access.');
        }
    }

}
