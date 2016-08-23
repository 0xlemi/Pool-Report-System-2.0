<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Administrator;
use App\User;

use App\Image;

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
    public function get_all_dates_that_have_at_least_one_report()
    {
        // Given
        $admin = $this->createAdministrator();
        $super = $this->createSupervisor($admin->id);
        $tech = $this->createTechnician($super->id);
        $ser = $this->createService($admin->id);
        $report1 = factory(App\Report::class)->create([
            'service_id' => $ser->id,
            'technician_id' => $tech->id,
            'completed' => Carbon::tomorrow('UTC'),
        ]);
        $report2 = factory(App\Report::class)->create([
            'service_id' => $ser->id,
            'technician_id' => $tech->id,
            'completed' => Carbon::today('UTC'),
        ]);
        $report3 = factory(App\Report::class)->create([
            'service_id' => $ser->id,
            'technician_id' => $tech->id,
            'completed' => Carbon::yesterday('UTC'),
        ]);

        // When
        $datesWithReport = $admin->datesWithReport();

        // Then
        $this->assertSameArray(
            $datesWithReport->toArray(),
            array(
                Carbon::tomorrow('UTC')->setTimezone($admin->timezone)->toDateString(),
                Carbon::today('UTC')->setTimezone($admin->timezone)->toDateString(),
                Carbon::yesterday('UTC')->setTimezone($admin->timezone)->toDateString(),
            )
        );

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
    public function get_services_that_need_to_be_done_in_date()
    {
        // Given
        $admin = $this->createAdministrator();
        $super = $this->createSupervisor($admin->id);
        $tech = $this->createTechnician($super->id);
        $ser1 = factory(App\Service::class)->create([
            // 21 represtents: Monday, Wednesday, Friday
            'service_days' => 21,
            'admin_id' => $admin->id,
        ]);
        $ser2 = factory(App\Service::class)->create([
            // 21 represtents: Monday, Tuesday
            'service_days' => 3,
            'admin_id' => $admin->id,
        ]);

        // When
        $servicesMon = $admin->servicesDoIn(new Carbon('last monday', $admin->timezone));
        $servicesWed = $admin->servicesDoIn(new Carbon('last wednesday', $admin->timezone));
        $servicesSat = $admin->servicesDoIn(new Carbon('last saturday', $admin->timezone));

        // Then
        $this->assertSameObject($ser1, $servicesMon->shift());
        $this->assertSameObject($ser2, $servicesMon->shift());
        $this->assertSameObject($ser1, $servicesWed[0]);
        $this->assertEmpty($servicesSat);

    }


    /** @test */
    public function it_gets_reports_by_date()
    {
        // Given
        $admin = $this->createAdministrator();
        $super1 = $this->createSupervisor($admin->id);
        $tech1 = $this->createTechnician($super1->id);
        $tech2 = $this->createTechnician($super1->id);
        $ser1 = $this->createService($admin->id);
        $report1 = factory(App\Report::class)->create([
            'service_id' => $ser1->id,
            'technician_id' => $tech1->id,
            'completed' => Carbon::tomorrow($admin->timezone),
        ]);
        $report2 = factory(App\Report::class)->create([
            'service_id' => $ser1->id,
            'technician_id' => $tech2->id,
            'completed' => Carbon::today($admin->timezone),
        ]);

        // When
        $date = Carbon::today($admin->timezone);
        $reports = $admin->reportsByDate($date)->get();

        // Then
        $this->assertEquals(1, sizeof($reports));
        $this->assertSameObject($report1, $reports[0]);


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

        $client1 = $this->createClient($admin1->id, [$ser1->id]);
        $client2 = $this->createClient($admin2->id, [$ser2->id]);
        $client3 = $this->createClient($admin2->id, [$ser2->id]);

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

        $client1 = $this->createClient($admin1->id, [$ser1->id]);
        $client2 = $this->createClient($admin2->id, [$ser2->id]);
        $client3 = $this->createClient($admin2->id, [$ser2->id]);

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

    /** @test */
    public function it_adds_image()
    {
        // Given
        $admin = $this->createAdministrator();

		$image1 = new Image;
        $image1->normal_path = 'normal/image/path1';
        $image1->thumbnail_path = 'thumbnail/image/path1';
        $image1->icon_path = 'icon/image/path1';
		$image2 = new Image;
        $image2->normal_path = 'normal/image/path2';
        $image2->thumbnail_path = 'thumbnail/image/path2';
        $image2->icon_path = 'icon/image/path2';

        // When
        $admin->addImage($image1);
        $admin->addImage($image2);

        $images = $admin->hasMany('App\Image', 'admin_id')->get();

        // Then
        $this->assertEquals(2, sizeof($images));
        $this->assertSameObject($image1, $images[0]);

    }

    /** @test */
    public function it_gets_images()
    {
        // Given
        $admin = $this->createAdministrator();

        $image1 = new Image;
        $image1->normal_path = 'normal/image/path1';
        $image1->thumbnail_path = 'thumbnail/image/path1';
        $image1->icon_path = 'icon/image/path1';
		$image2 = new Image;
        $image2->normal_path = 'normal/image/path2';
        $image2->thumbnail_path = 'thumbnail/image/path2';
        $image2->icon_path = 'icon/image/path2';

        $admin->addImage($image1);
        $admin->addImage($image2);

        // When
        $images = $admin->images()->get();

        // Then
        $this->assertEquals(2, sizeof($images));
        $this->assertSameObject($image1, $images[0]);

    }


}
