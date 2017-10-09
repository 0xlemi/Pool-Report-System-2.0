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

        $contract = $this->createServiceContract($service->id);

        // When
        $ser = $contract->service;

        // Then
        $this->assertSameObject($service, $ser);

    }

    /** @test */
    public function check_if_today_is_the_day_to_charge_invoice_on_contract()
    {
        // Given
        $admin = $this->createAdministrator();


        $service = $this->createService($admin->id);

        $today = Carbon::today($admin->timezone);
        $contract = $this->createServiceContract($service->id, [
            'start' => '2017-04-'.$today->format('d'),
            'active' => true,
        ]);

        // When
        $true = $contract->checkIfInDayContractInvoiceIsDo();

        // Then
        $this->assertTrue($true);

    }

}
