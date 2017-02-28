<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Intervention;
use Carbon\Carbon;

use App\Administrator;
use App\PRS\Traits\Model\ImageTrait;
use App\WorkOrder;
use App\Report;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Client extends Model
{
	use ImageTrait;

	/**
	 * variables that can be mass assign
	 * @var array
	 */
	protected $fillable = [
		'name',
		'last_name',
		'cellphone',
		'type',
		'language',
		'comments',
		'admin_id',
	];

    /**
     * hidden variables
     * @var array
     */
	protected $hidden = [
		'password',
		'admin_id',
	];

	/**
	 * Get the admin
	 * tested
	 * @return Administartor
	 */
	public function admin()
	{
	    return Administrator::findOrFail($this->admin_id);
	}

	/**
	 * Gets client morphed user
	 * @return $User
	 * tested
	 */
	public function user()
    {
      return $this->morphOne('App\User', 'userable');
    }

	public function datesWithReport()
	{
		$admin = $this->admin();
		return $this->services()
				->join('reports', 'services.id', '=', 'reports.service_id')
				->select('reports.completed')
                ->get()
                ->pluck('completed')
                ->transform(function ($item) use ($admin){
                    $date = (new Carbon($item, 'UTC'))->setTimezone($admin->timezone);
                    return $date->toDateString();
                })
                ->unique()
                ->flatten();
				;
	}


	public function reportsByDate(Carbon $date)
	{
        $date_str = $date->toDateTimeString();
		$timezone = $this->admin()->timezone;
		$reportsIdArray = $this->services()->join('reports', function ($join) use ($timezone, $date_str){
            $join->on('services.id', '=', 'reports.service_id')
			->where(\DB::raw('DATEDIFF(CONVERT_TZ(completed,\'UTC\',\''.$timezone.'\'), "'.$date_str.'")'), '=', '0');
        })->select('reports.id')->get()->pluck('id')->toArray();

		return Report::find($reportsIdArray);
	}

	public function workOrders()
	{
		$workOrdersIdArray = $this->services()
			->join('work_orders', 'services.id', '=', 'work_orders.service_id')
			->select('work_orders.id')->get()->pluck('id')->toArray();

			return WorkOrder::find($workOrdersIdArray);
	}

	/*
	 * associated services with this client
	 * tested
	 */
    public function services(){
    	return $this->belongsToMany('App\Service');
    }

	/**
	 * Checks if client has service with this $seq_id
	 * tested
	 * @param  integer  $seq_id
	 * @return boolean
	 */
	public function hasService($seq_id)
	{
		return $this->services()->get()->contains('seq_id', $seq_id);
	}

	/**
	 * set services with an array of seq_ids
	 * tested
	 * @param array $seq_ids
	 */
	public function setServices(array $seq_ids)
	{
	    foreach ($seq_ids as $seq_id) {
			if($service = $this->admin()->serviceBySeqId($seq_id)){
				$service_id = $service->id;
				if(!$this->hasService($seq_id)){
					$this->services()->attach($service_id);
				}
			}
	    }
	}

	/**
	 * remove services with an array of seq_ids
	 * tested
	 * @param array $seq_ids
	 */
	public function unsetServices(array $seq_ids)
	{
	    foreach ($seq_ids as $seq_id) {
			if($service = $this->admin()->serviceBySeqId($seq_id)){
				$service_id = $service->id;
				if($this->hasService($seq_id)){
					$this->services()->detach($service_id);
				}
			}
	    }
	}




}
