<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Intervention;

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
        'user_id',
    ];


    /**
     * hidden variables
     * @var array
     */
    protected $hidden = [
        'user_id',
    ];

    /**
     * get the service days as a boolean for each day insted of the number
     * @return array
     */
    public function service_days_by_day(){
        $num = $this->service_days;
        $sunday     = false;
        $saturday   = false;
        $friday     = false;
        $thursday   = false;
        $wednesday  = false;
        $tuesday    = false;
        $monday     = false;
        if($num >= 64){
            $sunday = true;
            $num -= 64;
        }if($num >= 32){
            $saturday = true;
            $num -= 32;
        }if($num >= 16){
            $friday = true;
            $num -= 16;
        }if($num >= 8){
            $thursday = true;
            $num -= 8;
        }if($num >= 4){
            $wednesday = true;
            $num -= 4;
        }if($num >= 2){
            $tuesday = true;
            $num -= 2;
        }if($num >= 1){
            $monday = true;
            $num -= 1;
        }
        return compact('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
    }

    /**
     * Add a image to this service
     */
    public function addImage(Image $image){
        return $this->images()->save($image);
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
	 * Get the associated user with this service
	 */
    public function user(){
    	return $this->belongsTo('App\User');
    }

    /**
     * Get the associated clients with this service
     */
    public function clients(){
    	return $this->belongsToMany('App\Client');
    }

    /**
     * Get associated reports with this service
     */
    public function reports(){
    	return $this->hasMany('App\Report');
    }

    /**
     * Associated reports with this service
     */
    public function images(){
        return $this->hasMany('App\Image');
    }

    /**
     * get the number of images this service has
     */
    public function numImages(){
        return $this->hasMany('App\Image')->count();
    }

    /**
     * get full size image
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
     */
    public function thumbnail(){
        if($this->numImages() > 0){
            return $this->hasMany('App\Image')
                ->first()->thumbnail_path;
        }
        return 'img/no_image.png';
    }

    /**
     * Get the extra small image
     */
    public function icon(){
        if($this->numImages() > 0){
            return $this->hasMany('App\Image')
                ->first()->icon_path;
        }
        return 'img/avatar-2-48.png';
    }
}
