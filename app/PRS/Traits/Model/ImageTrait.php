<?php

namespace App\PRS\Traits\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Intervention;
use Illuminate\Database\Eloquent\Collection;

use App\Image;
use Storage;
use App\Jobs\ProcessImage;

trait ImageTrait{

    /**
     * add a image from form information
     */
	public function addImageFromForm(UploadedFile $file, int $order = null, int $type = null){

        $image = $this->images()->create([
            'order' => ($this->type)?: $this->numImages()+1,
            'type' => ($this->type)?: 1,
        ]);

        // Stream file directly to S3.
        $tempFilePath = Storage::putFileAs('temp', $file, str_random(50).$file->guessExtension());

        dispatch(new ProcessImage($this, $image, $tempFilePath));
	}

	 /**
     * Add a image to this client
     * @return Image
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
     * Report: true
     */
    public function deleteImage(int $order)
    {
        $image = $this->image($order, false);
        if($image){
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
     * get the images by the type
     * @param  int $type
     * @return Collection
     */
    public function imagesByType($type)
    {
        return $this->images()->where('type', $type)->get();
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
     */
    public function image($order = 1, $getUrl = true, $type = 1){
        $image = $this->images()
            ->where('order', '=', $order)
            ->where('type', '=', $type)
            ->first();
        if($getUrl){
            if(!$image){
                return 'img/no_image.png';
            }
            return $image->big;
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
        return $image->medium;
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
                ->first()->thumbnail;
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
                ->first()->icon;
        }
        return 'img/avatar-2-48.png';
    }

}
