<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Administrator;
use App\User;

use Carbon\Carbon;

class AdministratorTest extends ModelTester
{
    /** @test */
    public function it_gets_user()
    {
        // Given
        $admin = factory(Administrator::class)->create();
        $user_original = factory(User::class)->create([
            'userable_id' => $admin->id,
            'userable_type' => 'App\Administrator',
        ]);

        // When
        $user = $admin->user();

        // Then
        $this->assertSameObject($user_original, $user);
    }

    /** @test */
    public function it_gets_all_reports()
    {
        // Given
        $admin1 = $this->createAdministrator();
        $admin2 = $this->createAdministrator();
        $super1 = $this->createSupervisor($admin1->id);
        $tech1 = $this->createTechnician($super1->id);
        $tech2 = $this->createTechnician($super1->id);
        $ser1 = $this->createService($admin1->id);
        $report1 = factory(App\Report::class)->create([
            'service_id' => $ser1->id,
            'technician_id' => $tech1->id,
            'completed' => Carbon::tomorrow(),
        ]);
        $report2 = factory(App\Report::class)->create([
            'service_id' => $ser1->id,
            'technician_id' => $tech1->id,
            'completed' => Carbon::now(),
        ]);
        $report3 = factory(App\Report::class)->create([
            'service_id' => $ser1->id,
            'technician_id' => $tech2->id,
            'completed' => Carbon::yesterday(),
        ]);

        // When
        $reports = $admin1->reports()->get();

        // Then
        $this->assertSameObject($report1, $reports[0]);
        $this->assertSameObject($report3, $reports[2]);
    }

    /** @test */
    public function it_gets_reports_by_date()
    {
        // Given
        $admin1 = $this->createAdministrator();
        $admin2 = $this->createAdministrator();
        $super1 = $this->createSupervisor($admin1->id);
        $tech1 = $this->createTechnician($super1->id);
        $tech2 = $this->createTechnician($super1->id);
        $ser1 = $this->createService($admin1->id);
        $report1 = factory(App\Report::class)->create([
            'service_id' => $ser1->id,
            'technician_id' => $tech1->id,
            'completed' => Carbon::tomorrow(),
        ]);
        $report2 = factory(App\Report::class)->create([
            'service_id' => $ser1->id,
            'technician_id' => $tech1->id,
            'completed' => Carbon::now(),
        ]);

        // When
        $date = Carbon::today()->toDateString();
        $reports = $admin1->reportsByDate($date)->get();

        // Then
        $this->assertEquals(1, sizeof($reports));
        $this->assertSameObject($report2, $reports[0]);

    }

    /** @test */
    public function it_get_report_by_seq_id()
    {
        // Given
        $admin1 = $this->createAdministrator();
        $admin2 = $this->createAdministrator();

        $ser1 = $this->createService($admin1->id);
        $ser2 = $this->createService($admin2->id);

        $super1 = $this->createSupervisor($admin1->id);
        $super2 = $this->createSupervisor($admin2->id);

        $tech1 = $this->createTechnician($super1->id);
        $tech2 = $this->createTechnician($super2->id);

        $report1 = factory(App\Report::class)->create([
            'service_id' => $ser1->id,
            'technician_id' => $tech1->id,
            'completed' => Carbon::tomorrow(),
        ]);
        $report2 = factory(App\Report::class)->create([
            'service_id' => $ser2->id,
            'technician_id' => $tech2->id,
            'completed' => Carbon::now(),
        ]);
        $report3 = factory(App\Report::class)->create([
            'service_id' => $ser2->id,
            'technician_id' => $tech2->id,
            'completed' => Carbon::now(),
        ]);

        // When
        $report_1 = $admin1->reportsBySeqId(1);
        $report_2 = $admin2->reportsBySeqId(1);
        $report_3 = $admin2->reportsBySeqId(2);

        // Then
        $this->assertSameObject($report1, $report_1);
        $this->assertSameObject($report2, $report_2);
        $this->assertSameObject($report3, $report_3);

    }

    /** @test */
    public function it_gets_all_services()
    {
        // Given
        $admin1 = $this->createAdministrator();
        $admin2 = $this->createAdministrator();

        $ser1 = $this->createService($admin1->id);
        $ser2 = $this->createService($admin2->id);
        $ser3 = $this->createService($admin2->id);

        // When
        $services = $admin2->services()->get();

        // Then
        $this->assertEquals(2,sizeof($services));
        $this->assertSameObject($ser2, $services[0]);
        $this->assertSameObject($ser3, $services[1]);

    }

    /** @test */
    public function it_gets_services_by_seq_id()
    {
        // Given
        $admin1 = $this->createAdministrator();
        $admin2 = $this->createAdministrator();

        $ser1 = $this->createService($admin1->id);
        $ser2 = $this->createService($admin2->id);
        $ser3 = $this->createService($admin2->id);

        // When
        $ser_1 = $admin1->serviceBySeqId(1);
        $ser_2 = $admin2->serviceBySeqId(1);
        $ser_3 = $admin2->serviceBySeqId(2);

        // Then
        $this->assertSameObject($ser1, $ser_1);
        $this->assertSameObject($ser2, $ser_2);
        $this->assertSameObject($ser3, $ser_3);

    }

    /** @test */
    public function it_gets_all_clients()
    {
        // Given
        $admin1 = $this->createAdministrator();
        $admin2 = $this->createAdministrator();

        $ser1 = $this->createService($admin1->id);
        $ser2 = $this->createService($admin2->id);

        $client1 = $this->createClient([$ser1->id]);
        $client2 = $this->createClient([$ser2->id]);
        $client3 = $this->createClient([$ser2->id]);

        // When
        $clients = $admin2->clients()->get();

        // Then
        $this->assertEquals(2, sizeof($clients));
        $this->assertSameObject($client2, $clients[0]);
        $this->assertSameObject($client3, $clients[1]);

    }

    /** @test */
    public function it_gets_client_by_seq_id()
    {
        // Given
        $admin1 = $this->createAdministrator();
        $admin2 = $this->createAdministrator();

        $ser1 = $this->createService($admin1->id);
        $ser2 = $this->createService($admin2->id);

        $client1 = $this->createClient([$ser1->id]);
        $client2 = $this->createClient([$ser2->id]);
        $client3 = $this->createClient([$ser2->id]);

        // When
        $client_1 = $admin1->clientsBySeqId(1);
        $client_2 = $admin2->clientsBySeqId(1);
        $client_3 = $admin2->clientsBySeqId(2);

        // Then
        $this->assertSameObject($client1, $client_1);
        $this->assertSameObject($client2, $client_2);
        $this->assertSameObject($client3, $client_3);

    }

    /** @test */
    public function it_gets_supervisors()
    {
        // Given
        $admin1 = $this->createAdministrator();
        $admin2 = $this->createAdministrator();

        $super1 = $this->createSupervisor($admin1->id);
        $super2 = $this->createSupervisor($admin2->id);
        $super3 = $this->createSupervisor($admin2->id);

        // When
        $supervisors = $admin2->supervisors()->get();

        // Then
        $this->assertEquals(2, sizeof($supervisors));
        $this->assertSameObject($super2, $supervisors[0]);
        $this->assertSameObject($super3, $supervisors[1]);

    }

    /** @test */
    public function it_gets_supervisors_by_seq_id()
    {
        // Given
        $admin1 = $this->createAdministrator();
        $admin2 = $this->createAdministrator();

        $super1 = $this->createSupervisor($admin1->id);
        $super2 = $this->createSupervisor($admin2->id);
        $super3 = $this->createSupervisor($admin2->id);

        // When
        $super_1 = $admin1->supervisorBySeqId(1);
        $super_2 = $admin2->supervisorBySeqId(1);
        $super_3 = $admin2->supervisorBySeqId(2);

        // Then
        $this->assertSameObject($super1, $super_1);
        $this->assertSameObject($super2, $super_2);
        $this->assertSameObject($super3, $super_3);

    }

    /** @test */
    public function it_gets_all_technicians()
    {
        // Given
        $admin1 = $this->createAdministrator();
        $admin2 = $this->createAdministrator();

        $super1 = $this->createSupervisor($admin1->id);
        $super2 = $this->createSupervisor($admin2->id);

        $tech1 = $this->createTechnician($super1->id);
        $tech2 = $this->createTechnician($super2->id);
        $tech3 = $this->createTechnician($super2->id);

        // When
        $technicians = $admin2->technicians()->get();

        // Then
        $this->assertEquals(2, sizeof($technicians));
        $this->assertSameObject($tech2, $technicians[0]);
        $this->assertSameObject($tech3, $technicians[1]);

    }

    /** @test */
    public function it_gets_technicians_by_seq_id()
    {
        // Given
        $admin1 = $this->createAdministrator();
        $admin2 = $this->createAdministrator();

        $super1 = $this->createSupervisor($admin1->id);
        $super2 = $this->createSupervisor($admin2->id);

        $tech1 = $this->createTechnician($super1->id);
        $tech2 = $this->createTechnician($super2->id);
        $tech3 = $this->createTechnician($super2->id);

        // When
        $tech_1 = $admin1->technicianBySeqId(1);
        $tech_2 = $admin2->technicianBySeqId(1);
        $tech_3 = $admin2->technicianBySeqId(2);

        // Then
        $this->assertSameObject($tech1, $tech_1);
        $this->assertSameObject($tech2, $tech_2);
        $this->assertSameObject($tech3, $tech_3);

    }


}
