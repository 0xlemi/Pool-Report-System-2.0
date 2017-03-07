<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Intervention;
use Carbon\Carbon;

use App\Administrator;
use App\PRS\Traits\Model\ImageTrait;
use App\Work;
use App\Service;
use App\WorkOrder;
use App\Equipment;
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
		return $this->belongsTo('App\Administrator', 'admin_id')->first();
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

	public function workOrders($order = 'desc')
	{
		$workOrdersIdArray = $this->services()
				->join('work_orders', 'services.id', '=', 'work_orders.service_id')
				->select('work_orders.id')->get()->pluck('id')->toArray();

		return WorkOrder::whereIn('id', $workOrdersIdArray)->orderBy('seq_id', $order);
	}

	public function workOrdersFinished($finished = true)
	{
		$sign = '=';
		if($finished){
			$sign = '!=';
		}
		$workOrdersIdArray = $this->services()
			->join('work_orders', function ($join) use ($sign){
	            $join->on('services.id', '=', 'work_orders.service_id')
				->where('work_orders.end', $sign, null);
        	})->select('work_orders.id')->get()->pluck('id')->toArray();

		return WorkOrder::whereIn('id', $workOrdersIdArray)->orderBy('seq_id', 'desc');
	}

	public function hasWorkOrder($seq_id)
	{
		return $this->workOrders()->get()->contains('seq_id', $seq_id);
	}

	public function works()
	{
		// I Cannot do a join over whereIn

		// $workIdArray = $this->workOrders()
		// 		->join('works', 'work_orders.id', '=', 'works.work_order_id')->get();
		// 		// ->select('works.id');
		//
		// dd($workIdArray);
		// // return Work::whereIn('id', $workIdArray)->orderBy('id', 'asc');
	}

	// public function hasWork($id)
	// {
	// 	return $this->works()->get()->contains('id', $id);
	// }

	/*
	 * associated services with this client
	 * tested
	 */
    public function services(){
    	return $this->belongsToMany('App\Service');
    }

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
	 * Checks if client has service with this $seq_id
	 * tested
	 * @param  integer  $seq_id
	 * @return boolean
	 */
	public function hasService($seq_id)
	{
		return $this->services()->get()->contains('seq_id', $seq_id);
	}

	public function equipment()
	{
		$equipmentIdArray = $this->services()
				->join('equipment', 'services.id', '=', 'equipment.service_id')
				->select('equipment.id')->get()->pluck('id')->toArray();

		return Equipment::whereIn('id', $equipmentIdArray)->orderBy('id', 'asc');
	}

	public function hasEquipment($id)
	{
		return $this->equipment()->get()->contains('id', $id);
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
