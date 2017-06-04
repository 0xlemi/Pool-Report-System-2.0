<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\PRS\Traits\Model\SortableTrait;
use App\PRS\Traits\Model\ImageTrait;
use App\Work;
use App\Report;
use App\Role;
use App\User;
use App\Company;
use App\Service;
use App\WorkOrder;
use App\UrlSigner;
use App\UserRoleCompany;
use App\NotificationSetting;
use Carbon\Carbon;
use DB;

class UserRoleCompany extends Model
{

    use SortableTrait;
    use ImageTrait;
    use Notifiable;

	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_role_company';

	/**
     * variables that can be mass assign
     * @var array
     */
    protected $fillable = [
        'type',
        'cellphone',
        'address',
        'about',
		'user_id',
		'role_id',
		'company_id',
	];

    public function isRole(...$roles)
    {
		$roleName = $this->role->name;
		foreach ($roles as $role) {
        	if ($roleName == $role){
				return true;
			}
		}
    }

	public function hasPermission($element, $action)
	{
        if($permissionsFromCompany = $this->role->permissionsFromCompany($this->company)){
            return $permissionsFromCompany->where('element', $element)
                            ->get()
                            ->contains('action', $action);
        }
	}

    public function hasNotificationSetting($name, $type)
    {
        return $this->notificationSettings->where('name', $name)->contains('type', $type);
    }

    public function allNotificationSettings()
    {
        $urcNotifications = $this->notificationSettings()->select('name', 'type')->get();
        return NotificationSetting::all()->transform(function($setting) use ($urcNotifications){
            $value = false;
            if($urcNotifications->where('name', $setting->name)->contains('type', $setting->type)){
                $value = true;
            }
            return [
                'name' => $setting->name,
                'type' => $setting->type,
                'text' => $setting->text,
                'value' => $value,
            ];
        })->groupBy('name');
    }


	// ********************************
    //        Client only Methods
	// ********************************


/**
	 * Checks if client has service with this $seq_id
	 * @param  integer  $seq_id
	 * @return boolean
	 */
	public function hasService($seq_id)
	{
		return $this->services->contains('seq_id', $seq_id);
	}

	/**
	 * set services with an array of seq_ids
	 * @param array $seq_ids
	 */
	public function setServices(array $seq_ids)
	{
	    foreach ($seq_ids as $seq_id) {
			if($service = $this->company->services()->bySeqId($seq_id)){
				$service_id = $service->id;
				if(!$this->hasService($seq_id)){
					$this->services()->attach($service_id);
				}
			}
	    }
	}

	/**
	 * remove services with an array of seq_ids
	 * @param array $seq_ids
	 */
	public function unsetServices(array $seq_ids)
	{
	    foreach ($seq_ids as $seq_id) {
			if($service = $this->company->services()->bySeqId($seq_id)){
				$service_id = $service->id;
				if($this->hasService($seq_id)){
					$this->services()->detach($service_id);
				}
			}
	    }
	}

    /**
     * Update the services associated with this URC from array of seqIds
     * @param  array  $seq_id
     * @return  boolean
     */
    public function syncServices(array $seq_id)
    {
        $services = $this->company->services()->whereIn('services.seq_id', $seq_id)->get();
        $serviceIds = $services->pluck('id');
        return $this->services()->sync($serviceIds);
    }


	// ***********************
	//       Attributes
	// ***********************



    // ******************************
    //            Scopes
    // ******************************


    public function scopeBySeqId($query, $seqId)
    {
        return $query->where('user_role_company.seq_id', $seqId)->firstOrFail();
    }

    public function scopeOfRole($query, ...$roles)
    {
        $rolesIds = Role::whereIn('name', $roles)->pluck('id');
        return $query->whereIn('role_id', $rolesIds);
    }

    public function scopePaid($query, $paid)
    {
        return $query->where('paid', $paid);
    }

    // **********************
    //     RELATIONSHIPS
    // **********************

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

	// this is intended for clients
	public function services()
    {
        return $this->belongsToMany(Service::class , 'urc_service', 'urc_id', 'service_id');
    }

    // reports he has created
    public function reports()
    {
    	return $this->hasMany(Report::class);
    }

    // workOrder he has created
    public function workOrders()
    {
    	return $this->hasMany(WorkOrder::class);
    }

    public function works()
    {
    	return $this->hasMany(Work::class);
    }

    public function notificationSettings()
    {
        return $this->belongsToMany(NotificationSetting::class , 'urc_notify_setting', 'urc_id', 'notify_setting_id');
    }

    public function urlSigners()
    {
        return $this->hasMany(UrlSigner::class);
    }

    public function verificationToken()
    {
        return $this->hasOne(VerificationToken::class);
    }


	// public function getTypeAttribute()
    // {
    //     return new Type($this->userable_type);
    // }

    // *************************
    //   Clients Methods
    // ***************************

    /**
     * Get the reports this URC has for this date
     * @param  Carbon $date  is in Company Timezone
     * @return Collection       of Reports
     */
    public function reportsByDate(Carbon $date)
    {
        $dateStr = $date->toDateString();
        $timezone = $this->company->timezone;
        $reportsIdArray = $this->services()->join('reports', function ($join) use ($dateStr, $timezone){
            $join->on('services.id', '=', 'reports.service_id')
			->whereDate(\DB::raw('CONVERT_TZ(completed,\'UTC\',\''.$timezone.'\')'), $dateStr);
        })->select('reports.id')->get()->pluck('id')->toArray();

		return Report::find($reportsIdArray);
    }

    /**
     * Get all dates that have at least one report in them
     * @return Collection
     */
    public function datesWithReport()
    {
        $timezone = $this->company->timezone;
        $reportsIdArray = $this->services()->join('reports', 'services.id', '=', 'reports.service_id')
                        ->select('reports.id')
                        ->get()
                        ->pluck('id')->toArray();
		$reports  = Report::whereIn('id', $reportsIdArray);
        return $reports->get()
                    ->pluck('completed')
                    ->transform(function ($item) use ($timezone){
                        $date = (new Carbon($item, 'UTC'))->setTimezone($timezone);
                        return $date->toDateString();
                    })
                    ->unique()
                    ->flatten();
    }


    // workorders of the services this urc has as a client
	public function clientWorkOrders()
	{
		$workOrdersIdArray = $this->services()
				->join('work_orders', 'services.id', '=', 'work_orders.service_id')
				->select('work_orders.id')->get()->pluck('id')->toArray();

		return WorkOrder::whereIn('id', $workOrdersIdArray);
	}

    //
	// public function hasWorkOrder($seq_id)
	// {
	// 	return $this->workOrders()->get()->contains('seq_id', $seq_id);
	// }
    //

	// public function equipment()
	// {
	// 	$equipmentIdArray = $this->services()
	// 			->join('equipment', 'services.id', '=', 'equipment.service_id')
	// 			->select('equipment.id')->get()->pluck('id')->toArray();
    //
	// 	return Equipment::whereIn('id', $equipmentIdArray)->orderBy('id', 'asc');
	// }
    //
	// public function hasEquipment($id)
	// {
	// 	return $this->equipment()->get()->contains('id', $id);
	// }


}
