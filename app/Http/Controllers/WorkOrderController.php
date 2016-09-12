<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JavaScript;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Requests\CreateWorkOrderRequest;
use App\PRS\Helpers\ServiceHelpers;
use App\PRS\Helpers\SupervisorHelpers;
use App\PRS\Helpers\TechnicianHelpers;
use App\WorkOrder;


class WorkOrderController extends PageController
{

    private $serviceHelpers;
    private $supervisorHelpers;
    private $technicianHelpers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ServiceHelpers $serviceHelpers,
                                    SupervisorHelpers $supervisorHelpers,
                                    TechnicianHelpers $technicianHelpers)
    {
        $this->middleware('auth');
        $this->serviceHelpers = $serviceHelpers;
        $this->supervisorHelpers = $supervisorHelpers;
        $this->technicianHelpers = $technicianHelpers;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // check permissions

        $default_table_url = url('datatables/workorders?finished=0');

        JavaScript::put([
            'workOrderTableUrl' => url('datatables/workorders?finished='),
            'click_url' => url('workorders').'/',
        ]);

        return view('workorders.index', compact('default_table_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // check permissions

        $admin = $this->loggedUserAdministrator();

        $services = $this->serviceHelpers->transformForDropdown($admin->services()->get());
        $supervisors = $this->supervisorHelpers->transformForDropdown($admin->supervisors()->get());

        return view('workorders.create', compact('services', 'supervisors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateWorkOrderRequest $request)
    {
        // check permissions

        $admin = $this->loggedUserAdministrator();

        $startDate = (new Carbon($request->start, $admin->timezone))->setTimezone('UTC');
        $service = $this->loggedUserAdministrator()->serviceBySeqId($request->service);
        $supervisor = $this->loggedUserAdministrator()->supervisorBySeqId($request->supervisor);

        $workOrder = WorkOrder::create(array_merge(
                            array_map('htmlentities', $request->all()),
                            [
                                'start' => $startDate,
                                'service_id' => $service->id,
                                'supervisor_id' => $supervisor->id,
                            ])
                    );
        $photo = true;
        if($request->photo){
            $photo = $workOrder->addImageFromForm($request->file('photo'));
        }
        if($workOrder && $photo){
            flash()->success('Created', 'New Work Order was successfully created.');
            return redirect('workorders');
        }
        flash()->success('Not created', 'New Work Order was not created, please try again later.');
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
        $admin = $this->loggedUserAdministrator();

        $workOrder = $admin->workOrderBySeqId($seq_id);

        $technicians  = $this->technicianHelpers->transformForDropdown($admin->technicians()->get());

        $default_table_url = url('datatables/works/'.$seq_id);

        JavaScript::put([
            'worksUrl' => url('/works').'/',
            'worksAddPhotoUrl' => url('/works/photos').'/',
            'workOrderId' => $workOrder->id,
        ]);

        return view('workorders.show', compact('workOrder', 'default_table_url', 'technicians'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
