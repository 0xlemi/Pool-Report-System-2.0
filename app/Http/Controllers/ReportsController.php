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
    public function index_by_date($date)
    {
        if(!validateDate($date))
        {
            return $this->index();
        }

        $user = Auth::user();
        if($user->cannot('index', Report::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator())
        {
            $reports = $user->userable()->reportsByDate($date)->get();
        }else{
            $reports = $user->userable()->admin()->reportsByDate($date)->get();
        }

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
        $user = Auth::user();
        if($user->cannot('create', Report::class))
        {
            // abort(403);
            return 'you should not pass';
        }
        if($user->isAdministrator()){
            $services = $user->userable()->services()->get();
            $technicians = $user->userable()->technicians()->get();
        }else{
            $services = $user->userable()->admin()->services()->get();
            $technicians = $user->userable()->admin()->technicians()->get();
        }
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
        $user = Auth::user();
        if($user->cannot('create', Report::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator()){
            $completed_at = (new Carbon($request->completed_at));
            $service = $user->userable()->serviceBySeqId($request->service);
            $technician = $user->userable()->technicianBySeqId($request->technician);
        }else{
            $completed_at = (new Carbon($request->completed_at));
            $service = $user->userable()->admin()->serviceBySeqId($request->service);
            $technician = $user->userable()->admin()->technicianBySeqId($request->technician);
        }

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
        $user = Auth::user();
        if($user->cannot('show', Report::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator())
        {
            $report = $user->userable()->reportsBySeqId($seq_id);
        }else{
            $report = $user->userable()->admin()->reportsBySeqId($seq_id);
        }
        // dd($report->ph);

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
        $user = Auth::user();
        if($user->cannot('edit', Report::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator())
        {
            $report = $user->userable()->reportsBySeqId($seq_id);
            $services = $user->userable()->services()->get();
            $technicians = $user->userable()->technicians()->get();
        }else{
            $report = $user->userable()->admin()->reportsBySeqId($seq_id);
            $services = $user->userable()->admin()->services()->get();
            $technicians = $user->userable()->admin()->technicians()->get();
        }

        $date = (new Carbon($report->completed))->format('m/d/Y h:i:s A');
        JavaScript::put([
            'default_date' => $date,
        ]);
        return view('reports.edit', compact('report', 'services', 'technicians'));
    }


    public function addPhoto(Request $request, $seq_id)
    {
        $user = Auth::user();
        if($user->cannot('addPhoto', Report::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png'
        ]);

        if($user->isAdministrator()){
            $report = $user->userable()->reportsBySeqId($seq_id);
        }else{
            $report = $user->userable()->admin()->reportsBySeqId($seq_id);
        }

        $file = $request->file('photo');
        $report->addImageFromForm($file);

    }

    public function removePhoto($seq_id, $order)
    {
        $user = Auth::user();
        if($user->cannot('removePhoto', Report::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator())
        {
            $report = $user->userable()->reportsBySeqId($seq_id);
        }else{
            $report = $user->userable()->admin()->reportsBySeqId($seq_id);
        }

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
        $user = Auth::user();
        if($user->cannot('edit', Report::class))
        {
            // abort(403);
            return 'you should not pass';
        }

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

        if($user->isAdministrator()){
            $report = $user->userable()->reportsBySeqId($seq_id);
            $service = $user->userable()->serviceBySeqId($request->service);
            $technician = $user->userable()->technicianBySeqId($request->technician);
        }else{
            $report = $user->userable()->admin()->reportsBySeqId($seq_id);
            $service = $user->userable()->admin()->serviceBySeqId($request->service);
            $technician = $user->userable()->admin()->technicianBySeqId($request->technician);
        }

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
        $user = Auth::user();
        if($user->cannot('destroy', Report::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator())
        {
            $report = $user->userable()->reportsBySeqId($seq_id);
        }else{
            $report = $user->userable()->admin()->reportsBySeqId($seq_id);
        }

        if($report->delete()){
            flash()->success('Deleted', 'The report was successfuly deleted');
            return redirect('reports');
        }
        flash()->error('Nope', 'We could not delete the report, please try again later.');
        return redirect()->back();
    }
}
