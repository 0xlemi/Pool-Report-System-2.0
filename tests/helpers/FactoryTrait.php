<?php

use App\PRS\Helpers\SeederHelpers;

use App\User;
use App\Administrator;
use App\Supervisor;
use App\Technician;
use App\Service;
use App\Report;

/**
 * Persist information in the database for testing.
 */
trait FactoryTrait
{

    protected $seederHelper;

    public function __construct()
    {
        $this->seederHelper = new SeederHelpers();
    }

    public function createAdministrator()
    {
        $admin = factory(Administrator::class)->create();
        $user = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);
        return $admin;
    }

    /**
     * Creates the administrator with morphed user
     * @param  integer $num_of_admins
     * @param  boolean $get_random    Weather should i get all or 1 random admin/user
     * @return array              array with the admin object and the user object
     */
    public function createAdministrators($num_of_admins = 1, $get_all = false)
    {
        $admins = array();
        for ($i=0; $i < $num_of_admins; $i++) {
            array_push($admins, $this->createAdministrator());
        }
        if($num_of_admins == 1){
            return $admins[0];
        }elseif($get_all){
            return $admins;
        }
        return $admins[rand(0,--$num_of_admins)];
    }

    public function createSupervisor($admin_id)
    {
        $supervisor = factory(Supervisor::class)->create([
            'admin_id' => $admin_id,
        ]);

        $user = factory(User::class)->create([
            'userable_id' => $supervisor->id,
            'userable_type' => 'App\Supervisor',
        ]);
        return $supervisor;
    }

    public function createSupervisors($num_of_supervisors, $get_all = false)
    {
        $supervisors = array();
        for ($i=0; $i < $num_of_supervisors; $i++) {

            // get a random admin_id that exists in database
            $adminId = $this->seederHelper->getRandomObject('administrators');

            array_push($supervisors, $this->createSupervisor($adminId));
        }
        if($num_of_supervisors == 1){
            return $supervisors[0];
        }elseif($get_all){
            return $supervisors;
        }
        return $supervisors[rand(0,--$num_of_supervisors)];

    }

    public function createTechnician($supervisor_id)
    {
        $technician = factory(Technician::class)->create([
            'supervisor_id' => $supervisor_id,
        ]);

        $user = factory(User::class)->create([
            'userable_id' => $technician->id,
            'userable_type' => 'App\Technician',
        ]);
        return $technician;
    }

    public function createTechnicians($num_of_technicians, $get_all = false)
    {
        $technicians = array();
        for ($i=0; $i < $num_of_technicians; $i++) {

            // get a random supervisor_id that exists in database
            $supervisorId = $this->seederHelper->getRandomObject('supervisors');

            array_push($technicians, $this->createTechnician($supervisorId));
        }
        if($num_of_technicians == 1){
            return $technicians[0];
        }elseif($get_all){
            return $technicians;
        }
        return $technicians[rand(0,--$num_of_technicians)];
    }

    public function createClient($admin_id, array $service_ids = array())
    {

        $client = factory(App\Client::class)->create([
                'admin_id' => $admin_id,
            ]);

        factory(App\User::class)->create([
            'userable_id' => $client->id,
            'userable_type' => 'App\Client',
        ]);

        foreach ($service_ids as $service_id) {
            // fill the pivot table that connects with the service
             DB::table('client_service')->insert([
                'client_id' => $client->id,
                'service_id' => $service_id,
            ]);
        }


        return $client;
    }

    public function createService($admin_id)
    {
        return factory(Service::class)->create([
            'admin_id' => $admin_id,
        ]);
    }

    public function createServices($num_of_services, $get_all = false)
    {
        $services = array();
        for ($i=0; $i < $num_of_services; $i++) {

            // get a random admin_id that exists in database
        	$adminId = $this->seederHelper->getRandomObject('administrators');

            array_push($services, $this->createService($adminId));
        }
        if($num_of_services == 1){
            return $services[0];
        }elseif($get_all){
            return $services;
        }
        return $services[rand(0,--$num_of_services)];
    }

    public function createReport($service_id, $technician_id)
    {
        return factory(App\Report::class)->create([
            'service_id' => $service_id,
            'technician_id' => $technician_id,
        ]);
    }

    // public function createReports($num_of_reports, $get_all = false)
    // {
    //     $reports = array();
    //     for ($i=0; $i < $num_of_reports; $i++) {
    //
    //         $adminId = $this->seederHelper->getRandomObject('administrators');
    //
    //         // get a random service that shares the commun admin_id
    //         $service_id = $this->seederHelper->getRandomService(Administrator::findOrFail($adminId));
    //
    //         // get a random technician that shares the commun admin_id
    //     	$technician_id = $this->seederHelper->get_random_technician($admin_id);
    //
    //         array_push($reports, $this->createReport($service_id, $technician_id));
    //     }
    //     if($num_of_reports == 1){
    //         return $reports[0];
    //     }elseif($get_all){
    //         return $reports;
    //     }
    //     return $reports[rand(0,--$num_of_reports)];
    // }

}
