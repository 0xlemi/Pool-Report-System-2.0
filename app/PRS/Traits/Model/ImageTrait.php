<?php

namespace App\PRS\Traits\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Intervention;

use App\Image;

trait ImageTrait{

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
        $image->order = $this->numImages() + 1;

        // presist image to the database
        return $this->addImage($image);
	}

	 /**
     * Add a image to this client
     * tested for
     * Administrator: yes
     * Supervisor:
     * Technician:
     * Service:
     * Client:
     * Report:
     */
    public function addImage(Image $image){
        return $this->images()->save($image);
    }

    /**
     * delete a single image
     * @param  int    $order
     * @return boolean
     * credits to pisio
     * tested for
     * Administrator:
     * Supervisor:
     * Technician:
     * Service:
     * Client:
     * Report:
     */
    public function deleteImage(int $order)
    {
        $image = $this->image($order);
        if(!$image){
            return $image->delete();
        }
        return false;
    }

    /**
     * associated images with this report
     * tested for
     * Administrator:
     * Supervisor:
     * Technician:
     * Service:
     * Client:
     * Report:
     */
    public function images(){
        return $this->hasMany('App\Image');
    }

     /**
     * get the number of images this service has
     * tested for
     * Administrator:
     * Supervisor:
     * Technician:
     * Service:
     * Client:
     * Report:
     */
    public function numImages(){
        return $this->images()->count();
    }

    /**
     * Check if image with that order num exists
     * tested for
     * Administrator:
     * Supervisor:
     * Technician:
     * Service:
     * Client:
     * Report:
     */
    public function imageExists($order = 1)
    {
        if($this->images()
                    ->where('order', '=', $order)
                    ->count() < 1){
            return false;
        }
        return true;
    }

    /**
     * get full size image
     * tested for
     * Administrator:
     * Supervisor:
     * Technician:
     * Service:
     * Client:
     * Report:
     */
    public function image($order = 1, $getUrl = true){
        $image = $this->images()
            ->where('order', '=', $order)
            ->first();
        if($getUrl){
            if(!$image){
                return 'img/no_image.png';
            }
            return $image->normal_path;
        }
        return $image;
    }

    /**
     * get full size image
     * tested for
     * Administrator:
     * Supervisor:
     * Technician:
     * Service:
     * Client:
     * Report:
     */
    public function normalImage($order = 1){
        $image = $this->images()
            ->where('order', '=', $order)
            ->firstOrFail();
        if(!$image){
            return 'img/no_image.png';
        }
        return $image->normal_path;
    }

    /**
     * get thumbnail image
     * tested for
     * Administrator:
     * Supervisor:
     * Technician:
     * Service:
     * Client:
     * Report:
     */
    public function thumbnail(){
        if($this->numImages() > 0){
            return $this->images()
                ->first()->thumbnail_path;
        }
        return 'img/no_image.png';
    }

    /**
     * Get the extra small image
     * tested for
     * Administrator:
     * Supervisor:
     * Technician:
     * Service:
     * Client:
     * Report:
     */
    public function icon(){
        if($this->numImages() > 0){
            return $this->images()
                ->first()->icon_path;
        }
        return 'img/avatar-2-48.png';
    }

}
