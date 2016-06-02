<?php

namespace App\PRS\Helpers;

use Faker\Factory;
use Intervention;
use DB;

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
    public function get_random_id($table){
    	$table_ids = DB::table($table)->select('id')->get();
        return $this->faker->randomElement($table_ids)->id;
    }

    /**
     * Get a random service id linked to that admin
     * @param  integer  $admin_id
     * @return integer            id of the random service
     */
    public function get_random_service($admin_id){
    	$table_ids = DB::table('services')->select('id')->where('admin_id', '=', $admin_id)->get();
        return $this->faker->randomElement($table_ids)->id;
    }

    public function get_random_supervisor($admin_id)
    {
        $table_ids = DB::table('supervisors')->select('id')->where('admin_id', '=', $admin_id)->get();
        return $this->faker->randomElement($table_ids)->id;
    }

    public function get_random_technician($admin_id)
    {
        $supervisor_id = $this->get_random_supervisor($admin_id);
        $table_ids = DB::table('technicians')
                        ->select('id')
                        ->where('supervisor_id', '=', $supervisor_id)
                        ->get();
        $this->faker->randomElement($table_ids)->id;
    }

}
