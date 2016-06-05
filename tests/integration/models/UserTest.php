<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Administrator;
use App\Client;
use App\User;
use App\Supervisor;
use App\Technician;

class UserTest extends ModelTester
{

    /** @test */
    public function it_gets_userable()
    {
        // Given
        $admin = factory(Administrator::class)->create();
        $user_admin = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        $cli = factory(Client::class)->create([
            'admin_id' => $admin->id,
        ]);
        $user_client = factory(User::class)->create([
            'userable_id' => $cli->id,
            'userable_type' => 'App\Client',
        ]);

        $sup = factory(Supervisor::class)->create([
            'admin_id' => $admin->id,
        ]);
        $user_sup = factory(User::class)->create([
            'userable_id' => $sup->id,
            'userable_type' => 'App\Supervisor',
        ]);

        $tech = factory(Technician::class)->create([
            'supervisor_id' => $sup->id,
        ]);
        $user_tech = factory(User::class)->create([
            'userable_id' => $tech->id,
            'userable_type' => 'App\Technician',
        ]);


        // When
        $administrator = $user_admin->userable();
        $client = $user_client->userable();
        $supervisor = $user_sup->userable();
        $technician = $user_tech->userable();

        // Then
        $this->assertSameObject($admin, $administrator);
        $this->assertSameObject($cli, $client);
        $this->assertSameObject($sup, $supervisor);
        $this->assertSameObject($tech, $technician);


    }

}
