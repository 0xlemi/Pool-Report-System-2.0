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
use App\PRS\Transformers\ImageTransformer;
use App\Service;
use App\Notifications\ReportCreatedNotification;
class ReportsController extends PageController
{
    protected $reportHelpers;
    protected $serviceHelpers;
    protected $technicianHelpers;
    protected $imageTransformer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ReportHelpers $reportHelpers,
                                ServiceHelpers $serviceHelpers,
                                TechnicianHelpers $technicianHelpers,
                                ImageTransformer $imageTransformer)
    {
        $this->middleware('auth');
        $this->reportHelpers = $reportHelpers;
        $this->serviceHelpers = $serviceHelpers;
        $this->technicianHelpers = $technicianHelpers;
        $this->imageTransformer = $imageTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('list', Report::class);

        $admin = $this->loggedUserAdministrator();
        $today = Carbon::today($admin->timezone);

        $defaultTableUrl = url('datatables/reports').'?date='.$today->toDateString();

        JavaScript::put([
            'date_url' => url('reports/date').'/',
            'datatable_url' => url('datatables/reports').'?date=',
            'click_url' => url('reports').'/',

            'missingServices_url' => url('datatables/missingServices').'?date=',
            'missingServicesInfo_url' => url('datatables/missingServicesInfo'),

            'enabledDates' => $admin->datesWithReport(),
            'todayDate' => $today->toDateString(),
        ]);

        return view('reports.index',compact('defaultTableUrl'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Report::class);

        $admin = $this->loggedUserAdministrator();

        $services = $this->serviceHelpers->transformForDropdown($admin->servicesInOrder()->get());
        $technicians = $this->technicianHelpers->transformForDropdown($admin->techniciansInOrder()->get());
        $tags = $admin->tags();;

        return view('reports.create', compact('services', 'technicians', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateReportRequest $request)
    {
        $this->authorize('create', Report::class);

        $admin = $this->loggedUserAdministrator();

        $completed_at = (new Carbon($request->completed_at, $admin->timezone));
        $service = $this->loggedUserAdministrator()->serviceBySeqId($request->service);
        $technician = $this->loggedUserAdministrator()->technicianBySeqId($request->technician);

        $on_time = 'onTime';
        if($service->hasServiceContract()){
            $on_time = $this->reportHelpers->checkOnTimeValue(
                // ****** check the timezone for check on time
                    $completed_at,
                    // bug if a service dosn't have contract
                    $service->serviceContract->start_time,
                    $service->serviceContract->end_time,
                    $admin->timezone
                );
        }

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
                foreach ($service->clients as $client) {
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
        $report = $this->loggedUserAdministrator()->reportsBySeqId($seq_id);

        $this->authorize('view', $report);
        $images = $this->imageTransformer->transformCollection($report->images);

        return view('reports.show', compact('report', 'images'));
    }

    // check this
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
        $admin = $this->loggedUserAdministrator();
        $report = $this->loggedUserAdministrator()->reportsBySeqId($seq_id);

        $this->authorize('update', $report);

        $services = $this->serviceHelpers->transformForDropdown($admin->servicesInOrder()->get());
        $technicians = $this->technicianHelpers->transformForDropdown($admin->techniciansInOrder()->get());
        $tags = $admin->tags();

        $date = (new Carbon($report->completed, 'UTC'))
                    ->setTimezone($admin->timezone)
                    ->format('m/d/Y h:i:s A');
        JavaScript::put([
            'defaultDate' => $date,
        ]);
        return view('reports.edit', compact('report', 'services', 'technicians', 'tags'));
    }

    public function getPhoto(Request $request, $seq_id)
    {
        $report = $this->loggedUserAdministrator()->reportsBySeqId($seq_id);

        $this->authorize('view', $report);

        $images = $this->imageTransformer->transformCollection($report->images);

        return response()->json($images);
    }

    public function addPhoto(Request $request, $seq_id)
    {
        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png'
        ]);

        $report = $this->loggedUserAdministrator()->reportsBySeqId($seq_id);

        $this->authorize('addPhoto', $report);

        $file = $request->file('photo');
        $report->addImageFromForm($file);

    }

    public function removePhoto($seq_id, $order)
    {
        $report = $this->loggedUserAdministrator()->reportsBySeqId($seq_id);

        $this->authorize('removePhoto', $report);

        $image = $report->image($order, false);
        if($image->delete()){
                return response()->json([
                'message' => 'The photo was deleted from the report'
            ]);
        }
        return response()->json([
                'error' => 'The photo could not deleted from the report'
            ], 500);
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

        $this->authorize('update', $report);

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
        $report = $this->loggedUserAdministrator()->reportsBySeqId($seq_id);

        $this->authorize('delete', $report);

        if($report->delete()){
            flash()->success('Deleted', 'The report successfully deleted.');
            return response()->json([
                'message' => 'The report was deleted successfully.'
            ]);
        }
        return response()->json([
                'error' => 'The report was not deleted, please try again later.'
            ], 500);
    }

}
