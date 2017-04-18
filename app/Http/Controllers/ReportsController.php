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

        $company = $this->loggedCompany();
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
    public function create(Request $request)
    {
        $this->authorize('create', Report::class);

        $company = $this->loggedCompany();

        $services = $this->serviceHelpers->transformForDropdown($company->services()->seqIdOrdered()->get());
        $people = $this->userRoleCompanyHelpers->transformForDropdown(
                            $company->userRoleCompanies()
                                        ->ofRole('admin', 'sup', 'tech')
                                        ->seqIdOrdered()->get()
                        );

        $chemicals = $report->service->chemicals()->get()
            ->transform(function ($chemical) {
                return (object)[
                    'id' => $chemical->id,
                    'name' => $chemical->globalChemical->name,
                    'labels' => $chemical->globalChemical
                                        ->labels()
                                        ->select('name', 'color', 'value')
                                        ->get(),
                ];
            });

        return view('reports.create', compact('services', 'people'));
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

        $company = $this->loggedCompany();

        $completed_at = (new Carbon($request->completed_at, $company->timezone));
        $service = $this->loggedCompany()->services()->bySeqId($request->service);
        $person = $this->loggedCompany()->userRoleCompanies()->bySeqId($request->person);

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
        $report = $this->loggedCompany()->reports()->bySeqId($seq_id);

        $this->authorize('view', $report);
        $images = $this->imageTransformer->transformCollection($report->images);
        $readings = $report->readings->transform(function ($reading){
            $globalChemical = $reading->globalChemical;
            return (object)[
                'chemical_name' => $globalChemical->name,
                'color' => $globalChemical->labels()->whereValue($reading->value)->color,
                'name' => $globalChemical->labels()->whereValue($reading->value)->name,
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
    //     $report = $this->loggedCompany()->reports()->bySeqId($request->id);
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
        $company = $this->loggedCompany();
        $report = $company->reports()->bySeqId($seq_id);

        $this->authorize('update', $report);

        $people = $this->userRoleCompanyHelpers->transformForDropdown(
                                        $company->userRoleCompanies()
                                            ->ofRole('admin', 'sup', 'tech')
                                            ->seqIdOrdered()->get()
                                    );
        $chemicals = $report->service->chemicals()->get()
                            ->transform(function ($chemical) {
                                return (object)[
                                    'id' => $chemical->id,
                                    'name' => $chemical->globalChemical->name,
                                    'labels' => $chemical->globalChemical
                                                        ->labels()
                                                        ->select('name', 'color', 'value')
                                                        ->get(),
                                ];
                            });
        $readings = $report->readings()->get()->pluck('value', 'chemical_id')->toArray();

        $date = (new Carbon($report->completed, 'UTC'))
                    ->setTimezone($company->timezone)
                    ->format('m/d/Y h:i:s A');
        JavaScript::put([
            'defaultDate' => $date,
        ]);
        return view('reports.edit', compact('report', 'people', 'chemicals', 'readings'));
    }

    public function getPhoto(Request $request, $seq_id)
    {
        $report = $this->loggedCompany()->reports()->bySeqId($seq_id);

        $this->authorize('view', $report);

        $images = $this->imageTransformer->transformCollection($report->images);

        return response()->json($images);
    }

    public function addPhoto(Request $request, $seq_id)
    {
        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png'
        ]);

        $report = $this->loggedCompany()->reports()->bySeqId($seq_id);

        $this->authorize('addPhoto', $report);

        $file = $request->file('photo');
        $report->addImageFromForm($file);

    }

    public function removePhoto($seq_id, $order)
    {
        $report = $this->loggedCompany()->reports()->bySeqId($seq_id);

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

        $company = $this->loggedCompany();
        $report = $company->reports()->bySeqId($seq_id);

        $this->authorize('update', $report);

        $person = $company->UserRoleCompanies()->bySeqId($request->person);

        $completed_at = (new Carbon($request->completed_at, $company->timezone))
                            ->setTimezone('UTC');

        $report->user_role_company_id   = $person->id;
        $report->completed              = $completed_at;
        foreach ($request->readings as $chemical_id => $value) {
            $reading = $report->readings()->updateOrCreate(
                [ 'chemical_id' => $chemical_id ],
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
        $report = $this->loggedCompany()->reports()->bySeqId($seq_id);

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
