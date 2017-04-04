<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JavaScript;
use Carbon\Carbon;


use App\Http\Requests;
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

        $admin = $this->loggedUserAdministrator();

        $service_id = $service_seq_id;
        $technicians = $this->userRoleCompanyHelpers->transformForDropdown($admin->techniciansInOrder()->get());

        return view('todaysroute.createReport', compact('technicians', 'service_id'));
    }

    public function storeReport(Request $request)
    {
        $this->authorize('create', Report::class);

        $admin = $this->loggedUserAdministrator();

        $completed_at = Carbon::now($admin->timezone);
        $service = $admin->services()->bySeqId($request->service_id);
        $technician = $admin->technicianBySeqId($request->technician_id);

        $on_time = 'onTime';
        if($service->hasServiceContract()){
            $on_time = $this->reportHelpers->checkOnTimeValue(
                // ****** check the timezoen for check on time
                    $completed_at,
                    $service->serviceContract->start_time,
                    $service->serviceContract->end_time,
                    $admin->timezone
                );
        }

        $report = $service->reports()->create([
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
            flash()->success('Created', 'Report was created successfuly.');
            return redirect('todaysroute');
        }
        flash()->error('Not created', 'Report was not created, please try again later.');
        return redirect()->back();
    }


}
