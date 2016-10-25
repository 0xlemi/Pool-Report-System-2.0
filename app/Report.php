<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Intervention;
use Mail;

use Carbon\Carbon;
use App\PRS\Traits\Model\ImageTrait;
use App\PRS\Classes\ValueObjects\Report\OnTime;
use App\Client;
use App\Image;
use App\Mail\ServiceReportMail;
class Report extends Model
{
    use ImageTrait;

    /**
     * variables that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'service_id',
        'technician_id',
        'completed',
        'on_time',
        'ph',
        'chlorine',
        'temperature',
        'turbidity',
        'salt',
        'latitude',
        'longitude',
        'accuracy',
    ];


    //******** RELATIONSHIPS ********

    /**
     * associated service with this report
     * tested
     */
    public function service(){
    	return $this->belongsTo('App\Service')->first();
    }

    /**
     * associated clients with this report
     * tested
     */
    public function clients(){
        return $this->service()->clients();
    }

    /**
     * associated clients with this report
     * tested
     */
    public function admin()
    {
        return $this->service()->admin();
    }

    /**
     * associated supervisor with this report
     */
    public function supervisor()
    {
        return $this->technician()->supervisor();
    }

    /**
     * associated technician with this report
     * tested
     */
    public function technician(){
    	return $this->belongsTo('App\Technician')->first();
    }


    //******** VALUE OBJECTS ********

    public function onTime()
    {
        return (new OnTime($this->on_time));
    }

    public function ph()
    {

    }

    public function chlorine()
    {

    }

    public function temperature()
    {

    }

    public function turbidity()
    {

    }

    public function salt()
    {

    }


    //******** MISCELLANEOUS ********

    public function getEmailImage(Client $client = null)
    {
        // delete email preview photos
        array_map('unlink', glob(public_path('storage/images/emails/*')));

        $fileName = 'email_'.str_random(25).'.jpg';
        $img_path = public_path('storage/images/emails/'.$fileName);

        // info needed by the template
        $logo = url('img/logo-2.png');
        $headerImage = url('img/uploads/email_header.png');
        $name = "client_name";
        if($client){
            $name = $client->name;
        }

        $address = $this->service()->address_line;
        $time = (new Carbon($this->completed, 'UTC'))
                    ->setTimezone($this->admin()->timezone)
                    ->toDayDateTimeString();

        $unsubscribeLink = '#';
        $photo1 = url($this->image(1));
        $photo2 = url($this->image(2));
        $photo3 = url($this->image(3));

        //convert template with info to image
        $result = \ImageHTML::loadHTML(
                    view(
                        'emails.serviceReport',
                        compact('logo', 'headerImage', 'name','address','time', 'unsubscribeLink', 'photo1','photo2','photo3')
                    )
                )->save($img_path);

        if($result){
            return url('storage/images/emails/'.$fileName);
        }
        return false;
    }

}
