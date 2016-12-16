<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\PRS\Traits\Model\ImageTrait;

use App\PRS\ValueObjects\Administrator\Tags;
use App\PRS\ValueObjects\Administrator\Permissions;
use App\PRS\ValueObjects\Administrator\TagTurbidity;
use App\PRS\ValueObjects\Administrator\Tag;

use App\PRS\Traits\Model\BillableAdministrator;
use App\Invoice;
use App\Payment;

use DB;

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


    //******** RELATIONSHIPS ********

    /**
     * Get the user this administrator is morphed by
     * @return \App\User
     * tested
     */
    public function user()
    {
        return $this->morphOne('App\User', 'userable');
    }


    /**
     * Get reports associatod with this user
     * tested
     */
    public function reports(){
        return $this->hasManyThrough('App\Report', 'App\Service', 'admin_id');
    }

    /**
     * Get reports order by seq_id
     * @param  string $order    'asc' or 'desc'
     */
    public function reportsInOrder($order = 'asc')
    {
        return $this->reports()->orderBy('seq_id', $order);
    }

    /**
     * Get the reports based on the seq_id
     * @param  integer $seq_id
     * @return App\Report
     * tested
     */
    public function reportsBySeqId($seq_id){
        return $this->reports()
                    ->where('reports.seq_id', '=', $seq_id)
                    ->firstOrFail();
    }


    /**
     * Get the reports in this date
     * @param  Carbon $date date is Administrator timzone
     * tested
     */
    public function reportsByDate(Carbon $date){
        $date_str = $date->toDateTimeString();
        return $this->reports()
                    ->where(\DB::raw('DATEDIFF(CONVERT_TZ(completed,\'UTC\',\''.$this->timezone.'\'), "'.$date_str.'")'), '=', '0')
                    ->orderBy('seq_id');
    }

    /**
     *  Get services associated with this user
     * @param boolean
     * @return Collection
     * tested
     */
    public function workOrders(){
        return $this->hasManyThrough(
                        'App\WorkOrder',
                        'App\Service',
                        'admin_id');
    }

    /**
     * Get work orders ordered by seq_id
     * @param  string $order    asc or desc
     */
    public function workOrdersInOrder($order = 'asc')
    {
        return $this->workOrders()->orderBy('seq_id', $order);
    }

    /**
     * Get the work order based on the seq_id
     * @param  integer $seq_id
     * @return App\WorkOrder
     * tested
     */
    public function workOrderBySeqId($seq_id){
        return $this->workOrders()
                    ->where('work_orders.seq_id', '=', $seq_id)
                    ->firstOrFail();
    }

    /**
     * Get invoices associated with this user
     */
    public function invoices()
    {
        return Invoice::where('admin_id', $this->id);
    }

    /**
     * Get the invoices based on the seq_id
     * @param  integer $seq_id
     * @return App\Invoice
     */
    public function invoicesBySeqId($seq_id){
        return $this->invoices()
                    ->where('invoices.seq_id', '=', $seq_id)
                    ->firstOrFail();
    }

    /**
     * Get invoices associated with this user
     */
    public function payments()
    {
        return Payment::join('invoices', 'invoices.id', '=', 'payments.invoice_id')
                    ->where('admin_id', '=', $this->id)
                    ->select('payments.*');
    }

    /**
     * Get the payments based on the seq_id
     * @param  integer $seq_id
     * @return App\Payment
     */
    public function paymentsBySeqId($seq_id){
        return $this->payments()
                    ->where('payments.seq_id', '=', $seq_id)
                    ->firstOrFail();
    }

    /**
     *  Get services associated with this user
     * tested
     */
    public function services()
    {
        return $this->hasMany('App\Service', 'admin_id');
    }

    /**
     * Get services ordered by seq_id
     * @param  string $order    asc or desc
     */
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
        return $this->services()
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

    /**
     * Get clients ordered by seq_id
     * @param  string $order    asc or desc
     */
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
        return $this->clients()
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

    /**
     * Get supervisors ordered by seq_id
     * @param  string $order    asc or desc
     */
    public function supervisorsInOrder($order = 'asc')
    {
        return $this->supervisors()
                    ->orderBy('supervisors.seq_id', $order);
    }

    /**
     * Get supervisor accacited with this user and seq_id convination
     * @param  int $seq_id
     * tested
     */
    public function supervisorBySeqId($seq_id){
        return $this->supervisors()
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

    /**
     * Get technicians ordered by seq_id
     * @param  string $order    asc or desc
     */
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


    //******** VALUE OBJECTS ********

    public function tags()
    {
        return new Tags($this->phTags(), $this->chlorineTags(),
                        $this->temperatureTags(), $this->turbidityTags(),
                        $this->saltTags());
    }

    public function permissions()
    {
        return new Permissions($this);
    }


    //******** MISCELLANEOUS ********

    /**
     * Get all dates that have at least one report in them
     * @return Collection
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
            ->filter(function($item){
                return $item->hasServiceContract();
            })
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


        protected function phTags()
    {
        return new Tag($this->ph_very_low,
                        $this->ph_low,
                        $this->ph_perfect,
                        $this->ph_high,
                        $this->ph_very_high);
    }

    protected function chlorineTags()
    {
        return new Tag($this->chlorine_very_low,
                        $this->chlorine_low,
                        $this->chlorine_perfect,
                        $this->chlorine_high,
                        $this->chlorine_very_high);
    }

    protected function temperatureTags()
    {
        return new Tag($this->temperature_very_low,
                        $this->temperature_low,
                        $this->temperature_perfect,
                        $this->temperature_high,
                        $this->temperature_very_high);
    }

    protected function turbidityTags()
    {
        return new TagTurbidity($this->turbidity_perfect,
                        $this->turbidity_low,
                        $this->turbidity_high,
                        $this->turbidity_very_high);
    }

    protected function saltTags()
    {
        return new Tag($this->salt_very_low,
                        $this->salt_low,
                        $this->salt_perfect,
                        $this->salt_high,
                        $this->salt_very_high);
    }



}
