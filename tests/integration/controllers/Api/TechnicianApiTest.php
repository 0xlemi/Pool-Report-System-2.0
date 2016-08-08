<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Technician;
use App\Administrator;
use App\User;


class TechnicianApiTest extends ApiTester
{

    /** @test */
    public function it_can_show_list_technicians()
    {
        // Given
        $admin = $this->createAdministrator();

        $sup = $this->createSupervisor($admin->id);

        $tech1 = $this->createTechnician($sup->id);
        $tech2 = $this->createTechnician($sup->id);
        $tech3 = $this->createTechnician($sup->id);

        // When
        // Then
        $this->json('GET', '/api/v1/technicians', [
            'api_token' => $admin->user()->api_token,
        ])->seeJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'last_name',
                    'username',
                    'cellphone',
                    'address',
                    'language',
                    'comments',
                    'supervisor' => [
                        'id',
                        'name',
                        'last_name',
                        'email',
                        'cellphone',
                        'address',
                        'language',
                        'comments',
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
    public function it_can_create_new_technician()
    {
        // Given
        $supervisorTransformer = \App::make('App\PRS\Transformers\SupervisorTransformer');

        $admin = $this->createAdministrator();

        $this->createSupervisor($admin->id);
        $sup = $admin->supervisorBySeqId(1);

        // When
        // Then
        $this->json('POST', '/api/v1/technicians',[
            'api_token' => $admin->user()->api_token,
            'name'  => 'Luis',
            'last_name' => 'Espinosa',
            'cellphone' => '123456789',
            'language' => 'en',
            'comments' => 'This are the comments',
            'username' => 'username_123',
            'password' => 'password',
            'address' => 'street 123',
            'supervisor' => $sup->seq_id,
        ])->seeJsonEquals([
            'message' => 'The technician was successfuly created.',
            'object' => [
                'id' => 1,
                'name' => 'Luis',
                'last_name' => 'Espinosa',
                'cellphone' => '123456789',
                'language' => 'en',
                'comments' => 'This are the comments',
                'username' => 'username_123',
                'address' => 'street 123',
                'supervisor' =>
                    $supervisorTransformer->transform($sup)
            ]
        ]);

        $this->assertResponseOk();
    }

    /** @test */
    public function it_can_show_technician()
    {
        // Given
        $supervisorTransformer = \App::make('App\PRS\Transformers\SupervisorTransformer');
        $technicianTransformer = \App::make('App\PRS\Transformers\TechnicianTransformer');

        $admin = $this->createAdministrator();

        $sup = $this->createSupervisor($admin->id);

        $this->createTechnician($sup->id);
        $tech1 = $admin->technicianBySeqId(1);
        $this->createTechnician($sup->id);
        $tech2 = $admin->technicianBySeqId(2);

        // When
        // Then
        $this->json('GET', '/api/v1/technicians/2',[
            'api_token' => $admin->user()->api_token,
        ])->seeJsonEquals([
            'data' =>
                $technicianTransformer->transform($tech2)
        ]);

    }

    /** @test */
    public function it_can_update_technician()
    {
        $supervisorTransformer = \App::make('App\PRS\Transformers\SupervisorTransformer');

        // Given
        $admin = $this->createAdministrator();

        $sup1 = $this->createSupervisor($admin->id);

        $this->createSupervisor($admin->id);
        $sup2 = $admin->supervisorBySeqId(2);

        $this->createTechnician($sup1->id);

        // When
        // Then
        $this->json('PATCH', 'api/v1/technicians/1', [
            'api_token' => $admin->user()->api_token,
            'name'  => 'Luis',
            'last_name' => 'Espinosa',
            'cellphone' => '123456789',
            'language' => 'en',
            'comments' => 'This are the comments',
            'username' => 'username_345',
            'password' => 'password',
            'address' => 'street 123',
            'supervisor' => 2,
        ])->seeJsonEquals([
            "message" => "The technician was successfully updated.",
            "object" => [
                "id" => 1,
                'name'  => 'Luis',
                'last_name' => 'Espinosa',
                'cellphone' => '123456789',
                'language' => 'en',
                'comments' => 'This are the comments',
                'username' => 'username_345',
                'address' => 'street 123',
                'supervisor' =>
                    $supervisorTransformer->transform($sup2),
            ]
        ]);
    }

    /** @test */
    public function it_can_destroy_technician()
    {
        // Given

        $admin = $this->createAdministrator();

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        // When
        $this->json('DELETE', 'api/v1/technicians/1', [
            'api_token' => $admin->user()->api_token,
        ]);

        // Then
        $this->assertEquals(0, Technician::all()->count());

    }

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
        $this->json('GET', 'api/v1/technicians', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('GET', 'api/v1/technicians', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_technician_index = 1;
        $admin->sup_technician_index = 1;
        $admin->save();

        $this->json('GET', 'api/v1/technicians', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(200);

        $this->json('GET', 'api/v1/technicians', [
            'api_token' => $tech->user()->api_token,
        ]);
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
        $this->json('POST', 'api/v1/technicians', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('POST', 'api/v1/technicians', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_technician_create = 1;
        $admin->sup_technician_create = 1;
        $admin->save();

        $this->json('POST', 'api/v1/technicians', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(422);

        $this->json('POST', 'api/v1/technicians', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(422);

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
        $this->json('GET', 'api/v1/technicians/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('GET', 'api/v1/technicians/1', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_technician_show = 1;
        $admin->sup_technician_show = 1;
        $admin->save();

        $this->json('GET', 'api/v1/technicians/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(200);

        $this->json('GET', 'api/v1/technicians/1', [
            'api_token' => $tech->user()->api_token,
        ]);
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
        $this->json('PATCH', 'api/v1/technicians/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('PATCH', 'api/v1/technicians/1', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_technician_edit = 1;
        $admin->sup_technician_edit = 1;
        $admin->save();

        $this->json('PATCH', 'api/v1/technicians/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(200);

        $this->json('PATCH', 'api/v1/technicians/1', [
            'api_token' => $tech->user()->api_token,
        ]);
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
        $this->json('DELETE', 'api/v1/technicians/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('DELETE', 'api/v1/technicians/2', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_technician_destroy = 1;
        $admin->sup_technician_destroy = 1;
        $admin->save();

        $this->json('DELETE', 'api/v1/technicians/1', [
            'api_token' => $sup->user()->api_token,
        ]);
        $this->assertResponseStatus(200);

        $this->json('DELETE', 'api/v1/technicians/2', [
            'api_token' => $tech->user()->api_token,
        ]);
        $this->assertResponseStatus(200);

    }


}
