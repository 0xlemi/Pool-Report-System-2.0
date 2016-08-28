<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CreateReportRequest;
use App\Report;
use App\Photo;
use App\Image;
use Carbon\Carbon;
use JavaScript;
use Response;
use Auth;
use App\PRS\Helpers\ReportHelpers;
use App\PRS\Helpers\ServiceHelpers;
use App\PRS\Helpers\TechnicianHelpers;
use App\Service;
use App\Notifications\ReportCreatedNotification;
class ReportsController extends PageController
{
    protected $reportHelpers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ReportHelpers $reportHelpers,
                                ServiceHelpers $serviceHelpers,
                                TechnicianHelpers $technicianHelpers)
    {
        $this->middleware('auth');
        $this->reportHelpers = $reportHelpers;
        $this->serviceHelpers = $serviceHelpers;
        $this->technicianHelpers = $technicianHelpers;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->checkPermissions('index');

        $admin = $this->loggedUserAdministrator();
        $today = Carbon::today($admin->timezone);
        $today_utc = Carbon::today('UTC');

        $default_table_url = url('datatables/reports').'?date='.$today->toDateString();
        $default_missing_table_url = url('datatables/missingServices').'?date='.$today->toDateString();

        $numServicesMissing = $admin->numberServicesMissing($today_utc);
        $numServicesToDo = $admin->numberServicesDoIn($today_utc);
        $numServicesDone = $numServicesToDo - $numServicesMissing;

        JavaScript::put([
            'date_url' => url('reports/date').'/',
            'datatable_url' => url('datatables/reports').'?date=',
            'missingServices_url' => url('datatables/missingServices').'?date=',
            'missingServicesInfo_url' => url('datatables/missingServicesInfo'),

            'click_url' => url('reports').'/',
            'click_missingServices_url' => url('services').'/',

            'numServicesMissing' => $numServicesMissing,
            'numServicesToDo' => $numServicesToDo,
            'numServicesDone' => $numServicesDone,

            'enabledDates' => $admin->datesWithReport(),
            'todayDate' => $today->toDateString(),
        ]);

        return view('reports.index',compact(
                            'default_table_url',
                            'default_missing_table_url'
                        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->checkPermissions('create');

        $admin = $this->loggedUserAdministrator();

        $services = $this->serviceHelpers->transformForDropdown($admin->services()->get());
        $technicians = $this->serviceHelpers->transformForDropdown($admin->technicians()->get());

        JavaScript::put([
            'dropdownKey' => $request->old('service'),
            'dropdownKey2' => $request->old('technician'),
        ]);

        return view('reports.create', compact('services', 'technicians'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateReportRequest $request)
    {
        $this->checkPermissions('create');

        $admin = $this->loggedUserAdministrator();

        $completed_at = (new Carbon($request->completed_at, $admin->timezone));
        $service = $this->loggedUserAdministrator()->serviceBySeqId($request->service);
        $technician = $this->loggedUserAdministrator()->technicianBySeqId($request->technician);

        $on_time = $this->reportHelpers->checkOnTime(
// ****** check the timezoen for check on time
                $completed_at,
                $service->start_time,
                $service->end_time
            );

        $report = Report::create([
            'service_id' => $service->id,
            'technician_id' => $technician->id,
            'completed' => $completed_at->setTimezone('UTC'),
            'on_time' => $on_time,
            'ph' => $request->ph,
            'chlorine' => $request->chlorine,
            'temperature' => $request->temperature,
            'turbidity' => $request->turbidity,
            'salt' => $request->salt,
        ]);

        // add the 3 main photos
        $image1 = $report->addImageFromForm($request->file('photo1'));
        $image2 = $report->addImageFromForm($request->file('photo2'));
        $image3 = $report->addImageFromForm($request->file('photo3'));

        if($report && $image1 && $image2 && $image3){
            // notify report was made
                // notify the clients
                foreach ($service->clients()->get() as $client) {
                    $client->user()->notify(new ReportCreatedNotification($report));
                }
                // notify the supervisor
                $report->supervisor()->user()->notify(new ReportCreatedNotification($report));

            flash()->success('Created', 'Report was created successfuly.');
            return redirect('reports');
        }
        flash()->error('Not created', 'Report was not created, please try again later.');
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

        // set the generate email url
        JavaScript::put([
            'emailPreview' => url('reports/emailPreview'),
            'emailPreviewNoImage' => url('img/no_image.png'),
        ]);

        $report = $this->loggedUserAdministrator()->reportsBySeqId($seq_id);


        return view('reports.show', compact('report'));
    }

    public function emailPreview(Request $request)
    {
        $report = $this->loggedUserAdministrator()->reportsBySeqId($request->id);

        $url = $report->getEmailImage();

        if($report){
            return Response::json([
                'data' => [
                    'url' => $url,
                ]
            ], 200);
        }

        return $this->respondInternalError();
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

        $admin = $this->loggedUserAdministrator();

        $report = $this->loggedUserAdministrator()->reportsBySeqId($seq_id);
        $services = $this->serviceHelpers->transformForDropdown($admin->services()->get());
        $technicians = $this->serviceHelpers->transformForDropdown($admin->technicians()->get());

        $date = (new Carbon($report->completed, 'UTC'))
                    ->setTimezone($admin->timezone)
                    ->format('m/d/Y h:i:s A');
        JavaScript::put([
            'default_date' => $date,
            'dropdownKey' => $report->service()->seq_id,
            'dropdownKey2' => $report->technician()->seq_id,
        ]);
        return view('reports.edit', compact('report', 'services', 'technicians'));
    }


    public function addPhoto(Request $request, $seq_id)
    {
        $this->checkPermissions('addPhoto');

        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png'
        ]);

        $report = $this->loggedUserAdministrator()->reportsBySeqId($seq_id);

        $file = $request->file('photo');
        $report->addImageFromForm($file);

    }

    public function removePhoto($seq_id, $order)
    {
        $this->checkPermissions('removePhoto');

        $report = $this->loggedUserAdministrator()->reportsBySeqId($seq_id);

        $image = $report->image($order);
        if($image->delete()){
            return redirect()->back();
        }
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
        $this->checkPermissions('edit');

        $this->validate($request, [
            'service' => 'required|integer|min:1',
            'technician' => 'required|integer|min:1',
            'completed_at' => 'required|date',
            'ph' => 'required|integer|min:1|max:5',
            'chlorine' => 'required|integer|min:1|max:5',
            'temperature' => 'required|integer|min:1|max:5',
            'turbidity' => 'required|integer|min:1|max:4',
            'salt' => 'required|integer|min:1|max:5',
        ]);

        $admin = $this->loggedUserAdministrator();
        $report = $admin->reportsBySeqId($seq_id);
        $service = $admin->serviceBySeqId($request->service);
        $technician = $admin->technicianBySeqId($request->technician);

        $completed_at = (new Carbon($request->completed_at, $admin->timezone))
                            ->setTimezone('UTC');

        $report->service_id     = $service->id;
        $report->technician_id  = $technician->id;
        $report->completed      = $completed_at;
        $report->ph             = $request->ph;
        $report->chlorine        = $request->chlorine;
        $report->temperature    = $request->temperature;
        $report->turbidity      = $request->turbidity;
        $report->salt           = $request->salt;

        if($report->save()){
            flash()->success('Updated', 'The report was successfuly updated');
            return redirect('reports/'.$seq_id);
        }

        flash()->error('Nope', 'We could not uptade the report, please try again later.');
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

        $report = $this->loggedUserAdministrator()->reportsBySeqId($seq_id);

        if($report->delete()){
            flash()->success('Deleted', 'The report was successfuly deleted');
            return redirect('reports');
        }
        flash()->error('Nope', 'We could not delete the report, please try again later.');
        return redirect()->back();
    }

    protected function checkPermissions($typePermission)
    {
        $user = Auth::user();
        if($user->cannot($typePermission, Report::class))
        {
            abort(403, 'If you really need to see this. Ask system administrator for access.');
        }
    }
}
