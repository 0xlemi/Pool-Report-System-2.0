<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\PRS\Traits\Model\ImageTrait;


use App\PRS\Traits\Model\BillableAdministrator;

use Carbon\Carbon;

class Administrator extends Model
{

    use ImageTrait;
    use BillableAdministrator;

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
     * @return Collertion
     * tested
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
     * Total number of services that need to be done today
     * @return int
     * no need for test
     */
    public function numberServicesDoToday()
    {
        return $this->numberServicesDoIn(Carbon::today($this->timezone));
    }

    /**
     * Total number of services that need to be done in a date
     * @param  Carbon $date in Administrator set Timezone
     * @return  int
     * no need for test
     */
    public function numberServicesDoIn(Carbon $date)
    {
        return $this->servicesDoIn($date, true)->count();
    }

    /**
     * Number of services that are missing in a date
     * @param  Carbon $date in Administrator set Timezone
     * @return  int
     * no need for test
     */
    public function numberServicesMissing(Carbon $date)
    {
        return $this->servicesDoIn($date)->count();
    }

    /**
     * get the services that need to be done today
     * @param  boolean $AddCompletedReports add or remove services that where already done today
     * @return Collection
     * no need for test
     */
    public function servicesDoToday($AddCompletedReports = false)
    {
        return $this->servicesDoIn(Carbon::today($this->timezone) , $AddCompletedReports);
    }

    /**
     * get the services that need to be done in certain date
     * @param  Carbon  $date in Administrator timezone
     * @param  boolean $AddCompletedReports   add or remove the services that where already done
     * @return Collection
     * tested
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
     * @param  Carbon $date date is Administrator timzone
     * tested
     */
    public function reportsByDate(Carbon $date){
        $date_str = $date->toDateTimeString();
        return $this->hasManyThrough('App\Report', 'App\Service', 'admin_id')
                    ->where(\DB::raw('DATEDIFF(CONVERT_TZ(completed,\'UTC\',\''.$this->timezone.'\'), "'.$date_str.'")'), '=', '0')
                    ->orderBy('seq_id');
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
     * Get the reports based on the seq_id
     * @param  integer $seq_id
     * @return App\Report
     * tested
     */
    public function reportsBySeqId($seq_id){
        return $this->hasManyThrough('App\Report', 'App\Service', 'admin_id')
                    ->where('reports.seq_id', '=', $seq_id)
                    ->firstOrFail();
    }

    /**
     *  Get services associated with this user
     * @param boolean
     * @return Collection
     * tested
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
     * @return App\WorkOrder
     * tested
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
    public function services(){
        return $this->hasMany('App\Service', 'admin_id');
    }

    public function servicesInOrder($order = 'asc')
    {
        return $this->services()->orderBy('seq_id', $order);
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

    /**
     * Get clients associated with this user
     * tested
     */
    public function clients(){
        return Client::where('admin_id', $this->id);
    }

    public function clientsInOrder($order = 'asc')
    {
        return $this->clients()->orderBy('seq_id', $order);
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
    public function supervisors(){
        return $this->hasMany('App\Supervisor', 'admin_id');
    }

    public function supervisorsInOrder($order = 'asc')
    {
        return $this->technicians()
                    ->orderBy('supervisors.seq_id', $order);
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

    /**
     * Get technicians assaciated with this admin
     * tested
     */
    public function technicians(){
        return $this->hasManyThrough(
                            'App\Technician',
                            'App\Supervisor',
                            'admin_id'
                        );
    }

    public function techniciansInOrder($order = 'asc')
    {
        return $this->technicians()->orderBy('technicians.seq_id', $order);
    }

    /**
     * Get technicains associated with this user and seq_id convination
     * @param  int $seq_id
     * tested
     */
    public function technicianBySeqId($seq_id){
        return $this->technicians()
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
