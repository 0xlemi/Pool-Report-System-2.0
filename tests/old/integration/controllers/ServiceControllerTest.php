<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Administrator;
use App\User;

class ServiceControllerTest extends ApiTester
{






//***********************************************************************
//    AUTHORIZATION TESTS
//***********************************************************************

    /** @test */
    public function it_authorizes_index()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_service_index' => 0,
            'sup_service_index' => 0,
        ]);
        $user = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        $this->createService($admin->id);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        // When
        // Then
        $this->actingAs($sup->user())
            ->call('GET', 'services');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('GET', 'services');
        $this->assertResponseStatus(403);

        $admin->tech_service_index = 1;
        $admin->sup_service_index = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('GET', 'services');
        $this->assertResponseStatus(200);

        $this->actingAs($tech->user())
            ->call('GET', 'services');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_authorizes_store()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_service_create' => 0,
            'sup_service_create' => 0,
        ]);
        $user = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        $this->createService($admin->id);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        // When
        // Then
        $this->actingAs($sup->user())
            ->call('GET', 'services/create');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('GET', 'services/create');
        $this->assertResponseStatus(403);

        $admin->tech_service_create = 1;
        $admin->sup_service_create = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('GET', 'services/create');
        $this->assertResponseStatus(200);

        $this->actingAs($tech->user())
            ->call('GET', 'services/create');
        $this->assertResponseStatus(200);
    }

    /** @test */
    public function it_authorizes_show()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_service_show' => 0,
            'sup_service_show' => 0,
        ]);
        $user = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        $this->createService($admin->id);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        // When
        // Then
        $this->actingAs($sup->user())
            ->call('GET', 'services/1');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('GET', 'services/1');
        $this->assertResponseStatus(403);

        $admin->tech_service_show = 1;
        $admin->sup_service_show = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('GET', 'services/1');
        $this->assertResponseStatus(200);

        $this->actingAs($tech->user())
            ->call('GET', 'services/1');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_authorizes_update()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_service_edit' => 0,
            'sup_service_edit' => 0,
        ]);
        $user = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        $this->createService($admin->id);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        // When
        // Then
        $this->actingAs($sup->user())
            ->call('GET', 'services/1/edit');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('GET', 'services/1/edit');
        $this->assertResponseStatus(403);

        $admin->tech_service_edit = 1;
        $admin->sup_service_edit = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('GET', 'services/1/edit');
        $this->assertResponseStatus(200);

        $this->actingAs($tech->user())
            ->call('GET', 'services/1/edit');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_authorizes_delete()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_service_destroy' => 0,
            'sup_service_destroy' => 0,
        ]);
        $user = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        $this->createService($admin->id);
        $this->createService($admin->id);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        // When
        // Then
        $this->actingAs($sup->user())
            ->call('DELETE', 'services/1');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('DELETE', 'services/2');
        $this->assertResponseStatus(403);

        $admin->tech_service_destroy = 1;
        $admin->sup_service_destroy = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('DELETE', 'services/1');
        $this->assertResponseStatus(302);

        $this->actingAs($tech->user())
            ->call('DELETE', 'services/2');
        $this->assertResponseStatus(302);
    }
}
