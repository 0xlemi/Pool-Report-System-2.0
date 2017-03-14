<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Intervention;
use Mail;

use Carbon\Carbon;
use App\PRS\Traits\Model\ImageTrait;
use App\PRS\ValueObjects\Report\OnTime;
use App\PRS\ValueObjects\Report\Reading;
use App\PRS\ValueObjects\Report\Turbidity;
use App\Client;
use App\Image;
class Report extends Model
{
    use ImageTrait;

    /**
     * variables that can be mass assigned
     * @var array
     */
    protected $fillable = [
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
        'altitude',
        'accuracy',
    ];


    //******** RELATIONSHIPS ********

    /**
     * associated service with this report
     * tested
     */
    public function service(){
    	return $this->belongsTo('App\Service');
    }

    /**
     * associated clients with this report
     * tested
     */
    public function clients(){
        return $this->service->clients();
    }

    /**
     * associated clients with this report
     * tested
     */
    public function admin()
    {
        return $this->service->admin();
    }

    /**
     * associated supervisor with this report
     */
    public function supervisor()
    {
        return $this->technician->supervisor;
    }

    /**
     * associated technician with this report
     * tested
     */
    public function technician(){
    	return $this->belongsTo('App\Technician');
    }


    //******** VALUE OBJECTS ********

    public function completed()
    {
        return (new Carbon($this->completed, 'UTC'))->setTimezone($this->admin()->timezone);
    }

    public function onTime()
    {
        return new OnTime($this->on_time);
    }

    public function ph()
    {
        return new Reading($this->ph, $this->admin()->tags()->ph());
    }

    public function chlorine()
    {
        return new Reading($this->chlorine, $this->admin()->tags()->chlorine());
    }

    public function temperature()
    {
        return new Reading($this->temperature, $this->admin()->tags()->temperature());
    }

    public function turbidity()
    {
        return new Turbidity($this->turbidity, $this->admin()->tags()->turbidity());
    }

    public function salt()
    {
        return new Reading($this->salt, $this->admin()->tags()->salt());
    }


    //******** MISCELLANEOUS ********

    public function getEmailImage(Client $client = null)
    {
        // delete email preview photos
        array_map('unlink', glob(public_path('storage/images/emails/*')));

        $fileName = 'email_'.str_random(25).'.jpg';
        $img_path = public_path('storage/images/emails/'.$fileName);

        // info needed by the template
        $logo = Storage::url('images/assets/app/logo-2.png');
        $headerImage = Storage::url('images/assets/email/email_header.png');
        $name = "client_name";
        if($client){
            $name = $client->name;
        }

        $address = $this->service->address_line;
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
