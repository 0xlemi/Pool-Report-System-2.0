<?php

namespace App;

use Laravel\Cashier\Billable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\PRS\Traits\Model\ImageTrait;


use Carbon\Carbon;

class Administrator extends Model
{

    use ImageTrait;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'company_name',
        'website',
        'facebook',
        'twitter',
        'timezone',
        'language',
    ];

    /**
     * hidden variables
     * @var array
     */
	protected $hidden = [
        'free_objects',
        'stripe_id',
        'card_brand',
        'card_last_four',
        'trial_ends_at'
	];

    /**
     * Get the user this administrator is morphed by
     * @return $user
     * tested
     */
    public function user()
    {
        return $this->morphOne('App\User', 'userable')->first();
    }

    /**
     * Get all dates that have at least one report in them
     * tested
     * @return Collertion
     */
    public function datesWithReport()
    {
        $admin = $this;
        return $this->reports()
                    ->get()
                    ->pluck('completed')
                    ->transform(function ($item) use ($admin){
                        $date = (new Carbon($item, 'UTC'))->setTimezone($admin->timezone);
                        return $date->toDateString();
                    })
                    ->unique()
                    ->flatten();
    }

    /**
     * Get reports associatod with this user
     * tested
     */
    public function reports($descending_order = false){
        $order = ($descending_order) ? 'desc' : 'asc';
        return $this->hasManyThrough('App\Report', 'App\Service', 'admin_id')
                    ->orderBy('seq_id', $order);
    }

    /**
     * Total number of services that need to be done today
     * @return int
     */
    public function numberServicesDoToday()
    {
        return $this->numberServicesDoIn(Carbon::today($this->timezone));
    }

    /**
     * Total number of services that need to be done in a date
     * @param  Carbon $date in Administrator set Timezone
     * @return  int
     */
    public function numberServicesDoIn(Carbon $date)
    {
        return $this->servicesDoIn($date, true)->count();
    }

    /**
     * Number of services that are missing in a date
     * @param  Carbon $date in Administrator set Timezone
     * @return  int
     */
    public function numberServicesMissing(Carbon $date)
    {
        return $this->servicesDoIn($date)->count();
    }

    /**
     * get the services that need to be done today
     * @param  boolean $AddCompletedReports add or remove services that where already done today
     * @return Collection
     */
    public function servicesDoToday($AddCompletedReports = false)
    {
        return $this->servicesDoIn(Carbon::today($this->timezone) , $AddCompletedReports);
    }

    /**
     * get the services that need to be done in certain date
     * tested
     * @param  Carbon  $date in Administrator timezone
     * @param  boolean $AddCompletedReports   add or remove the services that where already done
     * @return Collection
     */
    public function servicesDoIn(Carbon $date, $AddCompletedReports = false)
    {
        if($date->timezone != (new \DateTimeZone($this->timezone))){
            $date = $date->setTimezone($this->timezone);
        }

        return $this->services()
            ->get()
            ->map(function($service) use ($date, $AddCompletedReports){
                // check that the service is do in this date
                if($service->checkIfIsDo($date)){
                    // what to add all the reports or only the ones that are missing for $date
                    if($AddCompletedReports){
                        // add all reports that are do
                        return $service;
                    }else{
                        // check that the report is missing in the $date
                        if(!$service->checkIfIsDone($date)){
                            return $service;
                        }
                    }
                }
            })->reject(function($service){
                return is_null($service);
            });
    }

    /**
     * Get the reports in this date
     * tested
     * @param  Carbon $date date is Administrator timzone
     *
     */
    public function reportsByDate(Carbon $date){
        $date_str = $date->toDateTimeString();
        return $this->hasManyThrough('App\Report', 'App\Service', 'admin_id')
                    ->where(\DB::raw('DATEDIFF(CONVERT_TZ(completed,\'UTC\',\''.$this->timezone.'\'), "'.$date_str.'")'), '=', '0')
                    ->orderBy('seq_id');
    }

    /**
     * Get the reports based on the seq_id
     * @param  integer $seq_id
     * @return $report
     * tested
     */
    public function reportsBySeqId($seq_id){
        return $this->hasManyThrough('App\Report', 'App\Service', 'admin_id')
                    ->where('reports.seq_id', '=', $seq_id)
                    ->firstOrFail();
    }

    /**
     *  Get services associated with this user
     */
    public function workOrders($descending_order = false){
        $order = ($descending_order) ? 'desc' : 'asc';
        return $this->hasManyThrough(
                        'App\WorkOrder',
                        'App\Service',
                        'admin_id')->orderBy('seq_id', $order);
    }

    /**
     * Get the work order based on the seq_id
     * @param  integer $seq_id
     * @return $report
     */
    public function workOrderBySeqId($seq_id){
        return $this->hasManyThrough(
                        'App\WorkOrder',
                        'App\Service',
                        'admin_id')
                    ->where('work_orders.seq_id', '=', $seq_id)
                    ->firstOrFail();
    }

    /**
     *  Get services associated with this user
     * tested
     */
    public function services($descending_order = false){
        $order = ($descending_order) ? 'desc' : 'asc';
        return $this->hasMany('App\Service', 'admin_id')->orderBy('seq_id', $order);
    }

    /**
     * Get services accacited with this user and seq_id convination
     * @param  int $seq_id
     * tested
     */
    public function serviceBySeqId($seq_id){
        return $this->hasMany('App\Service', 'admin_id')
                    ->where('services.seq_id', '=', $seq_id)
                    ->firstOrFail();
    }

    // not on use
    public function clientsThroughServices(){
        $this->load('services.clients'); // eager load far relation
        $clients = new Collection; // Illuminate\Database\Eloquent\Collection

        foreach ($this->services as $service)
        {
           $clients = $clients->merge($service->clients);
        }

        $clients = $clients->unique()->sortBy('seq_id'); // remove the duplicates

        return $clients; // all clients collection
    }

    /**
     * Get clients associated with this user
     * tested
     */
    public function clients($descending_order = false){
        $order = ($descending_order) ? 'desc' : 'asc';
        return Client::where('admin_id', $this->id)->orderBy('seq_id', $order);
    }

    /**
     * Get clients accacited with this user and seq_id convination
     * @param  int $seq_id
     * tested
     */
    public function clientsBySeqId($seq_id){
        return Client::where('admin_id', $this->id)
                    ->where('clients.seq_id', '=', $seq_id)
                    ->firstOrFail();
    }

    /**
     * Get supervisors assaciated with this user
     * tested
     */
    public function supervisors($descending_order = false){
        $order = ($descending_order) ? 'desc' : 'asc';
        return $this->hasMany('App\Supervisor', 'admin_id')
                    ->orderBy('seq_id', $order);
    }

    /**
     * Get supervisor accacited with this user and seq_id convination
     * @param  int $seq_id
     * tested
     */
    public function supervisorBySeqId($seq_id){
        return $this->hasMany('App\Supervisor', 'admin_id')
                    ->where('supervisors.seq_id', '=', $seq_id)
                    ->firstOrFail();
    }

    public function setBillibleUsersAsInactive()
    {
        return ($this->setSupervisorsAsInactive() && $this->setTechniciansAsInactive());
    }

    protected function setSupervisorsAsInactive()
    {
        $supervisors = $this->supervisors()->get();
        foreach ($supervisors as $supervisor) {
            $user = $supervisor->user();
            $user->active = 0;
            $user->save();
        }
    }

    protected function setTechniciansAsInactive()
    {
        $technicians = $this->technicians()->get();
        foreach ($technicians as $technician) {
            $user = $technician->user();
            $user->active = 0;
            $user->save();
        }
    }

    /**
     * Check if you can add another object like supervisor or technician
     * @return boolean
     */
    public function canAddObject()
    {
        // check that the user has a subcription or that has free objects left.
        if($this->subscribedToPlan('pro', 'main') || ($this->objectActiveCount() < $this->free_objects)){
            return true;
        }
        return false;
    }

    /**
     * Objects that are we should bill for, after the free ones are deducted.
     * @return int      number of elements to change for
     */
    public function billableObjects()
    {
        $count = $this->objectActiveCount() - $this->free_objects;
        return max($count,0);
    }

    /**
     * Number of technicans + supervisors that are active
     * @return int
     */
    public function objectActiveCount()
    {
        return $this->techniciansActive()->count()
                + $this->supervisorsActive()->count();
    }

    public function techniciansActive($active = true)
    {
        $isActive = ($active)? 1:0;
        return $this->technicians()->get()
                    ->filter(function($item) use ($isActive){
                        return ($item->user()->active == $isActive);
                    });
    }

    public function supervisorsActive($active = true)
    {
        $isActive = ($active)? 1:0;
        return $this->supervisors()->get()
                    ->filter(function($item) use ($isActive){
                        return ($item->user()->active == $isActive);
                    });
    }

    /**
     * Get technicians assaciated with this user
     * tested
     */
    public function technicians($descending_order = false){
        $order = ($descending_order) ? 'desc' : 'asc';
        return $this->hasManyThrough(
                        'App\Technician',
                        'App\Supervisor',
                        'admin_id')
                    ->orderBy('technicians.seq_id', $order);
    }

    // /**
    //  * Get technicians assaciated with this user
    //  */
    // public function technicians(){
    //     return $this->hasManyThrough(
    //                     'App\Technician',
    //                     'App\Supervisor',
    //                     'admin_id');
    // }
    //
    // /**
    //  *
    //  * get technicians ordered
    //  * @param  boolean $descending_order
    //  */
    // public function techniciansOrderBy($descending_order = false)
    // {
    //     $order = ($descending_order) ? 'desc' : 'asc';
    //     return $this->technicians()
    //                 ->orderBy('technicians.seq_id', $order);
    // }

    /**
     * Get technicains associated with this user and seq_id convination
     * @param  int $seq_id
     * tested
     */
    public function technicianBySeqId($seq_id){
        return $this->hasManyThrough(
                        'App\Technician',
                        'App\Supervisor',
                        'admin_id')
                    ->where('technicians.seq_id', '=', $seq_id)
                    ->firstOrFail();
    }

    /**
     * Overwrite this from trait,
     * because foreign key is 'admin_id' not 'administrator_id'
     * tested
     */
    public function images(){
        return $this->hasMany('App\Image', 'admin_id');
    }

}
