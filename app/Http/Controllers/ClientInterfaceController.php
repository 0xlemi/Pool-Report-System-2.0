<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JavaScript;
use App\PRS\Transformers\ReportTransformer;
use Carbon\Carbon;

class ClientInterfaceController extends PageController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reports(Request $request, ReportTransformer $reportTransformer)
    {
        if(!$request->user()->isClient()){
            abort(403, 'Only clients can view this page.');
        }

        $this->validate($request, [
            'date' => 'validDateReportFormat'
        ]);

        $admin = $request->user()->admin();
        $client = $request->user()->userable();

        $date = (new Carbon($request->date, $admin->timezone));

        $reports = $reportTransformer->transformCollection($client->reportsByDate($date));

        $today = Carbon::today($admin->timezone);
        JavaScript::put([
            'enabledDates' => $admin->datesWithReport(),
            'todayDate' => $today->toDateString(),
        ]);

        return view('clientInterface.reports', compact('reports'));
    }

    public function statement(Request $request)
    {
        if(!$request->user()->isClient()){
            abort(403, 'Only clients can view this page.');
        }

        return view('clientInterface.statement');
    }

}
