<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Intervention;

use App\PRS\Traits\Model\ImageTrait;
use App\PRS\Traits\Model\SortableTrait;
use App\Product;
use App\Measurement;
use App\ServiceContract;
use App\UserRoleCompany;

use Carbon\Carbon;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Service extends Model
{
    use ImageTrait;
    use SortableTrait;

    /**
     * variables that can be mass assign
     * @var array
     */
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'address_line',
        'city',
        'state',
        'postal_code',
        'country',
        'comments',
    ];


    /**
     * hidden variables
     * @var array
     */
    protected $hidden = [
        'admin_id',
    ];


    // ******************************
    //            Scopes
    // ******************************


    public function scopeBySeqId($query, $seqId)
    {
        return $query->where('services.seq_id', $seqId)->firstOrFail();
    }

    /**
     * Get all the services where there is an active contract
     */
    public function scopeWithActiveContract($query)
    {
        $serviceArray = $query->join('service_contracts', function ($join) {
                $join->on('services.id', '=', 'service_contracts.service_id')
                     ->where('service_contracts.active', '=', 1);
            })->select('services.id')->get()->toArray();

		return Service::whereIn('id', $serviceArray);
    }

    /**
     * THIS NEEDS TO BE CHECHED
	 * Get all the services that have no contract or the contract that they have is inactive
	 */
    public function scopeWithoutActiveContract($query)
    {
        // First we get all the clients with or with out service Contract
		// we select relevant information like service_contracts.service_id which is gonig to be null if that service has no contract
		// the service.id which is the id of the service all the time
		// and active because we also want to return the services with a contract that is inactive
        $serviceArray = $query->leftJoin('service_contracts', 'services.id', '=', 'service_contracts.service_id')
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

    // ******************************
    //         RELATIONSHIPS
    // ******************************

    /**
	 * Get the associated Company with this service
	 */
    public function company(){
    	return $this->belongsTo('App\Company');
    }

    // this should be clients only
    public function userRoleCompanies()
    {
        return $this->belongsToMany(UserRoleCompany::class , 'urc_service', 'service_id', 'urc_id');
    }

    /**
     * Get associated reports with this service
     */
    public function reports(){
    	return $this->hasMany('App\Report');
    }

    /**
     * Get associated equipment with this service
     */
    public function equipment(){
    	return $this->hasMany('App\Equipment');
    }

    /**
     * Get associated ServiceContract with this service
     */
    public function serviceContract()
    {
        return $this->hasOne(ServiceContract::class);
    }

    public function hasServiceContract()
    {
        return ($this->serviceContract()->get()->count() > 0);
    }

    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get associated work orders with this service
     */
    public function workOrders(){
    	return $this->hasMany('App\WorkOrder');
    }

    public function hasWorkOrders()
    {
        return ($this->workOrders()->get()->count() > 0);
    }


    //******** MISCELLANEOUS ********

    /**
     * check if this service is scheduled for a date
     * @param  Carbon $date is in Administrator timezone
     * @return boolean
     */
    public function checkIfIsDo(Carbon $date)
    {
        $dayToCheck = strtolower($date->format('l'));
        return $this->serviceContract->serviceDays()->asArray()[$dayToCheck];
    }

    /**
     * check if there is a single report for this service already done in a date
     * @param  Carbon $date is in Administrator timezone
     * @return boolean
     */
    public function checkIfIsDone(Carbon $date)
    {
        $company = $this->company;
        $strDate = $date->toDateTimeString();
        $count = $this->reports()
                ->where(\DB::raw('DATEDIFF(CONVERT_TZ(completed,\'UTC\',\''.$company->timezone.'\'), "'.$strDate.'")'), '=', '0')
                ->count();
        if($count > 0){
            return true;
        }
        return false;
    }

}
