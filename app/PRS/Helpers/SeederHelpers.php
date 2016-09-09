<?php

namespace App\PRS\Helpers;

use Faker\Factory;
use Intervention;
use DB;
use App\WorkOrder;
use App\Service;
use App\Administrator;

/**
 * Helper functions for seeder classes
 */
class SeederHelpers
{

    protected $faker;

    public function __construct()
    {
      $this->faker = Factory::create();
    }

    /**
     * Get you a random image from the selected folder
     * @param  string   $folder_to_save folder to save the images
     * @param  string  $folder_to_get  folder to get the images
     * @param  integer $file_number    the name of the image to take. (example: 23.jpg)
     * @return array                  array with the paths of the saved images
     */
    public function get_random_image($folder_to_save, $folder_to_get, $file_number = 1){
    	$image_name = 'image_'.str_random(10).'.jpg';
        $img_path = 'storage/images/'.$folder_to_save.'/'.$image_name;
        $tn_img_path = 'storage/images/'.$folder_to_save.'/tn_'.$image_name;
        $xs_img_path = 'storage/images/'.$folder_to_save.'/xs_'.$image_name;

    	$img = Intervention::make(base_path('resources/images/'.$folder_to_get.'/'.$file_number.'.jpg'));
    	$img->save('public/'.$img_path);

    	$img->fit(300);
    	$img->save('public/'.$tn_img_path);

    	$img->fit(64);
    	$img->save('public/'.$xs_img_path);

    	return [
    		'img_path' => $img_path,
    		'tn_img_path' => $tn_img_path,
    		'xs_img_path' => $xs_img_path,
    	];
    }

    /**
     * Gets you a random existing id from the table
     * @param  string $table table to choose
     * @return integer        id of the random row
     */
    public function getRandomObject($table){
    	$table_ids = DB::table($table)->select('id')->get()->all();
        return $this->faker->randomElement($table_ids)->id;
    }

    /**
     * Get a random service id linked to that admin
     * @param  integer  $admin_id
     * @return App\Service
     */
    public function getRandomService(Administrator $admin){
        $serviceIds = $admin->services()
                        ->get()
                        ->pluck('id')
                        ->all();
        return Service::findOrFail($this->faker->randomElement($serviceIds));
    }

    public function getRandomWorkOrder(Administrator $admin)
    {
        $service = $this->getRandomService($admin);
        $workOrdersIds = $service->workOrders()
                                ->get()
                                ->pluck('id')
                                ->all();
        return WorkOrder::findOrFail($this->faker->randomElement($workOrdersIds));
    }

}
