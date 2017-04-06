<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Administrator;

class InvoiceAuthorizationTest extends ApiTester
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

        $this->createInvoice($workOrder);
    }


    //****************************************
    //               LIST
    //****************************************

    /** @test */
    public function it_authorizes_supervisor_to_list_invoice()
    {
        // Given
        // When
        $this->admin->sup_invoice_view = 1;
        $this->admin->save();
        // Then
        $this->actingAs($this->sup->user, 'api')
            ->json('GET', 'api/v1/invoices');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_unauthorizes_supervisor_to_list_invoice()
    {
        // Given
        // When
        $this->admin->sup_invoice_view = 0;
        $this->admin->save();
        // Then
        $this->actingAs($this->sup->user, 'api')
            ->json('GET', 'api/v1/invoices');
        $this->assertResponseStatus(403);

    }

    /** @test */
    public function it_authorizes_technician_to_list_invoice()
    {
        // Given
        // When
        $this->admin->tech_invoice_view = 1;
        $this->admin->save();
        // Then
        $this->actingAs($this->tech->user, 'api')
            ->json('GET', 'api/v1/invoices');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_unauthorizes_technician_to_list_invoice()
    {
        // Given
        // When
        $this->admin->tech_invoice_view = 0;
        $this->admin->save();
        // Then
        $this->actingAs($this->tech->user, 'api')
            ->json('GET', 'api/v1/invoices');
        $this->assertResponseStatus(403);
    }


    //****************************************
    //               VIEW
    //****************************************

    /** @test */
    public function it_authorizes_supervisor_to_view_invoice()
    {
        // Given
        // When
        $this->admin->sup_invoice_view = 1;
        $this->admin->save();
        // Then
        $this->actingAs($this->sup->user, 'api')
            ->json('GET', 'api/v1/invoices/10001');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_unauthorizes_supervisor_to_view_invoice()
    {
        // Given
        // When
        $this->admin->sup_invoice_view = 0;
        $this->admin->save();
        // Then
        $this->actingAs($this->sup->user, 'api')
            ->json('GET', 'api/v1/invoices/10001');
        $this->assertResponseStatus(403);

    }

    /** @test */
    public function it_authorizes_technician_to_view_invoice()
    {
        // Given
        // When
        $this->admin->tech_invoice_view = 1;
        $this->admin->save();
        // Then
        $this->actingAs($this->tech->user, 'api')
            ->json('GET', 'api/v1/invoices/10001');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_unauthorizes_technician_to_view_invoice()
    {
        // Given
        // When
        $this->admin->tech_invoice_view = 0;
        $this->admin->save();
        // Then
        $this->actingAs($this->tech->user, 'api')
            ->json('GET', 'api/v1/invoices/10001');
        $this->assertResponseStatus(403);
    }


    //****************************************
    //               DELETE
    //****************************************

    /** @test */
    public function it_authorizes_supervisor_to_delete_invoice()
    {
        // Given
        // When
        $this->admin->sup_invoice_delete = 1;
        $this->admin->save();
        // Then
        $this->actingAs($this->sup->user, 'api')
            ->json('DELETE', 'api/v1/invoices/10001');
        $this->assertResponseStatus(200);

    }

    /** @test */
    public function it_unauthorizes_supervisor_to_delete_invoice()
    {
        // Given
        // When
        $this->admin->sup_invoice_delete = 0;
        $this->admin->save();
        // Then
        $this->actingAs($this->sup->user, 'api')
            ->json('DELETE', 'api/v1/invoices/10001');
        $this->assertResponseStatus(403);

    }

}
