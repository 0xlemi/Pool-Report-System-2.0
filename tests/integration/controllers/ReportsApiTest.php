<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Carbon\Carbon;

use App\Administrator;
use App\User;
use App\Report;
use App\Service;

class ReportsApiTest extends ApiTester
{

    /** @test */
    public function it_can_show_list_reports()
    {
        // Given
        $admin = $this->createAdministrator();

        $service = $this->createService($admin->id);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        $rep1 = $this->createReport($service->id, $tech->id);
        $rep2 = $this->createReport($service->id, $tech->id);
        $rep3 = $this->createReport($service->id, $tech->id);

        // When
        // Then
        $this->json('GET', '/api/v1/reports', [
            'api_token' => $admin->user()->api_token,
        ])->seeJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'completed',
                    'on_time',
                    'ph',
                    'clorine',
                    'temperature',
                    'turbidity',
                    'salt',
                    'latitude',
                    'longitude',
                    'altitude',
                    'accuracy',
                    'service_id',
                    'technician_id',
                ]
            ]
        ]);
      $this->assertResponseOk();
    }

    /** @test */
    public function it_can_show_list_reports_by_date()
    {
        // Given
        $reportTransformer = \App::make('App\PRS\Transformers\ReportTransformer');

        $admin = $this->createAdministrator();

        $service = $this->createService($admin->id);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        factory(App\Report::class)->create([
            'completed' => Carbon::today(),
            'service_id' => $service->id,
            'technician_id' => $tech->id,
        ]);
        $rep1 = $admin->reportsBySeqId(1);

        factory(App\Report::class)->create([
            'completed' => Carbon::today(),
            'service_id' => $service->id,
            'technician_id' => $tech->id,
        ]);
        $rep2 = $admin->reportsBySeqId(2);

        factory(App\Report::class)->create([
            'completed' => Carbon::tomorrow(),
            'service_id' => $service->id,
            'technician_id' => $tech->id,
        ]);
        $rep3 = $admin->reportsBySeqId(3);

        // When
        // Then
        $this->json('GET', '/api/v1/reports',[
            'api_token' => $admin->user()->api_token,
            'date' => Carbon::today()->toDateString(),
        ])->seeJsonEquals([
            'data' => [
                $reportTransformer->transform($rep1),
                $reportTransformer->transform($rep2),
            ]
        ]);

        $this->json('GET', '/api/v1/reports',[
            'api_token' => $admin->user()->api_token,
            'date' => Carbon::tomorrow()->toDateString(),
        ])->seeJsonEquals([
            'data' => [
                $reportTransformer->transform($rep3),
            ]
        ]);

        $this->json('GET', '/api/v1/reports',[
            'api_token' => $admin->user()->api_token,
            'date' => Carbon::yesterday()->toDateString(),
        ])->seeJsonEquals([
            'data' => []
        ]);
    }

    /** @test */
    public function it_can_create_report()
    {
        // Given
        $admin = $this->createAdministrator();

        $service = factory(Service::class)->create([
            'start_time' => '7:35:00',
            'end_time' => '9:30:00',
            'admin_id' => $admin->id,
        ]);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        // When
        // Then
        $this->json('POST', '/api/v1/reports',[
            'api_token' => $admin->user()->api_token,
            'completed' => '2016-06-25 8:23:00',
            'ph' => 2,
            'clorine' => 4,
            'temperature' => 1,
            'turbidity' => 4,
            'salt' => 2,
            'latitude' => 83.123456,
            'longitude' => -112.123456,
            'altitude' => 2.23,
            'accuracy' => 5.23,
            'service_id' => $service->id,
            'technician_id' => $tech->id,
        ])->seeJsonEquals([
            "message" => "The report was successfuly created.",
            "object" => [
                "id" => 1,
                'completed' => '2016-06-25 08:23:00',
                'on_time' => 1,
                'ph' => 2,
                'clorine' => 4,
                'temperature' => 1,
                'turbidity' => 4,
                'salt' => 2,
                'latitude' => "83.123456",
                'longitude' => "-112.123456",
                'altitude' => "2.23",
                'accuracy' => "5.23",
                'service_id' => $service->id,
                'technician_id' => $tech->id,
            ]
        ]);

    }

    /** @test */
    public function it_can_show_reports()
    {
        // Given
        $reportTransformer = \App::make('App\PRS\Transformers\ReportTransformer');

        $admin = $this->createAdministrator();

        $service = $this->createService($admin->id);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        $this->createReport($service->id, $tech->id);
        $rep1 = $admin->reportsBySeqId(1);

        $this->createReport($service->id, $tech->id);
        $rep2 = $admin->reportsBySeqId(2);

        // When
        // Then

        $this->json('GET', 'api/v1/reports/1', [
            'api_token' => $admin->user()->api_token,
        ])->seeJsonEquals([
            'data' => $reportTransformer->transform($rep1)
        ]);

        $this->json('GET', 'api/v1/reports/2', [
            'api_token' => $admin->user()->api_token,
        ])->seeJsonEquals([
            'data' => $reportTransformer->transform($rep2)
        ]);

        $this->assertResponseOk();

        $this->json('GET', 'api/v1/reports/3', [
            'api_token' => $admin->user()->api_token,
        ]);

        $this->assertResponseStatus(404);

    }

    /** @test */
    public function it_can_update_report()
    {
        // Given
        $admin = $this->createAdministrator();

        $service = factory(Service::class)->create([
            'start_time' => '7:35:00',
            'end_time' => '9:30:00',
            'admin_id' => $admin->id,
        ]);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        $this->createReport($service->id, $tech->id);
        $rep = $admin->reportsBySeqId(1);

        // When
        // Then
        $this->json('PATCH', 'api/v1/reports/1', [
            'api_token' => $admin->user()->api_token,
            'completed' => '2016-06-25 10:23:00',
            'ph' => 2,
            'clorine' => 4,
            'temperature' => 1,
            'turbidity' => 4,
            'salt' => 2,
            'latitude' => 83.123456,
            'longitude' => -112.123456,
            'altitude' => 2.23,
            'accuracy' => 5.23,
            'service_id' => $service->id,
            'technician_id' => $tech->id,
        ])->seeJsonEquals([
            'message' => 'The report was successfully updated.',
            'object' => [
                'id' => 1,
                'completed' => '2016-06-25 10:23:00',
                'on_time' => 2, //late
                'ph' => 2,
                'clorine' => 4,
                'temperature' => 1,
                'turbidity' => 4,
                'salt' => 2,
                'latitude' => '83.123456',
                'longitude' => '-112.123456',
                'altitude' => '2.23',
                'accuracy' => '5.23',
                'service_id' => 1,
                'technician_id' => 1,
            ]
        ]);

    }

    /** @test */
    public function it_can_destroy_report()
    {
        // Given
        $admin = $this->createAdministrator();

        $service = $this->createService($admin->id);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        $this->createReport($service->id, $tech->id);

        // When
        $this->json('DELETE', 'api/v1/reports/1', [
            'api_token' => $admin->user()->api_token,
        ]);

        // Then
        $this->assertEquals(0, Report::all()->count());

    }

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
        $this->json('GET', 'api/v1/reports', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('GET', 'api/v1/reports', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_report_index = 1;
        $admin->sup_report_index = 1;
        $admin->save();

        $this->json('GET', 'api/v1/reports', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(200);

        $this->json('GET', 'api/v1/reports', [
            'api_token' => $tech->user()->api_token,
        ]);
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
        $this->json('POST', 'api/v1/reports', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('POST', 'api/v1/reports', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_report_create = 1;
        $admin->sup_report_create = 1;
        $admin->save();

        $this->json('POST', 'api/v1/reports', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(422);

        $this->json('POST', 'api/v1/reports', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(422);

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
        $this->json('GET', 'api/v1/reports/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('GET', 'api/v1/reports/1', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_report_show = 1;
        $admin->sup_report_show = 1;
        $admin->save();

        $this->json('GET', 'api/v1/reports/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(200);

        $this->json('GET', 'api/v1/reports/1', [
            'api_token' => $tech->user()->api_token,
        ]);
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
        $this->json('PATCH', 'api/v1/reports/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('PATCH', 'api/v1/reports/1', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_report_edit = 1;
        $admin->sup_report_edit = 1;
        $admin->save();

        $this->json('PATCH', 'api/v1/reports/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(422);

        $this->json('PATCH', 'api/v1/reports/1', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(422);

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
        $this->json('DELETE', 'api/v1/reports/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('DELETE', 'api/v1/reports/2', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_report_destroy = 1;
        $admin->sup_report_destroy = 1;
        $admin->save();

        $this->json('DELETE', 'api/v1/reports/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(200);

        $this->json('DELETE', 'api/v1/reports/2', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(200);

    }

}
