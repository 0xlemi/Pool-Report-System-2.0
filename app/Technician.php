<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Intervention;
use App\Administrator;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Technician extends Model
{

    /**
	 * variables that can be mass assign
	 * @var array
	 */
	protected $fillable = [
		'name',
        'last_name',
        'supervisor_id',
        'username',
        'password',
        'cellphone',
        'address',
        'language',
        'comments',
	];

    /**
     * hidden variables
     * @var array
     */
	protected $hidden = [
		'password',
	];

    /**
     * Get the user that this technician morphs to
     * @return $User
     * tested
     */
    public function user()
    {
      return $this->morphOne('App\User', 'userable')->first();
    }

	/**
	 * associated supervisor with this technician
	 * tested
	 */
    public function supervisor(){
    	return $this->belongsTo('App\Supervisor')->first();
    }

	/**
	 * assaciated reports with this technician
	 * tested
	 */
    public function reports(){
    	return $this->hasMany('App\Report')->get();
    }

    /**
     * Associated administrator with this technician
     * tested
     */
    public function admin(){
    	$admin_id = Supervisor::findOrFail($this->supervisor_id)->admin_id;
    	return Administrator::findOrFail($admin_id);
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
        $file->move(public_path( env('FOLDER_IMG').'technician/' ), $name);

        // make and save thumbnail
        $img = Intervention::make(public_path( env('FOLDER_IMG').'technician/'.$name));
        $img->fit(300)->save(public_path( env('FOLDER_IMG').'technician/'.$name_thumbnail));

         // make and save icon
        $img->fit(64)->save(public_path( env('FOLDER_IMG').'technician/'.$name_icon));

        // add image
        $image = new Image;
        $image->normal_path = env('FOLDER_IMG').'technician/'.$name;
        $image->thumbnail_path = env('FOLDER_IMG').'technician/'.$name_thumbnail;
        $image->icon_path = env('FOLDER_IMG').'technician/'.$name_icon;

        // presist image to the database
        return $this->addImage($image);
    }

     /**
     * Add a image to this client
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
     * Get the extra small image
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
