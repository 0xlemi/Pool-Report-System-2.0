<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Client;

use App\Administrator;
use App\User;

class ClientApiTest extends ApiTester
{

/** @test */
public function it_can_show_list_clients()
{
    // Given
    $admin = $this->createAdministrator();

    $service1 = $this->createService($admin->id);
    $service2 = $this->createService($admin->id);
    $service3 = $this->createService($admin->id);

    $client1 = $this->createClient($admin->id, [$service1->id, $service2->id]);
    $client2 = $this->createClient($admin->id, [$service3->id]);

    // When
    // Then
    $this->json('GET', '/api/v1/clients', [
            'api_token' => $admin->user->api_token,
        ])->seeJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'last_name',
                    'email',
                    'cellphone',
                    'type',
                    'language',
                    'comments',
                    'services' => [
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
                            'photo',

                        ]
                    ]
                 ]
            ],
            'paginator' => [
                'total_count',
                'current_page',
                'total_pages',
                'limit',
            ]
        ]);

}

/** @test */
public function it_can_show_list_clients_no_services()
{
    // Given
    $admin = $this->createAdministrator();

    $client1 = $this->createClient($admin->id);

    // When
    // Then
    $this->json('GET', '/api/v1/clients', [
            'api_token' => $admin->user->api_token,
        ])->seeJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'last_name',
                    'email',
                    'cellphone',
                    'type',
                    'language',
                    'comments',
                    'services' => []
                 ]
            ]
        ]);
}

/** @test */
public function it_can_store_clients()
{
    // Given
    $serviceTransformer = \App::make('App\PRS\Transformers\ServiceTransformer');

    $admin = $this->createAdministrator();

    $this->createService($admin->id);
    $service1 = $admin->serviceBySeqId(1);

    $this->createService($admin->id);
    $service2 = $admin->serviceBySeqId(2);

    $this->createService($admin->id);
    $service3 = $admin->serviceBySeqId(3);

    // When
    // Then
    $this->json('POST', '/api/v1/clients',[
        'api_token' => $admin->user->api_token,
        'name'  => 'Luis',
        'last_name' => 'Espinosa',
        'cellphone' => '123456789',
        'type' => 1, // owner
        'language' => 'en',
        'comments' => 'This are the comments',
        'email' => 'clients123@example.com',
        'service_ids' => [1, 2, 3],
    ])->seeJsonEquals([
        'message' => 'The client was successfuly created.',
        'object' => [
            'id' => 1,
            'name' => 'Luis',
            'last_name' => 'Espinosa',
            'cellphone' => '123456789',
            'type' => 'Owner',
            'language' => 'en',
            'getReportsEmails' => 0,
            'comments' => 'This are the comments',
            'email' => 'clients123@example.com',
            'photo' => 'no image',
            'services' => [
                $serviceTransformer->transform($service1),
                $serviceTransformer->transform($service2),
                $serviceTransformer->transform($service3),
            ],
        ]
    ]);

    $this->assertResponseOk();
}

/** @test */
public function in_can_show_client()
{
    // Given
    $clientTransformer = \App::make('App\PRS\Transformers\ClientTransformer');

    $admin = $this->createAdministrator();

    $service1 = $this->createService($admin->id);
    $service2 = $this->createService($admin->id);
    $service3 = $this->createService($admin->id);

    $this->createClient(
                $admin->id,
                [$service1->id, $service2->id, $service3->id]
            );
    $client = $admin->clientsBySeqId(1);

    // When
    // Then
    $this->json('GET', '/api/v1/clients/1',[
            'api_token' => $admin->user->api_token,
        ])->seeJsonEquals([
            'data' =>
                $clientTransformer->transform($client)
        ]);

}

/** @test */
public function it_can_update_client()
{
    // Given
    $serviceTransformer = \App::make('App\PRS\Transformers\ServiceTransformer');

    $admin = $this->createAdministrator();

    $this->createService($admin->id);
    $service1 = $admin->serviceBySeqId(1);

    $this->createService($admin->id);
    $service2 = $admin->serviceBySeqId(2);

    $this->createService($admin->id);
    $service3 = $admin->serviceBySeqId(3);

    $this->createService($admin->id);
    $service4 = $admin->serviceBySeqId(4);

    $this->createClient($admin->id,[$service1->id, $service4->id]);

    // When
    // Then
    $this->json('PATCH', 'api/v1/clients/1', [
        'api_token' => $admin->user->api_token,
        'name'  => 'Luis',
        'last_name' => 'Espinosa',
        'cellphone' => '123456789',
        'type' => 1,
        'language' => 'en',
        'comments' => 'This are the comments',
        'email' => 'lem@example.com',
        'add_service_ids' => [2, 3, 4],
        'remove_service_ids' => [1],
    ])->seeJsonEquals([
        "message" => "The client was successfully updated.",
        "object" => [
            "id" => 1,
            'name'  => 'Luis',
            'last_name' => 'Espinosa',
            'cellphone' => '123456789',
            'type' => 'Owner',
            'language' => 'en',
            'comments' => 'This are the comments',
            'email' => 'lem@example.com',
            'services' => [
                $serviceTransformer->transform($service2),
                $serviceTransformer->transform($service3),
                $serviceTransformer->transform($service4),
            ]
        ]
    ]);

    }

    /** @test */
    public function it_can_destroy_clients()
    {
        // Given
        $admin = $this->createAdministrator();

        $service = $this->createService($admin->id);

        $client = $this->createClient($admin->id, [$service->id]);

        // When
        $this->json('DELETE', 'api/v1/clients/1', [
            'api_token' => $admin->user->api_token,
        ]);

        // Then
        $this->assertEquals(0, Client::all()->count());
    }

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
        $this->json('GET', 'api/v1/clients', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('GET', 'api/v1/clients', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_client_index = 1;
        $admin->sup_client_index = 1;
        $admin->save();

        $this->json('GET', 'api/v1/clients', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(200);

        $this->json('GET', 'api/v1/clients', [
            'api_token' => $tech->user()->api_token,
        ]);
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
        $this->json('POST', 'api/v1/clients', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('POST', 'api/v1/clients', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_client_create = 1;
        $admin->sup_client_create = 1;
        $admin->save();

        $this->json('POST', 'api/v1/clients', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(422);

        $this->json('POST', 'api/v1/clients', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(422);

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
        $this->json('GET', 'api/v1/clients/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('GET', 'api/v1/clients/1', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_client_show = 1;
        $admin->sup_client_show = 1;
        $admin->save();

        $this->json('GET', 'api/v1/clients/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(200);

        $this->json('GET', 'api/v1/clients/1', [
            'api_token' => $tech->user()->api_token,
        ]);
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
        $this->json('PATCH', 'api/v1/clients/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('PATCH', 'api/v1/clients/1', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_client_edit = 1;
        $admin->sup_client_edit = 1;
        $admin->save();

        $this->json('PATCH', 'api/v1/clients/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(200);

        $this->json('PATCH', 'api/v1/clients/1', [
            'api_token' => $tech->user()->api_token,
        ]);
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
        $this->json('DELETE', 'api/v1/clients/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('DELETE', 'api/v1/clients/2', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_client_destroy = 1;
        $admin->sup_client_destroy = 1;
        $admin->save();

        $this->json('DELETE', 'api/v1/clients/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(200);

        $this->json('DELETE', 'api/v1/clients/2', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(200);

    }

}
