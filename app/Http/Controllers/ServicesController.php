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
    public function create()
    {
        $this->checkPermissions('create');

        $countrysArray;

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

        // get the service days number 0-127
        $service_days = $this->serviceHelpers->service_days_to_num(
            $request->service_days_monday,
            $request->service_days_tuesday,
            $request->service_days_wednesday,
            $request->service_days_thursday,
            $request->service_days_friday,
            $request->service_days_saturday,
            $request->service_days_sunday
        );


        $service = Service::create(
                            array_merge(
                                array_map('htmlentities', $request->except([
                                    'type',
                                    'service_days',
                                    'status',
                                    'admin_id',
                                ])),
                                [
                                    'type' => ($request->type)? 1:2, // 1=chlorine, 2=salt
                                    'service_days' => $service_days,
                                    'status' => ($request->status)? 1:0, // 0=inactive, 1=active
                                    'admin_id' => $admin->id,
                                ]
                            )
                    );

        $photo = true;
        if($request->photo){
            $photo = $service->addImageFromForm($request->file('photo'));
        }
        if($service && $photo){
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

        JavaScript::put([
            'click_url' => url('clients').'/',
        ]);

        $service = $this->loggedUserAdministrator()->serviceBySeqId($seq_id);

        $clients = $service->clients()->get();

        return view('services.show', compact('service', 'clients'));
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

        return view('services.edit',compact('service'));
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

        // get the service days number 0-127
        $service_days = $this->serviceHelpers->service_days_to_num(
            $request->service_days_monday,
            $request->service_days_tuesday,
            $request->service_days_wednesday,
            $request->service_days_thursday,
            $request->service_days_friday,
            $request->service_days_saturday,
            $request->service_days_sunday
        );

        $service->fill(
                array_merge(
                    array_map('htmlentities', $request->except([
                        'type',
                        'service_days',
                        'status',
                        'admin_id',
                    ])),
                    [
                        'type' => ($request->type)? 1:2, // 1=chlorine, 2=salt
                        'service_days' => $service_days,
                        'status' => ($request->status)? 1:0, // 0=inactive, 1=active
                    ]
                ));

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
            flash()->success('Deleted', 'The service was successfuly deleted');
            return redirect('services');
        }
        flash()->error('Not Deleted', 'We could not delete the service, please try again later.');
        return redirect()->back();
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
