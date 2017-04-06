<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Supervisor;
use App\Administrator;
use App\User;

class SupervisorApiTest extends ApiTester
{

    /** @test */
    public function it_gets_supervisor_list()
    {
        // Given
        $admin = $this->createAdministrator();

        $sup1 = $this->createSupervisor($admin->id);
        $sup2 = $this->createSupervisor($admin->id);
        $sup3 = $this->createSupervisor($admin->id);

        // When
        // Then
        $this->json('GET', '/api/v1/supervisors', [
            'api_token' => $admin->user->api_token,
        ])->seeJsonStructure([
            'data' => [
                '*' => [
                     'id',
                     'name',
                     'last_name',
                     'email',
                     'cellphone',
                     'address',
                     'language',
                     'comments',
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
    public function it_can_create_new_supervisor()
    {
        // Given
        $admin = $this->createAdministrator();

        // When
        // Then
        $this->json('POST', '/api/v1/supervisors',[
            'api_token' => $admin->user->api_token,
            'name'  => 'Luis',
            'last_name' => 'Espinosa',
            'cellphone' => '123456789',
            'language' => 'en',
            'comments' => 'This are the comments',
            'email' => 'lem@example.com',
            'password' => 'password',
            'address' => 'street 123',
        ])->seeJsonEquals([
            'message' => 'The supervisor was successfuly created.',
            'object' => [
                'id' => 1,
                'name' => 'Luis',
                'last_name' => 'Espinosa',
                'cellphone' => '123456789',
                'language' => 'en',
                'comments' => 'This are the comments',
                'email' => 'lem@example.com',
                'address' => 'street 123',
            ]
        ]);

        $this->assertResponseOk();
    }

    /** @test */
    public function it_can_show_supervisor()
    {
        // Given
        $supervisorTransformer = \App::make('App\PRS\Transformers\SupervisorTransformer');

        $admin = $this->createAdministrator();

        $this->createSupervisor($admin->id);
        $sup1 = $admin->supervisorBySeqId(1);

        $this->createSupervisor($admin->id);
        $sup2 = $admin->supervisorBySeqId(2);

        // When
        // Then
        $this->json('GET', 'api/v1/supervisors/1', [
            'api_token' => $admin->user->api_token,
        ])->seeJsonEquals([
            'data' => $supervisorTransformer->transform($sup1)
        ]);

        $this->json('GET', 'api/v1/supervisors/2', [
            'api_token' => $admin->user->api_token,
        ])->seeJsonEquals([
            'data' => $supervisorTransformer->transform($sup2)
        ]);

        $this->assertResponseOk();

        $this->json('GET', 'api/v1/services/3', [
            'api_token' => $admin->user->api_token,
        ]);

        $this->assertResponseStatus(404);

    }

    /** @test */
    public function it_can_update_supervisor()
    {
        // Given
        $supervisorTransformer = \App::make('App\PRS\Transformers\SupervisorTransformer');

        $admin = $this->createAdministrator();

        $this->createSupervisor($admin->id);
        $sup1 = $admin->supervisorBySeqId(1);

        // When
        // Then
        $this->json('PATCH', 'api/v1/supervisors/1', [
            'api_token' => $admin->user->api_token,
            'name'  => 'Luis',
            'last_name' => 'Espinosa',
            'cellphone' => '123456789',
            'language' => 'en',
            'comments' => 'This are the comments',
            'email' => 'lem@example.com',
            'password' => 'password',
            'address' => 'street 123',
        ])->seeJsonEquals([
            "message" => "The supervisor was successfully updated.",
            "object" => [
                "id" => 1,
                'name'  => 'Luis',
                'last_name' => 'Espinosa',
                'cellphone' => '123456789',
                'language' => 'en',
                'comments' => 'This are the comments',
                'email' => 'lem@example.com',
                'address' => 'street 123',
            ]
        ]);
    }

    /** @test */
    public function it_can_destroy_supervisor()
    {
        // Given
        $supervisorTransformer = \App::make('App\PRS\Transformers\SupervisorTransformer');

        $admin = $this->createAdministrator();

        $this->createSupervisor($admin->id);

        // When
        $this->json('DELETE', 'api/v1/supervisors/1', [
            'api_token' => $admin->user->api_token,
        ]);

        // Then
        $this->assertEquals(0, Supervisor::all()->count());

    }

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
        $this->json('GET', 'api/v1/supervisors', [
            'api_token' => $sup->user->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('GET', 'api/v1/supervisors', [
            'api_token' => $tech->user->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_supervisor_index = 1;
        $admin->sup_supervisor_index = 1;
        $admin->save();

        $this->json('GET', 'api/v1/supervisors', [
            'api_token' => $sup->user->api_token,
        ]);
        $this->assertResponseStatus(200);

        $this->json('GET', 'api/v1/supervisors', [
            'api_token' => $tech->user->api_token,
        ]);
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
        $this->json('POST', 'api/v1/supervisors', [
            'api_token' => $sup->user->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('POST', 'api/v1/supervisors', [
            'api_token' => $tech->user->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_supervisor_create = 1;
        $admin->sup_supervisor_create = 1;
        $admin->save();

        $this->json('POST', 'api/v1/supervisors', [
            'api_token' => $sup->user->api_token,
        ]);
        $this->assertResponseStatus(422);

        $this->json('POST', 'api/v1/supervisors', [
            'api_token' => $tech->user->api_token,
        ]);
        $this->assertResponseStatus(422);

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
        $this->json('GET', 'api/v1/supervisors/1', [
            'api_token' => $sup->user->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('GET', 'api/v1/supervisors/1', [
            'api_token' => $tech->user->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_supervisor_show = 1;
        $admin->sup_supervisor_show = 1;
        $admin->save();

        $this->json('GET', 'api/v1/supervisors/1', [
            'api_token' => $sup->user->api_token,
        ]);
        $this->assertResponseStatus(200);

        $this->json('GET', 'api/v1/supervisors/1', [
            'api_token' => $tech->user->api_token,
        ]);
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
        $this->json('PATCH', 'api/v1/supervisors/1', [
            'api_token' => $sup->user->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('PATCH', 'api/v1/supervisors/1', [
            'api_token' => $tech->user->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_supervisor_edit = 1;
        $admin->sup_supervisor_edit = 1;
        $admin->save();

        $this->json('PATCH', 'api/v1/supervisors/1', [
            'api_token' => $sup->user->api_token,
        ]);
        $this->assertResponseStatus(200);

        $this->json('PATCH', 'api/v1/supervisors/1', [
            'api_token' => $tech->user->api_token,
        ]);
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
        $this->json('DELETE', 'api/v1/supervisors/1', [
            'api_token' => $sup->user->api_token,
        ]);
        $this->assertResponseStatus(403);

        $this->json('DELETE', 'api/v1/supervisors/2', [
            'api_token' => $tech->user->api_token,
        ]);
        $this->assertResponseStatus(403);

        $admin->tech_supervisor_destroy = 1;
        $admin->sup_supervisor_destroy = 1;
        $admin->save();

        $this->json('DELETE', 'api/v1/supervisors/1', [
            'api_token' => $sup->user->api_token,
        ]);
        $this->assertResponseStatus(200);

        $this->json('DELETE', 'api/v1/supervisors/2', [
            'api_token' => $tech->user->api_token,
        ]);
        $this->assertResponseStatus(200);

    }

}
