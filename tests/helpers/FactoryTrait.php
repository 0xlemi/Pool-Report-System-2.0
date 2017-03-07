<?php

use App\PRS\Helpers\SeederHelpers;

use App\User;
use App\Administrator;
use App\Supervisor;
use App\Technician;
use App\Service;
use App\Invoice;
use App\WorkOrder;
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

    /**
    * Create a model factoryWithoutObservers and forget observers so events do not trigger actions.
    */
   public function factoryWithoutObservers($class, $name = 'default') {
       $class::flushEventListeners();
       return factory($class, $name);
   }


   // *************************
   //         Factory
   // *************************

   public function createPayment(Invoice $invoice)
   {
       // change this to factory()
       return $invoice->payments()->create([
           'amount' => 50,
       ]);
   }

   public function createInvoice(WorkOrder $workOrder)
   {
       // change this to factory()
       return $workOrder->invoices()->create([
           'closed' => '2016-10-04 02:05:41',
           'amount' => 150,
           'currency' => 'USD',
           'admin_id' => 1,
       ]);
   }

   public function createWork(WorkOrder $workOrder, Technician $technician)
   {
       // change this to factory()
       return $workOrder->works()->create([
           'title' => 'Some Job',
           'description' => 'Nothing',
           'quantity' => 23,
           'units' => 'square meters',
           'cost' => 250,
           'technician_id' => $technician->id,
       ]);
   }

   public function createWorkOrder(Service $service, Supervisor $supervisor)
   {
       // change this to factory()
       return $service->workOrders()->create([
           'title' => 'Title',
           'description' => 'Nothing',
           'start' => '2017-02-03 06:45:10',
           'end' => null,
           'price' => 1500,
           'currency' => 'USD',
           'supervisor_id' => $supervisor->id,
       ]);
   }

   public function createContract(Service $service)
   {
       // change this to factory()
       return $service->serviceContract()->create([
           'start' => '2017-02-16',
           'active' => 1,
           'service_days' => 56,
           'amount' => 500,
           'currency' => 'USD',
           'start_time' => '01:17:26',
           'end_time' => '11:17:29',
           'comments' => 'This are the comments',
       ]);
   }

   public function createEquipment(Service $service)
   {
       // change this to factory()
       return $service->equipment()->create([
           'kind' => 'Pump',
           'type' => 'Double Motor',
           'brand' => 'Pentair',
           'model' => 'ABC',
           'capacity' => 2,
           'units' => 'hp',
       ]);
   }

   public function createChemical(Service $service)
   {
       // change this to factory()
       return $service->chemicals()->create([
           'name' => 'Some Chemical',
           'amount' => 25,
           'units' => 'grams',
       ]);
   }

   public function createAdministrator()
   {
       $adminId = $this->factoryWithoutObservers(Administrator::class)->create()->id;
       $user = $this->factoryWithoutObservers(User::class)->create([
           'userable_id' => $adminId,
           'userable_type' => 'App\Administrator',
       ]);
       return Administrator::find($adminId);
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
       $supervisor = $this->factoryWithoutObservers(Supervisor::class)->create([
           'admin_id' => $admin_id,
       ]);

       $user = $this->factoryWithoutObservers(User::class)->create([
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
       $technician = $this->factoryWithoutObservers(Technician::class)->create([
           'supervisor_id' => $supervisor_id,
       ]);

       $user = $this->factoryWithoutObservers(User::class)->create([
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

       $client = $this->factoryWithoutObservers(App\Client::class)->create([
               'admin_id' => $admin_id,
           ]);

       $this->factoryWithoutObservers(App\User::class)->create([
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
       return $this->factoryWithoutObservers(Service::class)->create([
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

   public function createServiceContract($service_id)
   {
       return $this->factoryWithoutObservers(App\ServiceContract::class)->create([
           'service_id' => $service_id,
       ]);
   }

   public function createReport($service_id, $technician_id)
   {
       return $this->factoryWithoutObservers(App\Report::class)->create([
           'service_id' => $service_id,
           'technician_id' => $technician_id,
       ]);
   }

}
