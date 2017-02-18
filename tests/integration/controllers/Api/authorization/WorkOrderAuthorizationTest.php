<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Administrator;

class WorkOrderAuthorizationTest extends ApiTester
{

    protected $admin;
    protected $sup;
    protected $tech;

    public function setUp()
    {
        parent::setUp();

        $this->withoutMiddleware();

        $this->admin = factory(Administrator::class)->create();
        $user = factory(User::class)->create([
            'userable_id' => $this->admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        $service = $this->createService($this->admin->id);

        $this->createClient($this->admin->id, [$service->id]);

        $this->sup = $this->createSupervisor($this->admin->id);

        $workOrder = $this->createWorkOrder($service, $this->sup);

        $this->tech = $this->createTechnician($this->sup->id);
    }


    //****************************************
    //               LIST
    //****************************************

    /** @test */
    public function it_authorizes_supervisor_to_list_workorder()
    {
        // Given
        // When
        $this->admin->sup_workorder_view = 1;
        $this->admin->save();
        // Then
        $this->actingAs($this->sup->user, 'api')
            ->json('GET', 'api/v1/workorders');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_unauthorizes_supervisor_to_list_workorder()
    {
        // Given
        // When
        $this->admin->sup_workorder_view = 0;
        $this->admin->save();
        // Then
        $this->actingAs($this->sup->user, 'api')
            ->json('GET', 'api/v1/workorders');
        $this->assertResponseStatus(403);

    }

    /** @test */
    public function it_authorizes_technician_to_list_workorder()
    {
        // Given
        // When
        $this->admin->tech_workorder_view = 1;
        $this->admin->save();
        // Then
        $this->actingAs($this->tech->user, 'api')
            ->json('GET', 'api/v1/workorders');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_unauthorizes_technician_to_list_workorder()
    {
        // Given
        // When
        $this->admin->tech_workorder_view = 0;
        $this->admin->save();
        // Then
        $this->actingAs($this->tech->user, 'api')
            ->json('GET', 'api/v1/workorders');
        $this->assertResponseStatus(403);
    }


    //****************************************
    //               VIEW
    //****************************************

    /** @test */
    public function it_authorizes_supervisor_to_view_workorder()
    {
        // Given
        // When
        $this->admin->sup_workorder_view = 1;
        $this->admin->save();
        // Then
        $this->actingAs($this->sup->user, 'api')
            ->json('GET', 'api/v1/workorders/10001');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_unauthorizes_supervisor_to_view_workorder()
    {
        // Given
        // When
        $this->admin->sup_workorder_view = 0;
        $this->admin->save();
        // Then
        $this->actingAs($this->sup->user, 'api')
            ->json('GET', 'api/v1/workorders/10001');
        $this->assertResponseStatus(403);

    }

    /** @test */
    public function it_authorizes_technician_to_view_workorder()
    {
        // Given
        // When
        $this->admin->tech_workorder_view = 1;
        $this->admin->save();
        // Then
        $this->actingAs($this->tech->user, 'api')
            ->json('GET', 'api/v1/workorders/10001');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_unauthorizes_technician_to_view_workorder()
    {
        // Given
        // When
        $this->admin->tech_workorder_view = 0;
        $this->admin->save();
        // Then
        $this->actingAs($this->tech->user, 'api')
            ->json('GET', 'api/v1/workorders/10001');
        $this->assertResponseStatus(403);
    }


    //****************************************
    //               CREATE
    //****************************************

    /** @test */
    public function it_authorizes_supervisor_to_create_workorder()
    {
        // Given
        // When
        $this->admin->sup_workorder_create = 1;
        $this->admin->save();
        // Then
        $this->actingAs($this->sup->user, 'api')
            ->json('POST', 'api/v1/workorders');
        $this->assertResponseStatus(422);

    }

    /** @test */
    public function it_unauthorizes_supervisor_to_create_workorder()
    {
        // Given
        // When
        $this->admin->sup_workorder_create = 0;
        $this->admin->save();
        // Then
        $this->actingAs($this->sup->user, 'api')
            ->json('POST', 'api/v1/workorders');
        $this->assertResponseStatus(403);

    }

    /** @test */
    public function it_authorizes_technician_to_create_workorder()
    {
        // Given
        // When
        $this->admin->tech_workorder_create = 1;
        $this->admin->save();
        // Then
        $this->actingAs($this->tech->user, 'api')
            ->json('POST', 'api/v1/workorders');
        $this->assertResponseStatus(422);

    }

    /** @test */
    public function it_unauthorizes_technician_to_create_workorder()
    {
        // Given
        // When
        $this->admin->tech_workorder_create = 0;
        $this->admin->save();
        // Then
        $this->actingAs($this->tech->user, 'api')
            ->json('POST', 'api/v1/workorders');
        $this->assertResponseStatus(403);
    }


    //****************************************
    //               UPDATE
    //****************************************

    /** @test */
    public function it_authorizes_supervisor_to_update_workorder()
    {
        // Given
        // When
        $this->admin->sup_workorder_update = 1;
        $this->admin->save();
        // Then
        $this->actingAs($this->sup->user, 'api')
            ->json('PATCH', 'api/v1/workorders/10001');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_unauthorizes_supervisor_to_update_workorder()
    {
        // Given
        // When
        $this->admin->sup_workorder_update = 0;
        $this->admin->save();
        // Then
        $this->actingAs($this->sup->user, 'api')
            ->json('PATCH', 'api/v1/workorders/10001');
        $this->assertResponseStatus(403);

    }

    /** @test */
    public function it_authorizes_technician_to_update_workorder()
    {
        // Given
        // When
        $this->admin->tech_workorder_update = 1;
        $this->admin->save();
        // Then
        $this->actingAs($this->tech->user, 'api')
            ->json('PATCH', 'api/v1/workorders/10001');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_unauthorizes_technician_to_update_workorder()
    {
        // Given
        // When
        $this->admin->tech_workorder_update = 0;
        $this->admin->save();
        // Then
        $this->actingAs($this->tech->user, 'api')
            ->json('PATCH', 'api/v1/workorders/10001');
        $this->assertResponseStatus(403);
    }

    //****************************************
    //              FINISH
    //****************************************

    /** @test */
    public function it_authorizes_supervisor_to_finish_workorder()
    {
        // Given
        // When
        $this->admin->sup_workorder_finish = 1;
        $this->admin->save();
        // Then
        $this->actingAs($this->sup->user, 'api')
            ->json('POST', 'api/v1/workorders/10001/finish');
        $this->assertResponseStatus(422);

    }

    /** @test */
    public function it_unauthorizes_supervisor_to_finish_workorder()
    {
        // Given
        // When
        $this->admin->sup_workorder_finish = 0;
        $this->admin->save();
        // Then
        $this->actingAs($this->sup->user, 'api')
            ->json('POST', 'api/v1/workorders/10001/finish');
        $this->assertResponseStatus(403);

    }

    /** @test */
    public function it_authorizes_technician_to_finish_workorder()
    {
        // Given
        // When
        $this->admin->tech_workorder_finish = 1;
        $this->admin->save();
        // Then
        $this->actingAs($this->tech->user, 'api')
            ->json('POST', 'api/v1/workorders/10001/finish');
        $this->assertResponseStatus(422);

    }

    /** @test */
    public function it_unauthorizes_technician_to_finish_workorder()
    {
        // Given
        // When
        $this->admin->tech_workorder_finish = 0;
        $this->admin->save();
        // Then
        $this->actingAs($this->tech->user, 'api')
            ->json('POST', 'api/v1/workorders/10001/finish');
        $this->assertResponseStatus(403);
    }


    //****************************************
    //               ADD PHOTO
    //****************************************

    // missing tests

    //****************************************
    //               REMOVE PHOTO
    //****************************************

    // missing tests


    //****************************************
    //               DELETE
    //****************************************

    /** @test */
    public function it_authorizes_supervisor_to_delete_workorder()
    {
        // Given
        // When
        $this->admin->sup_workorder_delete = 1;
        $this->admin->save();
        // Then
        $this->actingAs($this->sup->user, 'api')
            ->json('DELETE', 'api/v1/workorders/10001');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_unauthorizes_supervisor_to_delete_workorder()
    {
        // Given
        // When
        $this->admin->sup_workorder_delete = 0;
        $this->admin->save();
        // Then
        $this->actingAs($this->sup->user, 'api')
            ->json('DELETE', 'api/v1/workorders/10001');
        $this->assertResponseStatus(403);

    }

}
