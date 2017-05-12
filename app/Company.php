<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\PRS\Traits\Model\ImageTrait;
use App\PRS\Traits\Model\BillableTrait;

use App\PRS\ValueObjects\Administrator\Tags;
use App\PRS\ValueObjects\Administrator\Permissions;
use App\PRS\ValueObjects\Administrator\TagTurbidity;
use App\PRS\ValueObjects\Administrator\Tag;

use App\Invoice;
use App\Payment;
use App\Service;
use App\MissingHistory;
use App\GlobalMeasurement;

use DB;
use App\GlobalProduct;
use App\Permission;
use App\WorkOrder;
use App\Report;
use App\Role;
use App\UserRoleCompany;
use App\PermissionRoleCompany;

use Carbon\Carbon;

class Company extends Model
{

    use ImageTrait;
    use BillableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'website',
        'facebook',
        'twitter',
        'timezone',
        'language',
        'latitude',
        'longitude',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'free_objects',
        'stripe_id',
        'card_brand',
        'card_last_four',
        'trial_ends_at'
    ];


    //******** VALUE OBJECTS ********



    //******** MISCELLANEOUS ********


    public function allPermissions(...$roles)
    {
        $permissions = $this->permissionRoleCompanies()
                                    ->ofRole(...$roles)
                                    ->permissions()
                                    ->get()
                                    ->transform(function ($item) use ($roles){
                                        $role = (count($roles) == 1)? $roles[0]: $roles;
                                        return [
                                            'id' => $item->id,
                                            'element' => $item->element,
                                            'action' => $item->action,
                                            'text' => $item->text,
                                            'role' => $role,
                                        ];
                                    });
        return Permission::all()->transform(function($item) use ($permissions, $roles){
            $value = false;
            if($permissions->where('element', $item->element)->contains('action', $item->action)){
                $value = true;
            }
            $role = (count($roles) == 1)? $roles[0]: $roles;
            return [
                'id' => $item->id,
                'element' => $item->element,
                'action' => $item->action,
                'text' => $item->text,
                'value' => $value,
                'role' => $role,
            ];
        })->groupBy('element');
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

        return $this->services()->withActiveContract()->get()
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

    // ******************************
    //        RELATIONSHIPS
    // ******************************

    /**
     * Get the reports in this date
     * @param  Carbon $date date is Administrator timzone
     * tested
     */
    public function reportsByDate(Carbon $date){
        $date_str = $date->toDateTimeString();
        return $this->reports()
			        ->whereDate(\DB::raw('CONVERT_TZ(completed,\'UTC\',\''.$this->timezone.'\')'), $date_str)
                    ->orderBy('seq_id');
    }

    public function userRoleCompanies()
    {
        return $this->hasMany(UserRoleCompany::class);
    }

    public function permissionRoleCompanies()
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
        return $this->hasManyThrough(Report::class, Service::class)->select('reports.*');
    }

    /**
     *  Get services associated with this user
     * @param boolean
     * @return Collection
     * tested
     */
    public function workOrders(){
        return $this->hasManyThrough(WorkOrder::class, Service::class)->select('work_orders.*');
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

    public function globalMeasurements()
    {
        return $this->hasMany(GlobalMeasurement::class);
    }

    public function globalProducts()
    {
        return $this->hasMany(GlobalProduct::class);
    }

    public function missingHistories()
    {
        return $this->hasMany(MissingHistory::class);
    }

}
