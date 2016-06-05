<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Intervention;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Client extends Model
{

	/**
	 * variables that can be mass assign
	 * @var array
	 */
	protected $fillable = [
		'name',
		'last_name',
		'email',
		'cellphone',
		'type',
		'language',
		'email_preferences',
		'comments',
		'user_id',
	];

    /**
     * hidden variables
     * @var array
     */
	protected $hidden = [
		'password',
		'user_id',
	];

	/**
	 * Gets client morphed user
	 * @return $User
	 * tested
	 */
	public function user()
    {
      return $this->morphOne('App\User', 'userable')->first();
    }

	/*
	 * associated services with this client
	 * tested
	 */
    public function services(){
    	return $this->belongsToMany('App\Service')->get();
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
        $file->move(public_path( env('FOLDER_IMG').'client/' ), $name);

        // make and save thumbnail
        $img = Intervention::make(public_path( env('FOLDER_IMG').'client/'.$name));
        $img->fit(300)->save(public_path( env('FOLDER_IMG').'client/'.$name_thumbnail));

         // make and save icon
        $img->fit(64)->save(public_path( env('FOLDER_IMG').'client/'.$name_icon));

        // add image
        $image = new Image;
        $image->normal_path = env('FOLDER_IMG').'client/'.$name;
        $image->thumbnail_path = env('FOLDER_IMG').'client/'.$name_thumbnail;
        $image->icon_path = env('FOLDER_IMG').'client/'.$name_icon;

        // presist image to the database
        return $this->addImage($image);
	}

	 /**
     * Add a image to this client
     */
    public function addImage(Image $image){
        return $this->images()->save($image);
    }

    /**
     * associated images with this report
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
