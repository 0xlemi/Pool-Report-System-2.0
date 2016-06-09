<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use JavaScript;

use App\Service;
use App\PRS\Helpers\ServiceHelpers;

use App\Http\Requests;
use App\Http\Requests\CreateServiceRequest;

class ServicesController extends Controller
{

    protected $serviceHelpers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(serviceHelpers $serviceHelpers)
    {
        $this->serviceHelpers = $serviceHelpers;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if($user->cannot('index', Service::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator()){
            $services = $user->userable()->services()->get();
        }else{
            $services = $user->userable()->user()->services()->get();
        }

        JavaScript::put([
            'click_url' => url('services').'/',
        ]);

        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        if($user->cannot('creates', Service::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateServiceRequest $request)
    {

        $user = Auth::user();
        if($user->cannot('create', Service::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator())
        {
            $admin = $user->userable();
        }else{
            $admin = $user->userable()->admin();
        }

        // get the service days number 0-127
        $service_days = $this->serviceHelpers->service_days_to_num(
            $request->service_days_monday,
            $request->service_days_tuesday,
            $request->service_days_wednesday,
            $request->service_days_thursday,
            $request->service_days_friday,
            $request->service_days_saturday,
            $request->service_days_sunday
        );
        $service = Service::create([
            'name' => $request->name,
            'address_line' => $request->address_line,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'type' => ($request->type)? 1:2, // 1=clorine, 2=salt
            'service_days' => $service_days,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => ($request->status)? 1:0, // 0=inactive, 1=active
            'comments' => $request->comments,
            'admin_id' => $admin->id,
        ]);
        $photo = true;
        if($request->photo){
            $photo = $service->addImageFromForm($request->file('photo'));
        }
        if($service && $photo){
            flash()->success('Created', 'New service successfully created.');
            return redirect('services');
        }
        flash()->success('Not created', 'New service was not created, please try again later.');
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
        if($user->cannot('create', Service::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator())
        {
            $service = $user->userable()->serviceBySeqId($seq_id);
        }else{
            $service = $user->userable()->admin()->serviceBySeqId($seq_id);
        }
        return view('services.show',compact('service'));
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
        if($user->cannot('edit', Service::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator())
        {
            $service = $user->userable()->serviceBySeqId($seq_id);
        }else{
            $service = $user->userable()->admin()->serviceBySeqId($seq_id);
        }

        return view('services.edit',compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateServiceRequest $request, $seq_id)
    {
        $user = Auth::user();
        if($user->cannot('edit', Service::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator())
        {
            $service = $user->userable()->serviceBySeqId($seq_id);
        }else{
            $service = $user->userable()->admin()->serviceBySeqId($seq_id);
        }

        // get the service days number 0-127
        $service_days = $this->serviceHelpers->service_days_to_num(
            $request->service_days_monday,
            $request->service_days_tuesday,
            $request->service_days_wednesday,
            $request->service_days_thursday,
            $request->service_days_friday,
            $request->service_days_saturday,
            $request->service_days_sunday
        );

        $service->name = $request->name;
        $service->address_line = $request->address_line;
        $service->city = $request->city;
        $service->state = $request->state;
        $service->postal_code = $request->postal_code;
        $service->country = $request->country;
        $service->type = ($request->type)? 1:2; // 1=clorine, 2=salt
        $service->service_days = $service_days;
        $service->amount = $request->amount;
        $service->currency = $request->currency;
        $service->start_time = $request->start_time;
        $service->end_time = $request->end_time;
        $service->status = ($request->status)? 1:0; // 0=inactive, 1=active
        $service->comments = $request->comments;

        $photo = true;
        if($request->photo){
            $service->images()->delete();
            $photo = $service->addImageFromForm($request->file('photo'));
        }

        if($service->save() && $photo){
            flash()->success('Updated', 'New service successfully updated.');
            return redirect('services/'.$seq_id);
        }
        flash()->error('Not Updated', 'Service was not updated, please try again later.');
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
        if($user->cannot('destroy', Service::class))
        {
            // abort(403);
            return 'you should not pass';
        }

        if($user->isAdministrator())
        {
            $service = $user->userable()->serviceBySeqId($seq_id);
        }else{
            $service = $user->userable()->admin()->serviceBySeqId($seq_id);
        }

        if($service->delete()){
            flash()->success('Deleted', 'The service was successfuly deleted');
            return redirect('services');
        }
        flash()->error('Not Deleted', 'We could not delete the service, please try again later.');
        return redirect()->back();
    }
}
