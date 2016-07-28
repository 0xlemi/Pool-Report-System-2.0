<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Intervention;

use Carbon\Carbon;
use App\Client;
use App\Image;
class Report extends Model
{

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
        $name = "client_name";
        if($client){
            $name = $client->name;
        }
        $address = $this->service()->address_line;
        $time = (new Carbon($this->completed))->toDayDateTimeString();
        $photo1 = url($this->image(1)->normal_path);
        $photo2 = url($this->image(2)->normal_path);
        $photo3 = url($this->image(3)->normal_path);

        //convert template with info to image
        $result = \ImageHTML::loadHTML(
                    view(
                        'templates.email',
                        compact('name','address','time','photo1','photo2','photo3')
                    )
                )->save($img_path);

        if($result){
            return url('storage/images/emails/'.$fileName);
        }
        return false;
    }

    /**
     * Add image from form information
     */
    public function addImageFromForm(UploadedFile $file){
        //generate image names
        $name = get_random_name('normal_'.$this->id, $file->guessExtension());
        $name_thumbnail = get_random_name('tn_'.$this->id, $file->guessExtension());

        // save normal image in folder
        $file->move(public_path( env('FOLDER_IMG').'report/' ), $name);

        // make and save thumbnail
        $img = Intervention::make(public_path( env('FOLDER_IMG').'report/'.$name));
        $img->fit(300)->save(public_path( env('FOLDER_IMG').'report/'.$name_thumbnail));

        // add image
        $image = new Image;
        $image->normal_path = env('FOLDER_IMG').'report/'.$name;
        $image->thumbnail_path = env('FOLDER_IMG').'report/'.$name_thumbnail;
        $image->order = $this->numImages() + 1;

        // presist image to the database
        return $this->addImage($image);
    }

    /**
     * Add images to this report
     * tested
     */
    public function addImage(Image $image){
        return $this->images()->save($image);
    }

    /**
     * associated images with this report
     * tested
     */
    public function images(){
        return $this->hasMany('App\Image');
    }

    /**
     * Get the image by the order num
     * tested
     */
    public function image($order){
        return $this->hasMany('App\Image')
            ->where('order', '=', $order)
            ->first();
    }

    /**
     * Get the number of images associated with this report
     * @return integer
     * tested
     */
    public function numImages(){
        return $this->hasMany('App\Image')->count();
    }

}
