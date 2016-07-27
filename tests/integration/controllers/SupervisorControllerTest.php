<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Administrator;
use App\User;

class SupervisorControllerTest extends ApiTester
{




//***********************************************************************
//    AUTHORIZATION TESTS
//***********************************************************************

    /** @test */
    public function it_authorizes_index()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_supervisor_index' => 0,
            'sup_supervisor_index' => 0,
        ]);
        $user = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        // When
        // Then
        $this->actingAs($sup->user())
            ->call('GET', 'supervisors');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('GET', 'supervisors');
        $this->assertResponseStatus(403);

        $admin->tech_supervisor_index = 1;
        $admin->sup_supervisor_index = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('GET', 'supervisors');
        $this->assertResponseStatus(200);

        $this->actingAs($tech->user())
            ->call('GET', 'supervisors');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_authorizes_store()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_supervisor_create' => 0,
            'sup_supervisor_create' => 0,
        ]);
        $user = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        // When
        // Then
        $this->actingAs($sup->user())
            ->call('GET', 'supervisors/create');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('GET', 'supervisors/create');
        $this->assertResponseStatus(403);

        $admin->tech_supervisor_create = 1;
        $admin->sup_supervisor_create = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('GET', 'supervisors/create');
        $this->assertResponseStatus(200);

        $this->actingAs($tech->user())
            ->call('GET', 'supervisors/create');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_authorizes_show()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_supervisor_show' => 0,
            'sup_supervisor_show' => 0,
        ]);
        $user = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        // When
        // Then
        $this->actingAs($sup->user())
            ->call('GET', 'supervisors/1');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('GET', 'supervisors/1');
        $this->assertResponseStatus(403);

        $admin->tech_supervisor_show = 1;
        $admin->sup_supervisor_show = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('GET', 'supervisors/1');
        $this->assertResponseStatus(200);

        $this->actingAs($tech->user())
            ->call('GET', 'supervisors/1');
        $this->assertResponseStatus(200);
    }

    /** @test */
    public function it_authorizes_update()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_supervisor_edit' => 0,
            'sup_supervisor_edit' => 0,
        ]);
        $user = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        // When
        // Then
        $this->actingAs($sup->user())
            ->call('GET', 'supervisors/1/edit');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('GET', 'supervisors/1/edit');
        $this->assertResponseStatus(403);

        $admin->tech_supervisor_edit = 1;
        $admin->sup_supervisor_edit = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('GET', 'supervisors/1/edit');
        $this->assertResponseStatus(200);

        $this->actingAs($tech->user())
            ->call('GET', 'supervisors/1/edit');
        $this->assertResponseStatus(200);
    }

    /** @test */
    public function it_authorizes_delete()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_supervisor_edit' => 0,
            'sup_supervisor_edit' => 0,
        ]);
        $user = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        $this->createSupervisor($admin->id);
        $this->createSupervisor($admin->id);
        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        // When
        // Then
        $this->actingAs($sup->user())
            ->call('DELETE', 'supervisors/1');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('DELETE', 'supervisors/2');
        $this->assertResponseStatus(403);

        $admin->tech_supervisor_destroy = 1;
        $admin->sup_supervisor_destroy = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('DELETE', 'supervisors/1');
        $this->assertResponseStatus(302);

        $this->actingAs($tech->user())
            ->call('DELETE', 'supervisors/2');
        $this->assertResponseStatus(302);
    }

}
