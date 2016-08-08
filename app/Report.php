<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Intervention;
use Mail;

use Carbon\Carbon;
use App\PRS\Traits\Model\ImageTrait;
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
        'service_id',
        'technician_id',
        'completed',
        'on_time',
        'ph',
        'clorine',
        'temperature',
        'turbidity',
        'salt',
        'latitude',
        'longitude',
        'altitude',
        'accuracy',
    ];

    /**
     * associated service with this report
     * tested
     */
    public function service(){
    	return $this->belongsTo('App\Service')->first();
    }

    public function clients(){
        return $this->service()->clients();
    }

    /**
     * associated technician with this report
     * tested
     */
    public function technician(){
    	return $this->belongsTo('App\Technician')->first();
    }

    public function getEmailImage(Client $client = null)
    {
        $template_path = base_path('resources/views/templates/email.blade.php');

        // delete email preview photos
        array_map('unlink', glob(public_path('storage/images/emails/*')));

        // get the html of the design email and put it on the template
        $content = file_get_contents(resource_path('emails/report_email.html'));
        file_put_contents($template_path, $content);

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
        $time = (new Carbon($this->completed))->toDayDateTimeString();
        $photo1 = url($this->image(1));
        $photo2 = url($this->image(2));
        $photo3 = url($this->image(3));

        //convert template with info to image
        $result = \ImageHTML::loadHTML(
                    view(
                        'templates.email',
                        compact('logo', 'headerImage', 'name','address','time','photo1','photo2','photo3')
                    )
                )->save($img_path);

        if($result){
            return url('storage/images/emails/'.$fileName);
        }
        return false;
    }

    public function sendEmailAllClients()
    {
        $clients = $this->clients()->get();
        foreach ($clients as $client) {
            // check if the email preference
            if($client->get_reports_emails){
                $this->sendEmail($client->name, $client->user()->email);
            }
        }
    }

    public function sendEmailSupervisor()
    {
        $supervisor = $this->technician()->supervisor();
        if($supervisor->get_reports_emails){
            $this->sendEmail($supervisor->name, $supervisor->user()->email);
        }
    }

    public function sendEmail(string $name, string $email)
    {
        $template_path = base_path('resources/views/templates/email.blade.php');

        // get the html of the design email and put it on the template
        $content = file_get_contents(resource_path('emails/report_email.html'));
        file_put_contents($template_path, $content);

        // info needed by the template
        $data = array(
            'logo' => url('img/logo-2.png'),
            'headerImage' => url('img/uploads/email_header.png'),
            'name' => $name,
            'address' => $this->service()->address_line,
            'time' => (new Carbon($this->completed))->toDayDateTimeString(),
            'photo1' => url($this->image(1)),
            'photo2' => url($this->image(2)),
            'photo3' => url($this->image(3)),
        );

        return  Mail::send('templates.email', $data, function ($message) use ($name, $email){
            $message->from('service@poolreportsystem.com', 'Pool Report System');
            $message->subject('Your pool is clean '.$name);
            $message->to($email);
        });
    }

}
