<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\PRS\Traits\Model\ImageTrait;

use App\PRS\ValueObjects\Administrator\Tags;
use App\PRS\ValueObjects\Administrator\Permissions;
use App\PRS\ValueObjects\Administrator\TagTurbidity;
use App\PRS\ValueObjects\Administrator\Tag;

use App\Invoice;
use App\Payment;
use App\Service;
use App\MissingHistory;

use DB;
use App\WorkOrder;
use App\Report;
use App\UserRoleCompany;
use App\PermissionRoleCompany;

use Carbon\Carbon;

class Company extends Model
{

    use ImageTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name',
        'website',
        'facebook',
        'twitter',
        'timezone',
        'language',
    ];





    //******** VALUE OBJECTS ********

    public function tags()
    {
        return new Tags($this->phTags(), $this->chlorineTags(),
                        $this->temperatureTags(), $this->turbidityTags(),
                        $this->saltTags());
    }

    public function permissions()
    {
        // return new Permissions($this);
    }


    //******** MISCELLANEOUS ********

    /**
     * Get all the services where there is an active contract
     * @return  Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function servicesWithActiveContract($order = 'asc')
    {
        return $this->services()->join('service_contracts', function ($join) {
            $join->on('services.id', '=', 'service_contracts.service_id')
                 ->where('service_contracts.active', '=', 1);
        })->select('services.*')->orderBy('seq_id', $order);
    }

    /**
    * THIS NEEDS TO BE CHECHED
	 * Get all the services that have no contract or the contract that they have is inactive
	 * @param  string $order
	 * @return Illuminate\Database\Query\Builder
	 */
    public function serviceWithNoContractOrInactive($order = 'asc')
    {
		// First we get all the clients with or with out service Contract
		// we select relevant information like service_contracts.service_id which is gonig to be null if that service has no contract
		// the service.id which is the id of the service all the time
		// and active because we also want to return the services with a contract that is inactive
        $serviceArray = $this->services()
						->leftJoin('service_contracts', 'services.id', '=', 'service_contracts.service_id')
        				->select('service_contracts.service_id', 'services.id', 'service_contracts.active')
						->get()->toArray();

		// Since Query Builder is not that great
		// We filter to 2 conditions to get the services
		// if it don't have a contract (if service_id == null)
		// and if it has a contract but happens to be inactive (if active is false)
		foreach ($serviceArray as $key => $value) {
			// (filter out services with contracts) and (even if it has one must not be active)
			if(($value['service_id'] != null) && ($value['active'])){
				unset($serviceArray[$key]);
			}else{
				// replace array with values for the service.id
				// that is the only thing that matters really
				$serviceArray[$key] = $value['id'];
			}
		}

		// reorder de array ids so they are sequential
		$serviceArray = array_values($serviceArray);
		// get Query Builder result with the whereIn
		// because the find gives you a collection
		return Service::whereIn('id', $serviceArray);
    }

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

        return $this->servicesWithActiveContract()
            ->get()
            ->filter(function($service) use ($date, $AddCompletedReports){
                // check that the service is do in this date
                if($service->checkIfIsDo($date)){
                    // what to add all the reports or only the ones that are missing for $date
                    if($AddCompletedReports){
                        // add all reports that are do
                        return true;
                    }else{
                        // check that the report is missing in the $date
                        if(!$service->checkIfIsDone($date)){
                            return true;
                        }
                    }
                }
                return false;
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

    // ******************************
    //******** RELATIONSHIPS ********
    // ******************************

// Feature Relationships


    public function userRoleCompaniesByRole(...$roles)
    {
        return $this->userRoleCompanies()
                ->join('roles', function ($join) use ($roles){
                    $join->on('user_role_company.role_id', '=', 'roles.id')
                            ->whereIn('roles.name', $roles);
                });
    }

    public function userRoleCompaniesByRoleWherePaid($roles, $paid)
    {
        return $this->userRoleCompaniesByRole($roles)->where('paid', $paid);
    }

    /**
     * Get userRoleCompany ordered by seq_id
     * @param  string $order    asc or desc
     */
    public function userRoleCompaniesByRoleInOrder($roles, $order = 'asc')
    {
        return $this->userRoleCompaniesByRole($roles)->orderBy('seq_id', $order);
    }

    /**
     * Get userRoleCompany accacited with this user and seq_id convination
     * @param  int $seq_id
     */
    public function userRoleCompanyBySeqId($seq_id){
        return $this->userRoleCompanies()
                    ->where('user_role_company.seq_id', '=', $seq_id)
                    ->firstOrFail();
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
     * Get the payments based on the seq_id
     * @param  integer $seq_id
     * @return App\Payment
     */
    public function paymentsBySeqId($seq_id){
        return $this->payments()
                    ->where('payments.seq_id', '=', $seq_id)
                    ->firstOrFail();
    }

    public function missingHistoriesByDate(Carbon $date)
    {
        $date_str = $date->toDateTimeString();
        return $this->missingHistories()
                        ->whereDate('date', $date_str)
                        ->first();
    }

    // Basic Relationships

    public function userRoleCompanies()
    {
        return $this->hasMany(UserRoleCompany::class);
    }

    public function permissionRoleCompany()
    {
        return $this->hasMany(PermissionRoleCompany::class);
    }

    /**
     *  Get services associated with this user
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Get reports associatod with this user
     */
    public function reports(){
        return $this->hasManyThrough(Report::class, Service::class);
    }

    /**
     *  Get services associated with this user
     * @param boolean
     * @return Collection
     * tested
     */
    public function workOrders(){
        return $this->hasManyThrough(WorkOrder::class, Service::class);
    }

    /**
     * Get invoices associated with this user
     */
    public function invoices()
    {
        return Invoice::where('company_id', $this->id);
    }

    /**
     * Get invoices associated with this user
     */
    public function payments()
    {
        return Payment::join('invoices', 'invoices.id', '=', 'payments.invoice_id')
                    ->where('company_id', '=', $this->id)
                    ->select('payments.*');
    }

    public function missingHistories()
    {
        return $this->hasMany(MissingHistory::class);
    }

}
