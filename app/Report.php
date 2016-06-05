<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Intervention;

use Carbon\Carbon;
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
