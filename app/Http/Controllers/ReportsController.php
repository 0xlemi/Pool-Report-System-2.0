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
class ReportsController extends Controller
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
        return $this->index_by_date(Carbon::now()->toDateString());
    }

    /**
     * Display the listing of all the reports by date
     * @param  String $date yyyy-mm-dd format date
     * @return \Illuminate\Http\Response
     */
    public function index_by_date($date){
        if(!validateDate($date)){
            return $this->index();
        }

        if(Auth::user()->cannot('index', Report::class)){
            // abort(403);
            return 'you should not pass';
        }
        $reports = Auth::user()->userable()->reportsByDate($date);
        // dd($reports);
        JavaScript::put([
            'date_url' => url('reports/date').'/',
            'click_url' => url('reports').'/',
            'date_selected' => $date,
        ]);

        return view('reports.index',compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Auth::user()->services;
        $technicians = Auth::user()->technicians;
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
        $completed_at = (new Carbon($request->completed_at));
        $service = Auth::user()->serviceBySeqId($request->service);
        $technician = Auth::user()->technicianBySeqId($request->technician);

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
        $report = Auth::user()->reportsBySeqId($seq_id);
        return view('reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($seq_id)
    {
        $report = Auth::user()->reportsBySeqId($seq_id);
        $services = Auth::user()->services;
        $technicians = Auth::user()->technicians;

        $date = (new Carbon($report->completed))->format('m/d/Y h:i:s A');
        JavaScript::put([
            'default_date' => $date,
        ]);
        return view('reports.edit', compact('report', 'services', 'technicians'));
    }


    public function addPhoto(Request $request, $seq_id){
        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png'
        ]);

        $report = Auth::user()->reportsBySeqId($seq_id);
        $file = $request->file('photo');

        $report->addImageFromForm($file);

    }

    public function removePhoto($seq_id, $order){
        $report = Auth::user()->reportsBySeqId($seq_id);
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

        $report = Auth::user()->reportsBySeqId($seq_id);
        $service = Auth::user()->serviceBySeqId($request->service);
        $technician = Auth::user()->technicianBySeqId($request->technician);

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
        $report = Auth::user()->reportsBySeqId($seq_id);
        if($report->delete()){
            flash()->success('Deleted', 'The report was successfuly deleted');
            return redirect('reports');
        }
        flash()->error('Nope', 'We could not delete the report, please try again later.');
        return redirect()->back();
    }
}
