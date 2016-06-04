<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\PRS\Helpers\SeederHelpers;

use App\User;
use App\Administrator;
use App\Supervisor;
use App\Technician;
use App\Service;
use App\Report;

/**
 *
 */
class ModelTester extends TestCase
{
    use DatabaseTransactions;

    protected $seederHelper;

    public function __construct()
    {
        $this->seederHelper = new SeederHelpers();
    }

    public function setUp()
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }

    protected function assertSameObject($object1, $object2, $associative = false)
    {
        return $this->assertSameArray(
            $object1->toArray(),
            $object2->toArray(),
            $associative
        );
    }

    protected function assertSameArray($array1, $array2, $associative = false)
    {
        if($associative){
            $difference = array_diff_assoc(
                    $array1,
                    $array2
                );
        }else{
            $difference = array_diff(
                    $array1,
                    $array2
                );
        }
        return $this->assertTrue(empty($difference));
    }

    protected function createAdministrator()
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
    protected function createAdministrators($num_of_admins = 1, $get_all = false)
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

    protected function createSupervisor($admin_id)
    {
        $supervisor = factory(Supervisor::class)->create([
            'admin_id' => $admin_id,
        ]);

        $user = factory(User::class)->create([
            'userable_id' => $supervisor->id,
            'userable_type' => 'Supervisor',
        ]);
        return $supervisor;
    }

    protected function createSupervisors($num_of_supervisors, $get_all = false)
    {
        $supervisors = array();
        for ($i=0; $i < $num_of_supervisors; $i++) {

            // get a random admin_id that exists in database
            $admin_id = $this->seederHelper->get_random_id('administrators');

            array_push($supervisors, $this->createSupervisor($admin_id));
        }
        if($num_of_supervisors == 1){
            return $supervisors[0];
        }elseif($get_all){
            return $supervisors;
        }
        return $supervisors[rand(0,--$num_of_supervisors)];

    }

    protected function createTechnician($supervisor_id)
    {
        $technician = factory(Technician::class)->create([
            'supervisor_id' => $supervisor_id,
        ]);

        $user = factory(User::class)->create([
            'userable_id' => $technician->id,
            'userable_type' => 'Technician',
        ]);
        return $technician;
    }

    protected function createTechnicians($num_of_technicians, $get_all = false)
    {
        $technicians = array();
        for ($i=0; $i < $num_of_technicians; $i++) {

            // get a random supervisor_id that exists in database
            $supervisor_id = $this->seederHelper->get_random_id('supervisors');

            array_push($technicians, $this->createTechnician($supervisor_id));
        }
        if($num_of_technicians == 1){
            return $technicians[0];
        }elseif($get_all){
            return $technicians;
        }
        return $technicians[rand(0,--$num_of_technicians)];
    }

    protected function createClient($service_id)
    {
        // find admin_id congruent with the service
        $admin_id = App\Service::findOrFail($service_id)->admin()->id;

        $client = factory(App\Client::class)->create([
                'admin_id' => $admin_id,
            ]);

        factory(App\User::class)->create([
            'userable_id' => $client->id,
            'userable_type' => 'Client',
        ]);

        // fill the pivot table that connects with the service
         DB::table('client_service')->insert([
            'client_id' => $client->id,
            'service_id' => $service_id,
        ]);

        return $client;
    }

    protected function createService($admin_id)
    {
        return factory(Service::class)->create([
            'admin_id' => $admin_id,
        ]);
    }

    protected function createServices($num_of_services, $get_all = false)
    {
        $services = array();
        for ($i=0; $i < $num_of_services; $i++) {

            // get a random admin_id that exists in database
        	$admin_id = $this->seederHelper->get_random_id('administrators');

            array_push($services, $this->createService($admin_id));
        }
        if($num_of_services == 1){
            return $services[0];
        }elseif($get_all){
            return $services;
        }
        return $services[rand(0,--$num_of_services)];
    }

    protected function createReport($service_id, $technician_id)
    {
        return factory(App\Report::class)->create([
            'service_id' => $service_id,
            'technician_id' => $technician_id,
        ]);
    }

    protected function createReports($num_of_reports, $get_all = false)
    {
        $reports = array();
        for ($i=0; $i < $num_of_reports; $i++) {

            $admin_id = $this->seederHelper->get_random_id('administrators');

            // get a random service that shares the commun admin_id
            $service_id = $this->seederHelper->get_random_service($admin_id);

            // get a random technician that shares the commun admin_id
        	$technician_id = $this->seederHelper->get_random_technician($admin_id);

            array_push($reports, $this->createReport($service_id, $technician_id));
        }
        if($num_of_reports == 1){
            return $reports[0];
        }elseif($get_all){
            return $reports;
        }
        return $reports[rand(0,--$num_of_reports)];
    }


}
