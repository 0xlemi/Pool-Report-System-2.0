<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ServiceTest extends ModelTester
{

    /** @test */
    public function it_gets_admin()
    {
        // Given
        $admin = $this->createAdministrator();

        $service = $this->createService($admin->id);

        // When
        $administrator = $service->admin()->first();

        // Then
        $this->assertSameObject($admin, $administrator);

    }

    /** @test */
    public function it_gets_clients()
    {
        // Given
        $admin = $this->createAdministrator();

        $service1 = $this->createService($admin->id);
        $service2 = $this->createService($admin->id);

        $client1 = $this->createClient($service1->id);
        $client2 = $this->createClient($service2->id);
        $client3 = $this->createClient($service2->id);

        // When
        $clients = $service2->clients();

        dd([
            array_flat($clients[0]->toArray()),
            $client2->toArray(),
            array_diff(
                array_flat($clients[0]->toArray()),
                $client2->toArray()
            )
        ]);

        // Then
        // $this->assertEquals(2, sizeof($clients));
        // $this->assertSameObject($client2, $clients[0]);
        // $this->assertSameObject($client3, $clients[1]);

    }

}
