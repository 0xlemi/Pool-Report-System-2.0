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
use Auth;
class ReportsController extends PageController
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->checkPermissions('index');

        $default_table_url = url('datatables/reports').'?date='.Carbon::today()->toDateString();

        JavaScript::put([
            'date_url' => url('reports/date').'/',
            'datatable_url' => url('datatables/reports').'?date=',
            'click_url' => url('reports').'/',
            'enabledDates' => $this->loggedUserAdministrator()->datesWithReport(),
            'todayDate' => Carbon::today()->toDateString(),
        ]);

        return view('reports.index',compact('default_table_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->checkPermissions('create');

        $services = $this->loggedUserAdministrator()->services()->get();
        $technicians = $this->loggedUserAdministrator()->technicians()->get();

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

        $completed_at = (new Carbon($request->completed_at));
        $service = $this->loggedUserAdministrator->serviceBySeqId($request->service);
        $technician = $this->loggedUserAdministrator->technicianBySeqId($request->technician);

        $report = Report::create([
            'service_id' => $service->id,
            'technician_id' => $technician->id,
            'completed' => $completed_at,
            'ph' => $request->ph,
            'clorine' => $request->clorine,
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
            return redirect('reports/date/'.$completed_at->toDateString());
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

        $report = $this->loggedUserAdministrator()->reportsBySeqId($seq_id);

        $emailPreview = $report->getEmailImage();

        return view('reports.show', compact('report','emailPreview'));
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

        $report = $this->loggedUserAdministrator()->reportsBySeqId($seq_id);
        $services = $this->loggedUserAdministrator()->services()->get();
        $technicians = $this->loggedUserAdministrator()->technicians()->get();

        $date = (new Carbon($report->completed))->format('m/d/Y h:i:s A');
        JavaScript::put([
            'default_date' => $date,
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
            'clorine' => 'required|integer|min:1|max:5',
            'temperature' => 'required|integer|min:1|max:5',
            'turbidity' => 'required|integer|min:1|max:4',
            'salt' => 'required|integer|min:1|max:5',
        ]);

        $report = $this->loggedUserAdministrator()->reportsBySeqId($seq_id);
        $service = $this->loggedUserAdministrator()->serviceBySeqId($request->service);
        $technician = $this->loggedUserAdministrator()->technicianBySeqId($request->technician);

        $report->service_id     = $service->id;
        $report->technician_id  = $technician->id;
        $report->completed      = (new Carbon($request->completed_at));
        $report->ph             = $request->ph;
        $report->clorine        = $request->clorine;
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
