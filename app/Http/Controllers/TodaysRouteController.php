<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JavaScript;
use Carbon\Carbon;


use App\Http\Requests;
use App\Http\Requests\CreateReportRequest;
use App\PRS\Helpers\ReportHelpers;
use App\PRS\Helpers\UserRoleCompanyHelpers;
use App\Service;
use App\Report;

class TodaysRouteController extends PageController
{

    private $userRoleCompanyHelpers;
    private $reportHelpers;

    public function __construct(UserRoleCompanyHelpers $userRoleCompanyHelpers,
                                ReportHelpers $reportHelpers)
    {
        $this->middleware('auth');
        $this->userRoleCompanyHelpers = $userRoleCompanyHelpers;
        $this->reportHelpers = $reportHelpers;
    }

    public function index()
    {
        $this->authorize('list', Service::class);
        $buttonsTags = [
            (object)[
                        'text' => 'Today',
                        'class' => 'btn-primary-outline',
                        'classSelected' => 'btn-primary',
                        'value' => 0,
                    ],
            (object)[
                        'text' => 'Tomorrow',
                        'class' => 'btn-default-outline',
                        'classSelected' => 'btn-default',
                        'value' => 1,
                    ],
            (object)[
                        'text' => Carbon::now()->addDays(2)->format('D'),
                        'class' => 'btn-default-outline',
                        'classSelected' => 'btn-default',
                        'value' => 2,
                    ],
            (object)[
                        'text' => Carbon::now()->addDays(3)->format('D'),
                        'class' => 'btn-default-outline',
                        'classSelected' => 'btn-default',
                        'value' => 3,
                    ],
            (object)[
                        'text' => Carbon::now()->addDays(4)->format('D'),
                        'class' => 'btn-default-outline',
                        'classSelected' => 'btn-default',
                        'value' => 4,
                    ],
            (object)[
                        'text' => Carbon::now()->addDays(5)->format('D'),
                        'class' => 'btn-default-outline',
                        'classSelected' => 'btn-default',
                        'value' => 5,
                    ],
            (object)[
                        'text' => Carbon::now()->addDays(6)->format('D'),
                        'class' => 'btn-default-outline',
                        'classSelected' => 'btn-default',
                        'value' => 6,
                    ],
        ];

        return view('todaysroute.index', compact('buttonsTags'));
    }

    public function createReport(Request $request, int $service_seq_id)
    {
        $this->authorize('create', Report::class);

        $company = $this->loggedCompany();

        $service = $company->services()->bySeqId($service_seq_id);
        $technicians = $this->userRoleCompanyHelpers->transformForDropdown(
                                            $company->userRoleCompanies()
                                                ->ofRole('admin', 'sup', 'tech')
                                                ->get()
                                        );
        $chemicals = $service->chemicals
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

        return view('todaysroute.createReport', compact('technicians', 'service', 'chemicals'));
    }

    public function storeReport(Request $request)
    {
        $company = $this->loggedCompany();

        $this->validate($request, [
            'service' => 'required|integer|existsBasedOnCompany:services,'.$company->id,
            'person' => 'required|integer|existsBasedOnCompany:user_role_company,'.$company->id,
            'readings' => 'array',
            'readings.*' => 'required|validReading:'.$request->service,
            'photo1' => 'required|mimes:jpg,jpeg,png',
            'photo2' => 'required|mimes:jpg,jpeg,png',
            'photo3' => 'required|mimes:jpg,jpeg,png',
        ]);

        $this->authorize('create', Report::class);

        $completed_at = Carbon::now($company->timezone);
        $service = $company->services()->bySeqId($request->service);
        $person = $company->userRoleCompanies()->bySeqId($request->person);

        $on_time = 'onTime';
        if($service->hasServiceContract()){
            $on_time = $this->reportHelpers->checkOnTimeValue(
                // ****** check the timezoen for check on time
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
        foreach ($request->readings as $chemical_id => $value) {
            $reading = $report->readings()->create([
                'chemical_id' => $chemical_id,
                'value' => $value,
            ]);
        }

        // add the 3 main photos
        $image1 = $report->addImageFromForm($request->file('photo1'));
        $image2 = $report->addImageFromForm($request->file('photo2'));
        $image3 = $report->addImageFromForm($request->file('photo3'));

        if($report && $image1 && $image2 && $image3){
            flash()->success('Created', 'Report was created successfuly.');
            return redirect('todaysroute');
        }
        flash()->error('Not created', 'Report was not created, please try again later.');
        return redirect()->back();
    }


}
