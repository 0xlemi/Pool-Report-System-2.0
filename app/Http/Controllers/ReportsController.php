<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Report;
use App\Photo;
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

        $reports = Auth::user()->reportsByDate($date);

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
        view('reports.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

        $file = $request->file('photo');

        // $name = get_random_name('image', $file->guessExtension());

        // $file->move(public_path('storage/images/report/'), $name);

        // $report = Auth::user()->reportsBySeqId($seq_id);

        

        // $report->addImage($image);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
