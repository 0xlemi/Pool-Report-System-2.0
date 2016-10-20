<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JavaScript;
use Carbon\Carbon;


use App\Http\Requests;
use App\PRS\Helpers\ReportHelpers;
use App\PRS\Helpers\TechnicianHelpers;
use App\Report;

class TodaysRouteController extends PageController
{

    private $technicianHelpers;
    private $reportHelpers;

    public function __construct(TechnicianHelpers $technicianHelpers,
                                ReportHelpers $reportHelpers)
    {
        $this->technicianHelpers = $technicianHelpers;
        $this->reportHelpers = $reportHelpers;
    }

    public function index()
    {
        $default_table_url = url('datatables/todaysroute');

        JavaScript::put([
            'click_url' => url('todaysroute/report/').'/',
        ]);

        return view('todaysroute.index', compact('default_table_url'));
    }

    public function createReport(Request $request, int $service_seq_id)
    {
        $admin = $this->loggedUserAdministrator();

        $service_id = $service_seq_id;
        $technicians = $this->technicianHelpers->transformForDropdown($admin->techniciansInOrder()->get());

        JavaScript::put([
            // 'dropdownKey' => $request->old('service'),
            'dropdownKey2' => $request->old('technician'),
        ]);

        return view('todaysroute.createReport', compact('technicians', 'service_id'));
    }

    public function storeReport(Request $request)
    {
        $admin = $this->loggedUserAdministrator();

        $completed_at = Carbon::now($admin->timezone);
        $service = $admin->serviceBySeqId($request->service_id);
        $technician = $admin->technicianBySeqId($request->technician_id);

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
                // // notify the clients
                // foreach ($service->clients()->get() as $client) {
                //     $client->user()->notify(new ReportCreatedNotification($report));
                // }
                // // notify the supervisor
                // $report->supervisor()->user()->notify(new ReportCreatedNotification($report));

            flash()->success('Created', 'Report was created successfuly.');
            return redirect('todaysroute');
        }
        flash()->error('Not created', 'Report was not created, please try again later.');
        return redirect()->back();
    }


}
