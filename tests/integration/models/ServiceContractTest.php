<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\ServiceContract;

class ServiceContractTest extends ModelTester
{

    /** @test */
    public function it_gets_service()
    {
        // Given
        $admin = $this->createAdministrator();

        $service = $this->createService($admin->id);

        $this->createServiceContract($service->id);
        $contract = ServiceContract::findOrFail($service->id);

        // When
        $ser = $contract->service;

        // Then
        $this->assertSameObject($service, $ser);

    }

}
