<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Intervention;

use App\PRS\Traits\Model\ImageTrait;
use App\PRS\Traits\Model\SortableTrait;
use App\Chemical;
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

    /**
     * Get associated ServiceContract with this service
     */
    public function chemicals()
    {
        return $this->hasMany(Chemical::class);
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
