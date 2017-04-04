<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Administrator;
use App\User;
use App\Service;

class ServiceApiTest extends ApiTester
{


    /** @test */
    public function check_if_administrator_is_been_authentificated_if_not_throws_a_401()
    {
        $admin = $this->createAdministrator();

        $service1 = $this->createService($admin->id);
        $service2 = $this->createService($admin->id);

        $this->json('GET', '/api/v1/services');

        // unauthorized
        $this->assertResponseStatus(401);

        $this->json('GET', '/api/v1/services', [
            'api_token' => $admin->user->api_token,
        ]);

        $this->assertResponseOk();

    }


    /** @test */
    public function get_all_services_list()
    {
        $admin = $this->createAdministrator();

        $service1 = $this->createService($admin->id);
        $service2 = $this->createService($admin->id);
        $service3 = $this->createService($admin->id);

        $this->json('GET', '/api/v1/services', [
            'api_token' => $admin->user->api_token,
        ])->seeJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'address_line',
                    'city',
                    'state',
                    'postal_code',
                    'country',
                    'type',
                    'service_day_monday',
                    'service_day_tuesday',
                    'service_day_wednesday',
                    'service_day_thursday',
                    'service_day_friday',
                    'service_day_saturday',
                    'service_day_sunday',
                    'amount',
                    'currency',
                    'start_time',
                    'end_time',
                    'status',
                    'comments',
                    'icon_photo',
                    'thumbnail_photo',
                    'normal_photo',
                ]
            ],
            'paginator' => [
                'total_count',
                'current_page',
                'total_pages',
                'limit',
            ]
        ]);

      $this->assertResponseOk();
    }

    /** @test */
    public function user_can_create_new_service()
    {
        $admin = $this->createAdministrator();

        $this->json('POST', '/api/v1/services',[
            'api_token' => $admin->user->api_token,
            'name'  => 'Casa bonita',
            'address_line' => 'Cangrejos 123',
            'city' => 'San Jose del Cabo',
            'state' => 'Baja California Sur',
            'postal_code' => '23400',
            'country' => 'MX',
            'type' => 2,
            'service_day_monday' => 1,
            'service_day_tuesday' => 0,
            'service_day_wednesday' => 1,
            'service_day_thursday' => 0,
            'service_day_friday' => 1,
            'service_day_saturday' => 0,
            'service_day_sunday' => 0,
            'amount' => '350',
            'currency' => 'usd',
            'start_time' => '5:20',
            'end_time' => '14:35',
            'status' => true,
            'comments' => 'This are the test comments',
        ])->seeJsonEquals([
            "message" => "The service was successfuly created.",
            "object" => [
                "id" => 1,
                'name'  => 'Casa bonita',
                'address_line' => 'Cangrejos 123',
                'city' => 'San Jose del Cabo',
                'state' => 'Baja California Sur',
                'postal_code' => '23400',
                'country' => 'MX',
                'type' => 2,
                'service_day_monday' => true,
                'service_day_tuesday' => false,
                'service_day_wednesday' => true,
                'service_day_thursday' => false,
                'service_day_friday' => true,
                'service_day_saturday' => false,
                'service_day_sunday' => false,
                'amount' => '350.00',
                'currency' => 'USD',
                'start_time' => '05:20:00',
                'end_time' => '14:35:00',
                'status' => true,
                'comments' => 'This are the test comments',
                "icon_photo" => "https://localhost/img/avatar-2-48.png",
                "thumbnail_photo" => "https://localhost/img/no_image.png",
                "normal_photo" => "https://localhost/img/no_image.png"
            ]
        ]);
    }

    /** @test */
    public function it_can_show_services()
    {
        // Given
        $serviceTransformer = \App::make('App\PRS\Transformers\ServiceTransformer');

        $admin = $this->createAdministrator();

        $this->createService($admin->id);
        $service1 = $admin->services()->bySeqId(1);

        $this->createService($admin->id);
        $service2 = $admin->services()->bySeqId(2);

        // When
        // Then

        $this->json('GET', 'api/v1/services/1', [
            'api_token' => $admin->user->api_token,
        ])->seeJsonEquals([
            'data' => $serviceTransformer->transform($service1)
        ]);

        $this->json('GET', 'api/v1/services/2', [
            'api_token' => $admin->user->api_token,
        ])->seeJsonEquals([
            'data' => $serviceTransformer->transform($service2)
        ]);

        $this->assertResponseOk();

        $this->json('GET', 'api/v1/services/3', [
            'api_token' => $admin->user->api_token,
        ]);

        $this->assertResponseStatus(404);

    }

    /** @test */
    public function it_can_update_services()
    {
        // Given
        $admin = $this->createAdministrator();

        $this->createService($admin->id);
        $service1 = $admin->services()->bySeqId(1);

        $this->createService($admin->id);
        $service2 = $admin->services()->bySeqId(2);

        // When
        // Then
        $this->json('PATCH', 'api/v1/services/2', [
            'api_token' => $admin->user->api_token,
            'name'  => 'Casa bonita',
            'address_line' => 'Cangrejos 123',
            'city' => 'San Jose del Cabo',
            'state' => 'Baja California Sur',
            'postal_code' => '23400',
            'country' => 'MX',
            'type' => 2,
            'service_day_monday' => 1,
            'service_day_tuesday' => 0,
            'service_day_wednesday' => 1,
            'service_day_thursday' => 0,
            'service_day_friday' => 1,
            'service_day_saturday' => 0,
            'service_day_sunday' => 0,
            'amount' => '350',
            'currency' => 'usd',
            'start_time' => '5:20',
            'end_time' => '14:35',
            'status' => true,
            'comments' => 'This are the test comments',
        ])->seeJsonEquals([
            "message" => "The service was successfully updated.",
            "object" => [
                "id" => 2,
                'name'  => 'Casa bonita',
                'address_line' => 'Cangrejos 123',
                'city' => 'San Jose del Cabo',
                'state' => 'Baja California Sur',
                'postal_code' => '23400',
                'country' => 'MX',
                'type' => 2,
                'service_day_monday' => true,
                'service_day_tuesday' => false,
                'service_day_wednesday' => true,
                'service_day_thursday' => false,
                'service_day_friday' => true,
                'service_day_saturday' => false,
                'service_day_sunday' => false,
                'amount' => '350.00',
                'currency' => 'USD',
                'start_time' => '05:20:00',
                'end_time' => '14:35:00',
                'status' => true,
                'comments' => 'This are the test comments',
                "icon_photo" => "https://localhost/img/avatar-2-48.png",
                "thumbnail_photo" => "https://localhost/img/no_image.png",
                "normal_photo" => "https://localhost/img/no_image.png"
            ]
        ]);

    }

    /** @test */
    public function it_can_destroy_service()
    {
        // Given
        $admin = $this->createAdministrator();

        $this->createService($admin->id);

        // When
        $this->json('DELETE', 'api/v1/services/1', [
            'api_token' => $admin->user->api_token,
        ]);

        // Then
        $this->assertEquals(0, Service::all()->count());

    }


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
        $this->json('GET', 'api/v1/services', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('GET', 'api/v1/services', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_service_index = 1;
        $admin->sup_service_index = 1;
        $admin->save();

        $this->json('GET', 'api/v1/services', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(200);

        $this->json('GET', 'api/v1/services', [
            'api_token' => $tech->user()->api_token,
        ]);
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
        $this->json('POST', 'api/v1/services', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('POST', 'api/v1/services', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_service_create = 1;
        $admin->sup_service_create = 1;
        $admin->save();

        $this->json('POST', 'api/v1/services', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(422);

        $this->json('POST', 'api/v1/services', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(422);

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
        $this->json('GET', 'api/v1/services/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('GET', 'api/v1/services/1', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_service_show = 1;
        $admin->sup_service_show = 1;
        $admin->save();

        $this->json('GET', 'api/v1/services/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(200);

        $this->json('GET', 'api/v1/services/1', [
            'api_token' => $tech->user()->api_token,
        ]);
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
        $this->json('PATCH', 'api/v1/services/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('PATCH', 'api/v1/services/1', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_service_edit = 1;
        $admin->sup_service_edit = 1;
        $admin->save();

        $this->json('PATCH', 'api/v1/services/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(200);

        $this->json('PATCH', 'api/v1/services/1', [
            'api_token' => $tech->user()->api_token,
        ]);
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
        $this->json('DELETE', 'api/v1/services/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('DELETE', 'api/v1/services/2', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_service_destroy = 1;
        $admin->sup_service_destroy = 1;
        $admin->save();

        $this->json('DELETE', 'api/v1/services/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(200);

        $this->json('DELETE', 'api/v1/services/2', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(200);

    }

}
