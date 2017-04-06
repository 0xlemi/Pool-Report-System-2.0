<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Administrator;
use App\User;

class TechnicianControllerTest extends ApiTester
{


//***********************************************************************
//    AUTHORIZATION TESTS
//***********************************************************************

    /** @test */
    public function it_authorizes_index()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_technician_index' => 0,
            'sup_technician_index' => 0,
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
            ->call('GET', 'technicians');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('GET', 'technicians');
        $this->assertResponseStatus(403);

        $admin->tech_technician_index = 1;
        $admin->sup_technician_index = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('GET', 'technicians');
        $this->assertResponseStatus(200);

        $this->actingAs($tech->user())
            ->call('GET', 'technicians');
        $this->assertResponseStatus(200);
    }

    /** @test */
    public function it_authorizes_store()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_technician_create' => 0,
            'sup_technician_create' => 0,
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
            ->call('GET', 'technicians/create');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('GET', 'technicians/create');
        $this->assertResponseStatus(403);

        $admin->tech_technician_create = 1;
        $admin->sup_technician_create = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('GET', 'technicians/create');
        $this->assertResponseStatus(200);

        $this->actingAs($tech->user())
            ->call('GET', 'technicians/create');
        $this->assertResponseStatus(200);
    }

    /** @test */
    public function it_authorizes_show()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_technician_show' => 0,
            'sup_technician_show' => 0,
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
            ->call('GET', 'technicians/1');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('GET', 'technicians/1');
        $this->assertResponseStatus(403);

        $admin->tech_technician_show = 1;
        $admin->sup_technician_show = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('GET', 'technicians/1');
        $this->assertResponseStatus(200);

        $this->actingAs($tech->user())
            ->call('GET', 'technicians/1');
        $this->assertResponseStatus(200);
    }

    /** @test */
    public function it_authorizes_update()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_technician_edit' => 0,
            'sup_technician_edit' => 0,
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
            ->call('GET', 'technicians/1/edit');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('GET', 'technicians/1/edit');
        $this->assertResponseStatus(403);

        $admin->tech_technician_edit = 1;
        $admin->sup_technician_edit = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('GET', 'technicians/1/edit');
        $this->assertResponseStatus(200);

        $this->actingAs($tech->user())
            ->call('GET', 'technicians/1/edit');
        $this->assertResponseStatus(200);
    }

    /** @test */
    public function it_authorizes_delete()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_technician_destroy' => 0,
            'sup_technician_destroy' => 0,
        ]);
        $user = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        $sup = $this->createSupervisor($admin->id);

        $this->createTechnician($sup->id);
        $this->createTechnician($sup->id);
        $tech = $this->createTechnician($sup->id);

        // When
        // Then
        $this->actingAs($sup->user())
            ->call('DELETE', 'technicians/1');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('DELETE', 'technicians/2');
        $this->assertResponseStatus(403);

        $admin->tech_technician_destroy = 1;
        $admin->sup_technician_destroy = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('DELETE', 'technicians/1');
        $this->assertResponseStatus(302);

        $this->actingAs($tech->user())
            ->call('DELETE', 'technicians/2');
        $this->assertResponseStatus(302);
    }

}
