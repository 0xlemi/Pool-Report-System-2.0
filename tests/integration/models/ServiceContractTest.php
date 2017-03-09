<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\ServiceContract;
use Carbon\Carbon;

class ServiceContractTest extends DatabaseTester
{

    /** @test */
    public function it_gets_contract_service()
    {
        // Given
        $admin = $this->createAdministrator();

        $service = $this->createService($admin->id);

        // ServiceContract::flushEventListeners();
        // $contract = $service->serviceContract()->create([
        // // $contract = ServiceContract::create([
        //     'start' => '',
        //     'active' => true,
        //     'service_days' => 100,
        //     'amount' => 250,
        //     'currency' => 'MXN',
        //     'start_time' => Carbon::today(),
        //     'end_time' => Carbon::now(),
        // ]);

        $contract = $this->createServiceContract($service->id);
        $contract = ServiceContract::findOrFail($service->id);

        // When
        $ser = $contract->service;

        // Then
        $this->assertSameObject($service, $ser);

    }

}
