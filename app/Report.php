<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Intervention;
use Mail;

use Carbon\Carbon;
use App\PRS\Traits\Model\ImageTrait;
use App\PRS\Traits\Model\SortableTrait;
use App\PRS\ValueObjects\Report\OnTime;
use App\Reading;
use App\UserRoleCompany;
use App\Client;
use App\Image;
class Report extends Model
{
    use ImageTrait;
    use SortableTrait;

    /**
     * variables that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'user_role_company_id',
        'completed',
        'on_time',
        'latitude',
        'longitude',
        'altitude',
        'accuracy',
    ];


    // ******************************
    //            Scopes
    // ******************************


    public function scopeBySeqId($query, $seqId)
    {
        return $query->where('reports.seq_id', $seqId)->firstOrFail();
    }

    public function scopeInDate($query, $strDate)
    {
		$query->whereDate(\DB::raw('CONVERT_TZ(completed,\'UTC\',\''.$company->timezone.'\')'), $strDate);
    }

    //******** RELATIONSHIPS ********

    /**
     * associated service with this report
     */
    public function service(){
    	return $this->belongsTo('App\Service');
    }

    /**
     * associated clients with this report
     */
    public function company()
    {
        return $this->service->company();
    }

    // check that this not done by clients
    public function userRoleCompany()
    {
        return $this->belongsTo(UserRoleCompany::class);
    }

    public function readings()
    {
        return $this->hasMany(Reading::class);
    }

    //******** VALUE OBJECTS ********

    public function completed()
    {
        return (new Carbon($this->completed, 'UTC'))->setTimezone($this->company->timezone);
    }

    public function onTime()
    {
        return new OnTime($this->on_time);
    }


}
