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

    /** @test */
    public function it_tells_you_if_is_administrator()
    {
        // Given
        $admin = factory(Administrator::class)->create();
        $user_admin = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        // When
        $is_admin = $user_admin->isAdministrator();

        // Then
        $this->assertTrue($is_admin);

    }

    /** @test */
    public function it_tells_you_if_is_client()
    {
        // Given
        $admin = $this->createAdministrator();

        $cli = factory(Client::class)->create([
            'admin_id' => $admin->id,
        ]);
        $user_client = factory(User::class)->create([
            'userable_id' => $cli->id,
            'userable_type' => 'App\Client',
        ]);

        // When
        $is_client = $user_client->isClient();


        // Then
        $this->assertTrue($is_client);

    }

    /** @test */
    public function it_tells_you_if_is_supervisor()
    {
        // Given
        $admin = $this->createAdministrator();

        $sup = factory(Supervisor::class)->create([
            'admin_id' => $admin->id,
        ]);
        $user_sup = factory(User::class)->create([
            'userable_id' => $sup->id,
            'userable_type' => 'App\Supervisor',
        ]);

        // When
        $is_sup = $user_sup->isSupervisor();

        // Then
        $this->assertTrue($is_sup);

    }

    /** @test */
    public function it_tells_you_if_is_technician()
    {
        // Given
        $admin = $this->createAdministrator();

        $sup = $this->createSupervisor($admin->id);

        $tech = factory(Technician::class)->create([
            'supervisor_id' => $sup->id,
        ]);
        $user_tech = factory(User::class)->create([
            'userable_id' => $tech->id,
            'userable_type' => 'App\Technician',
        ]);

        // When
        $is_tech = $user_tech->isTechnician();

        // Then
        $this->assertTrue($is_tech);

    }

}
