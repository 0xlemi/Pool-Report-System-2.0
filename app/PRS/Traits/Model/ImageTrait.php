<?php

namespace App\PRS\Traits\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Intervention;
use Illuminate\Database\Eloquent\Collection;

use App\Image;
use Storage;
use App\Jobs\DeleteImage;
use App\Jobs\ProcessImage;

trait ImageTrait{

    /**
     * add a image from form information
     */
	public function addImageFromForm(UploadedFile $file, int $order = null, int $type = null)
    {

        $storageFolder = 'images/'.strtolower($this->modelName());

        //generate image names
        $randomName = str_random(50);

        $image = $this->images()->create([
            'order' => ($order)?: $this->lastOrderNum()+1,
            'type' => ($type)?: 1,
            'big' => "{$storageFolder}/bg_{$randomName}.jpg",
            'medium' => "{$storageFolder}/md_{$randomName}.jpg",
            'thumbnail' => "{$storageFolder}/sm_{$randomName}.jpg",
            'icon' => "{$storageFolder}/ic_{$randomName}.jpg"
        ]);

        // Stream file directly to S3.
        $tempFilePath = Storage::putFileAs('temp', $file, str_random(50).$file->guessExtension());

        dispatch(new ProcessImage($image, $storageFolder, $randomName, $tempFilePath));

        return $image;
	}

    public function addImageFromUrl(string $tempFilePath, int $order = null, int $type = null)
    {
        $storageFolder = 'images/'.strtolower($this->modelName());

        //generate image names
        $randomName = str_random(50);

        $image = $this->images()->create([
            'order' => ($order)?: $this->lastOrderNum()+1,
            'type' => ($type)?: 1,
            'big' => "{$storageFolder}/bg_{$randomName}.jpg",
            'medium' => "{$storageFolder}/md_{$randomName}.jpg",
            'thumbnail' => "{$storageFolder}/sm_{$randomName}.jpg",
            'icon' => "{$storageFolder}/ic_{$randomName}.jpg"
        ]);

        dispatch(new ProcessImage($image, $storageFolder, $randomName, $tempFilePath));

        return $image;
    }

    public function lastOrderNum()
    {
        if($this->images()->count() > 0){
            return $this->images()->orderBy('order', 'desc')->first()->order;
        }
        return 0;
    }

    public function modelName()
    {
        return class_basename(get_class($this));
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

    public function deleteImages()
    {
        foreach ($this->images as $image) {
            $image->delete();
        }
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
        return $this->morphMany('App\Image', 'imageable');
    }

    /**
     * get the images by the type
     * @param  int $type
     * @return Collection
     */
    public function imagesByType($type)
    {
        return $this->images()->where('images.type', $type)->get();
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
                    ->where('images.order', '=', $order)
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
            ->where('images.order', '=', $order)
            ->where('images.type', '=', $type)
            ->first();
        if($getUrl){
            if(!$image){
                return 'images/assets/app/no_image.png';
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
            ->where('images.order', '=', $order)
            ->firstOrFail();
        if(!$image){
            return 'images/assets/app/no_image.png';
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
        return 'images/assets/app/no_image.png';
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
        return 'images/assets/app/avatar-2-48.png';
    }

}
