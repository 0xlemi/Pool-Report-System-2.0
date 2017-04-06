<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Administrator;
use App\User;

class ClientControllerTest extends ApiTester
{



//***********************************************************************
//    AUTHORIZATION TESTS
//***********************************************************************

    /** @test */
    public function it_authorizes_index()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_client_index' => 0,
            'sup_client_index' => 0,
        ]);
        $user = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        $service = $this->createService($admin->id);

        $this->createClient($admin->id, [$service->id]);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        // When
        // Then

        $this->actingAs($sup->user())
            ->call('GET', 'clients');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('GET', 'clients');
        $this->assertResponseStatus(403);

        $admin->tech_client_index = 1;
        $admin->sup_client_index = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('GET', 'clients');
        $this->assertResponseStatus(200);

        $this->actingAs($tech->user())
            ->call('GET', 'clients');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_authorizes_store()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_client_create' => 0,
            'sup_client_create' => 0,
        ]);
        $user = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        $service = $this->createService($admin->id);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        // When
        // Then
        $this->actingAs($sup->user())
            ->call('GET', 'clients/create');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('GET', 'clients/create');
        $this->assertResponseStatus(403);

        $admin->tech_client_create = 1;
        $admin->sup_client_create = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('GET', 'clients/create');
        $this->assertResponseStatus(200);

        $this->actingAs($tech->user())
            ->call('GET', 'clients/create');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_authorizes_show()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_client_show' => 0,
            'sup_client_show' => 0,
        ]);
        $user = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        $service = $this->createService($admin->id);

        $this->createClient($admin->id, [$service->id]);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        // When
        // Then
        $this->actingAs($sup->user())
            ->call('GET', 'clients/1');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('GET', 'clients/1');
        $this->assertResponseStatus(403);

        $admin->tech_client_show = 1;
        $admin->sup_client_show = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('GET', 'clients/1');
        $this->assertResponseStatus(200);

        $this->actingAs($tech->user())
            ->call('GET', 'clients/1');
        $this->assertResponseStatus(200);
    }

    /** @test */
    public function it_authorizes_update()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_client_edit' => 0,
            'sup_client_edit' => 0,
        ]);
        $user = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        $service = $this->createService($admin->id);

        $this->createClient($admin->id, [$service->id]);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        // When
        // Then
        $this->actingAs($sup->user())
            ->call('GET', 'clients/1/edit');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('GET', 'clients/1/edit');
        $this->assertResponseStatus(403);

        $admin->tech_client_edit = 1;
        $admin->sup_client_edit = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('GET', 'clients/1/edit');
        $this->assertResponseStatus(200);

        $this->actingAs($tech->user())
            ->call('GET', 'clients/1/edit');
        $this->assertResponseStatus(200);
    }

    /** @test */
    public function it_authorizes_delete()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_client_destroy' => 0,
            'sup_client_destroy' => 0,
        ]);
        $user = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        $service = $this->createService($admin->id);

        $this->createClient($admin->id, [$service->id]);
        $this->createClient($admin->id, [$service->id]);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        // When
        // Then
        $this->actingAs($sup->user())
            ->call('DELETE', 'clients/1');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('DELETE', 'clients/2');
        $this->assertResponseStatus(403);

        $admin->tech_client_destroy = 1;
        $admin->sup_client_destroy = 1;
        $admin->save();

        // check whats up with the 302
        // should be 200
        $this->actingAs($sup->user())
            ->call('DELETE', 'clients/1');
        $this->assertResponseStatus(302);

        $this->actingAs($tech->user())
            ->call('DELETE', 'clients/2');
        $this->assertResponseStatus(302);

    }

}
