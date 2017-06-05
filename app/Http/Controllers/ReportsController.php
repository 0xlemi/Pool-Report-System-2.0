<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CreateReportRequest;
use App\Http\Requests\UpdateReportRequest;
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
use App\PRS\Helpers\UserRoleCompanyHelpers;
use App\PRS\Transformers\ImageTransformer;
use App\PRS\Classes\Logged;
use App\UserRoleCompany;
use App\Service;
class ReportsController extends PageController
{
    protected $reportHelpers;
    protected $serviceHelpers;
    protected $userRoleCompanyHelpers;
    protected $imageTransformer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ReportHelpers $reportHelpers,
                                ServiceHelpers $serviceHelpers,
                                UserRoleCompanyHelpers $userRoleCompanyHelpers,
                                ImageTransformer $imageTransformer)
    {
        $this->middleware('auth');
        $this->reportHelpers = $reportHelpers;
        $this->serviceHelpers = $serviceHelpers;
        $this->userRoleCompanyHelpers = $userRoleCompanyHelpers;
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

        $company = Logged::company();
        $today = Carbon::today($company->timezone);

        $defaultTableUrl = url('datatables/reports').'?date='.$today->toDateString();

        JavaScript::put([
            'datatable_url' => url('datatables/reports').'?date=',
            'click_url' => url('reports').'/',

            'enabledDates' => $company->datesWithReport(),
            'todayDate' => $today->toDateString(),
        ]);

        return view('reports.index',compact('defaultTableUrl'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Report::class);

        $company = Logged::company();

        $services = $this->serviceHelpers->transformForDropdown($company->services()->seqIdOrdered()->get());
        $people = $this->userRoleCompanyHelpers->transformForDropdown(
                            $company->userRoleCompanies()
                                        ->ofRole('admin', 'sup', 'tech')
                                        ->seqIdOrdered()->get()
                        );


        return view('reports.create', compact('services', 'people'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createAddReadings(Request $request)
    {
        $this->authorize('create', Report::class);

        $company = Logged::company();

        $this->validate($request, [
            'service' => 'required|integer|existsBasedOnCompany:services,'.$company->id,
            'person' => 'integer|existsBasedOnCompany:user_role_company,'.$company->id,
            'completed_at' => 'date',
        ]);

        $service = Logged::company()->services()->bySeqId($request->service);
        $info = (object)[
            'service' => $request->service,
            'person' => $request->person,
            'completed_at' => $request->completed_at
        ];

        $measurements = $service->measurements
            ->transform(function ($measurement) {
                return (object)[
                    'id' => $measurement->id,
                    'name' => $measurement->globalMeasurement->name,
                    'labels' => $measurement->globalMeasurement
                                        ->labels()
                                        ->select('name', 'color', 'value')
                                        ->get(),
                ];
            });


        return view('reports.createAddReadings', compact('info', 'measurements'));
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

        $company = Logged::company();

        $urc = Logged::user()->selectedUser;
        // Only Admins can set the person or the completed_at time
        if($urc->isRole('admin')){
            if($request->has('person')){
                $person = $company->userRoleCompanies()->bySeqId($request->person);
            }else{
                flash()->error('Person is required', 'Person is required to create a report, please try again.');
                return redirect()->back();
            }
            if($request->has('completed_at')){
                $completed_at = (new Carbon($request->completed_at, $company->timezone));
            }else{
                flash()->error('Compleated_at is required', 'compleated_at field is required to create a report, please try again.');
                return redirect()->back();
            }
        }else{
            $person = $urc;
            $completed_at = Carbon::now($company->timezone);
        }


        $service = $company->services()->bySeqId($request->service);
        $on_time = 'onTime';
        if($service->hasServiceContract()){
            $on_time = $this->reportHelpers->checkOnTimeValue(
                // ****** check the timezone for check on time
                    $completed_at,
                    $service->serviceContract->start_time,
                    $service->serviceContract->end_time,
                    $company->timezone
                );
        }

        $report = $service->reports()->create([
            'user_role_company_id' => $person->id,
            'completed' => $completed_at->setTimezone('UTC'),
            'on_time' => $on_time,
        ]);
        foreach ($request->readings as $measurement_id => $value) {
            $reading = $report->readings()->create([
                'measurement_id' => $measurement_id,
                'value' => $value,
            ]);
        }

        // add the 3 main photos
        $image1 = $report->addImageFromForm($request->file('photo1'));
        $image2 = $report->addImageFromForm($request->file('photo2'));
        $image3 = $report->addImageFromForm($request->file('photo3'));

        if($report && $image1 && $image2 && $image3){
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
        $report = Logged::company()->reports()->bySeqId($seq_id);

        $this->authorize('view', $report);
        $images = $this->imageTransformer->transformCollection($report->images);
        $readings = $report->readings->transform(function ($reading){
            $globalMeasurement = $reading->globalMeasurement;
            return (object)[
                'measurement_name' => $globalMeasurement->name,
                'color' => $globalMeasurement->labels()->whereValue($reading->value)->color,
                'name' => $globalMeasurement->labels()->whereValue($reading->value)->name,
                'value' => $reading->value,
            ];
        })->flatten();

        return view('reports.show', compact('report', 'images', 'readings'));
    }

    //****************************************
    //         This Needs Checking
    //****************************************
    // public function emailPreview(Request $request)
    // {
    //     $report = Logged::company()->reports()->bySeqId($request->id);
    //
    //     $url = $report->getEmailImage();
    //
    //     if($report){
    //         return Response::json([
    //             'data' => [
    //                 'url' => $url,
    //             ]
    //         ], 200);
    //     }
    //
    //     return $this->respondInternalError()Technician;
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($seq_id)
    {
        $company = Logged::company();
        $report = $company->reports()->bySeqId($seq_id);

        $this->authorize('update', $report);

        $people = $this->userRoleCompanyHelpers->transformForDropdown(
                                        $company->userRoleCompanies()
                                            ->ofRole('admin', 'sup', 'tech')
                                            ->seqIdOrdered()->get()
                                    );
        $measurements = $report->service->measurements()->get()
                            ->transform(function ($measurement) {
                                return (object)[
                                    'id' => $measurement->id,
                                    'name' => $measurement->globalMeasurement->name,
                                    'labels' => $measurement->globalMeasurement
                                                        ->labels()
                                                        ->select('name', 'color', 'value')
                                                        ->get(),
                                ];
                            });
        $readings = $report->readings()->get()->pluck('value', 'measurement_id')->toArray();

        $date = (new Carbon($report->completed, 'UTC'))
                    ->setTimezone($company->timezone)
                    ->format('m/d/Y h:i:s A');
        JavaScript::put([
            'defaultDate' => $date,
        ]);
        return view('reports.edit', compact('report', 'people', 'measurements', 'readings'));
    }

    public function getPhoto(Request $request, $seq_id)
    {
        $report = Logged::company()->reports()->bySeqId($seq_id);

        $this->authorize('view', $report);

        $images = $this->imageTransformer->transformCollection($report->images);

        return response()->json($images);
    }

    public function addPhoto(Request $request, $seq_id)
    {
        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png'
        ]);

        $report = Logged::company()->reports()->bySeqId($seq_id);

        $this->authorize('addPhoto', $report);

        $file = $request->file('photo');
        $report->addImageFromForm($file);

    }

    public function removePhoto($seq_id, $order)
    {
        $report = Logged::company()->reports()->bySeqId($seq_id);

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
    public function update(UpdateReportRequest $request, $seq_id)
    {
        $company = Logged::company();
        $report = $company->reports()->bySeqId($seq_id);

        $this->authorize('update', $report);

        $urc = Logged::user()->selectedUser;
        // Only System Administrator can change the person and created_at
        if($urc->isRole('admin')){
            if($request->has('person')){
                $person = $company->UserRoleCompanies()->bySeqId($request->person);
                $report->user_role_company_id = $person->id;
            }
            if($request->has('completed_at')){
                $completed_at = (new Carbon($request->completed_at, $company->timezone))
                            ->setTimezone('UTC');
                $report->completed = $completed_at;
            }
        }

        foreach ($request->readings as $measurement_id => $value) {
            $reading = $report->readings()->updateOrCreate(
                [ 'measurement_id' => $measurement_id ],
                [ 'value' => $value ]
            );
        }

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
        $report = Logged::company()->reports()->bySeqId($seq_id);

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
