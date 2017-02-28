<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JavaScript;
use App\PRS\Transformers\FrontEnd\ReportFrontTransformer;
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

    public function reports(Request $request)
    {
        if(!$request->user()->isClient()){
            abort(403, 'Only clients can view this page.');
        }

        $admin = $request->user()->admin();
        $client = $request->user()->userable();
        $today = Carbon::today($admin->timezone)->toDateString();

        JavaScript::put([
            'enabledDates' => $client->datesWithReport(),
            'todayDate' => $today,
        ]);

        return view('clientInterface.reports', compact('today'));
    }

    public function reportsByDate(Request $request, ReportFrontTransformer $reportTransformer)
    {
        if(!$request->user()->isClient()){
            return response('You are not a Client', 403);
        }

        $this->validate($request, [
            'date' => 'validDateReportFormat'
        ]);

        $admin = $request->user()->admin();
        $client = $request->user()->userable();
        $date = (new Carbon($request->date, $admin->timezone));
        $reports = $reportTransformer->transformCollection($client->reportsByDate($date));

        return response([
            'reports' => $reports
        ]);
    }

    public function workOrders(Request $request)
    {
        if(!$request->user()->isClient()){
            return response('You are not a Client', 403);
        }
        return view('clientInterface.workorders');
    }

    public function workOrderTable(Request $request)
    {
        if(!$request->user()->isClient()){
            return response('You are not a Client', 403);
        }

        $admin = $request->user()->admin();
        $client = $request->user()->userable();
        $workOrders = $client->workOrders();

        return response($workOrders);
    }

    public function workOrderShow(Request $request)
    {

    }

    public function statement(Request $request)
    {
        if(!$request->user()->isClient()){
            abort(403, 'Only clients can view this page.');
        }

        return view('clientInterface.statement');
    }

}
