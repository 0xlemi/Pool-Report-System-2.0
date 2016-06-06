<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Intervention;

use App\PRS\Helpers\ServiceHelpers;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Service extends Model
{
    /**
     * variables that can be mass assign
     * @var array
     */
    protected $fillable = [
        'name',
        'address_line',
        'city',
        'state',
        'postal_code',
        'country',
        'type',
        'service_days',
        'amount',
        'currency',
        'start_time',
        'end_time',
        'status',
        'comments',
        'admin_id',
    ];


    /**
     * hidden variables
     * @var array
     */
    protected $hidden = [
        'admin_id',
    ];

    /**
	 * Get the associated Administrator with this service
	 * tested
	 */
    public function admin(){
    	return $this->belongsTo('App\Administrator')->first();
    }

    /**
     * Get the associated clients with this service
     * tested
     */
    public function clients(){
    	return $this->belongsToMany('App\Client');
    }

    /**
     * Get associated reports with this service
     * tested
     */
    public function reports(){
    	return $this->hasMany('App\Report');
    }

    /**
     * get the service days as a boolean for each day insted of the number
     * @return array
     * tested
     */
    public function service_days_by_day(){
        $serviceHelpers = \App::make('App\PRS\Helpers\ServiceHelpers');
        return $serviceHelpers->num_to_service_days($this->service_days);
    }

    /**
     * add a image from form information
     */
    public function addImageFromForm(UploadedFile $file){
        //generate image names
        $name = get_random_name('normal_'.$this->id, $file->guessExtension());
        $name_thumbnail = get_random_name('tn_'.$this->id, $file->guessExtension());
        $name_icon = get_random_name('xs_'.$this->id, $file->guessExtension());

        // save normal image in folder
        $file->move(public_path( env('FOLDER_IMG').'service/' ), $name);

        // make and save thumbnail
        $img = Intervention::make(public_path( env('FOLDER_IMG').'service/'.$name));
        $img->fit(300)->save(public_path( env('FOLDER_IMG').'service/'.$name_thumbnail));

         // make and save icon
        $img->fit(64)->save(public_path( env('FOLDER_IMG').'service/'.$name_icon));

        // add image
        $image = new Image;
        $image->normal_path = env('FOLDER_IMG').'service/'.$name;
        $image->thumbnail_path = env('FOLDER_IMG').'service/'.$name_thumbnail;
        $image->icon_path = env('FOLDER_IMG').'service/'.$name_icon;

        // presist image to the database
        return $this->addImage($image);
    }

    /**
     * Add a image to this service
     * tested
     */
    public function addImage(Image $image){
        return $this->images()->save($image);
    }

    /**
     * Associated reports with this service
     * tested
     */
    public function images(){
        return $this->hasMany('App\Image');
    }

    /**
     * get the number of images this service has
     * tested
     */
    public function numImages(){
        return $this->hasMany('App\Image')->count();
    }

    /**
     * get full size image
     * tested
     */
    public function image(){
        if($this->numImages() > 0){
            return $this->hasMany('App\Image')
                ->first()->normal_path;
        }
        return 'img/no_image.png';
    }

    /**
     * get thumbnail image
     * tested
     */
    public function thumbnail(){
        if($this->numImages() > 0){
            return $this->hasMany('App\Image')
                ->first()->thumbnail_path;
        }
        return 'img/no_image.png';
    }

    /**
     * Get the extra small Image
     * tested
     */
    public function icon(){
        if($this->numImages() > 0){
            return $this->hasMany('App\Image')
                ->first()->icon_path;
        }
        return 'img/avatar-2-48.png';
    }
}
