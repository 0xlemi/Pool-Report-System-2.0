<?php

namespace App\PRS\Helpers;

use Faker\Factory;
use Intervention;
use Storage;
use DB;
use App\UserRoleCompany;
use App\Client;
use App\Technician;
use App\Supervisor;
use App\WorkOrder;
use App\Service;
use App\Company;
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
     * @param  string   $folderSource folder to save the images
     * @param  integer $maxNum    the name of the image to take. (example: 23.jpg)
     * @return array                  array with the paths of the saved images
     */
    public function get_random_image($folderSource, $maxNum){
        $randomImage = rand(1, $maxNum);
    	return (object) [
    		'big' => "migrations/images/$folderSource/big/$randomImage.jpg",
    		'medium' => "migrations/images/$folderSource/medium/$randomImage.jpg",
    		'thumbnail' => "migrations/images/$folderSource/thumbnail/$randomImage.jpg",
    		'icon' => "migrations/images/$folderSource/icon/$randomImage.jpg",
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

    public function getRandomUserRoleCompany(...$rolesIds)
    {
    	$userRoleCompanyIds = DB::table('user_role_company')
                            ->where('role_id', $this->faker->randomElement($rolesIds))
                            ->select('id')->get()->all();
        return UserRoleCompany::findOrFail($this->faker->randomElement($userRoleCompanyIds)->id);
    }

    /**
     * Get a random service id linked to that admin
     * @param  integer  $admin_id
     * @return App\Service
     */
    public function getRandomService(Company $company){
        $serviceIds = $company->services->pluck('id')->all();
        return Service::findOrFail($this->faker->randomElement($serviceIds));
    }

    public function getRandomWorkOrder(Company $company)
    {
        $service = $this->getRandomService($company);
        $i = 0;
        while (!$service->hasWorkOrders()) {
            $service = $this->getRandomService($company);
            // protection for infinite loop
            if($i > 70){
                throw new Exception("Services dont have WorkOrders attached to them.");
            }
            $i++;
        }
        $workOrdersIds = $service->workOrders->pluck('id')->all();
        return WorkOrder::findOrFail($this->faker->randomElement($workOrdersIds));
    }

}
