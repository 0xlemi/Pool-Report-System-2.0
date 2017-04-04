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
use App\PRS\ValueObjects\Report\Reading;
use App\PRS\ValueObjects\Report\Turbidity;
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
        'ph',
        'chlorine',
        'temperature',
        'turbidity',
        'salt',
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

    //******** VALUE OBJECTS ********

    public function completed()
    {
        return (new Carbon($this->completed, 'UTC'))->setTimezone($this->company->timezone);
    }

    public function onTime()
    {
        return new OnTime($this->on_time);
    }

    public function ph()
    {
        return new Reading($this->ph, $this->company->tags()->ph());
    }

    public function chlorine()
    {
        return new Reading($this->chlorine, $this->company->tags()->chlorine());
    }

    public function temperature()
    {
        return new Reading($this->temperature, $this->company->tags()->temperature());
    }

    public function turbidity()
    {
        return new Turbidity($this->turbidity, $this->company->tags()->turbidity());
    }

    public function salt()
    {
        return new Reading($this->salt, $this->company->tags()->salt());
    }


}
