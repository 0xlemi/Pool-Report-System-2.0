<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Administrator;
use App\User;

class ReportControllerTest extends ApiTester
{




//***********************************************************************
//    AUTHORIZATION TESTS
//***********************************************************************

    /** @test */
    public function it_authorizes_index()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_report_index' => 0,
            'sup_report_index' => 0,
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
            ->call('GET', 'reports');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('GET', 'reports');
        $this->assertResponseStatus(403);

        $admin->tech_report_index = 1;
        $admin->sup_report_index = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('GET', 'reports');
        $this->assertResponseStatus(200);

        $this->actingAs($tech->user())
            ->call('GET', 'reports');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_authorizes_store()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_report_create' => 0,
            'sup_report_create' => 0,
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
            ->call('GET', 'reports/create');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('GET', 'reports/create');
        $this->assertResponseStatus(403);

        $admin->tech_report_create = 1;
        $admin->sup_report_create = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('GET', 'reports/create');
        $this->assertResponseStatus(200);

        $this->actingAs($tech->user())
            ->call('GET', 'reports/create');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_authorizes_show()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_report_show' => 0,
            'sup_report_show' => 0,
        ]);
        $user = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        $service = $this->createService($admin->id);

        $this->createClient($admin->id, [$service->id]);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        $this->createReport($service->id, $tech->id);

        // When
        // Then
        $this->actingAs($sup->user())
            ->call('GET', 'reports/1');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('GET', 'reports/1');
        $this->assertResponseStatus(403);

        $admin->tech_report_show = 1;
        $admin->sup_report_show = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('GET', 'reports/1');
        $this->assertResponseStatus(200);

        $this->actingAs($tech->user())
            ->call('GET', 'reports/1');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_authorizes_update()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_report_edit' => 0,
            'sup_report_edit' => 0,
        ]);
        $user = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        $service = $this->createService($admin->id);

        $this->createClient($admin->id, [$service->id]);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        $this->createReport($service->id, $tech->id);

        // When
        // Then
        $this->actingAs($sup->user())
            ->call('GET', 'reports/1/edit');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('GET', 'reports/1/edit');
        $this->assertResponseStatus(403);

        $admin->tech_report_edit = 1;
        $admin->sup_report_edit = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('GET', 'reports/1/edit');
        $this->assertResponseStatus(200);

        $this->actingAs($tech->user())
            ->call('GET', 'reports/1/edit');
        $this->assertResponseStatus(200);
    }

    /** @test */
    public function it_authorizes_delete()
    {
        // Given
        $admin = factory(Administrator::class)->create([
            'tech_report_destroy' => 0,
            'sup_report_destroy' => 0,
        ]);
        $user = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        $service = $this->createService($admin->id);

        $this->createClient($admin->id, [$service->id]);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        $this->createReport($service->id, $tech->id);
        $this->createReport($service->id, $tech->id);

        // When
        // Then
        $this->actingAs($sup->user())
            ->call('DELETE', 'reports/1');
        $this->assertResponseStatus(403);

        $this->actingAs($tech->user())
            ->call('DELETE', 'reports/2');
        $this->assertResponseStatus(403);

        $admin->tech_report_destroy = 1;
        $admin->sup_report_destroy = 1;
        $admin->save();

        $this->actingAs($sup->user())
            ->call('DELETE', 'reports/1');
        $this->assertResponseStatus(302);

        $this->actingAs($tech->user())
            ->call('DELETE', 'reports/2');
        $this->assertResponseStatus(302);

    }


}
