<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Image;
use Carbon\Carbon;

class ServiceTest extends ModelTester
{

    /** @test */
    public function it_gets_admin()
    {
        // Given
        $admin = $this->createAdministrator();

        $service = $this->createService($admin->id);

        // When
        $administrator = $service->admin()->first();

        // Then
        $this->assertSameObject($admin, $administrator);

    }

    /** @test */
    public function it_gets_clients()
    {
        // Given
        $admin = $this->createAdministrator();

        $service1 = $this->createService($admin->id);
        $service2 = $this->createService($admin->id);

        $client1 = $this->createClient($admin->id, [$service1->id]);
        $client2 = $this->createClient($admin->id, [$service2->id]);
        $client3 = $this->createClient($admin->id, [$service2->id]);

        // When
        $clients = $service2->clients()->get();

        // Then
        $this->assertEquals(2, sizeof($clients));
        $this->assertSameArray(
                array_flat($client2->toArray()),
                array_flat($clients[0]->toArray())
            );
        $this->assertSameArray(
                array_flat($client3->toArray()),
                array_flat($clients[1]->toArray())
            );

    }

    /** @test */
    public function it_gets_reports()
    {
        // Given
        $admin = $this->createAdministrator();

        $service1 = $this->createService($admin->id);
        $service2 = $this->createService($admin->id);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        $report1 = $this->createReport($service1->id, $tech->id);
        $report2 = $this->createReport($service2->id, $tech->id);
        $report3 = $this->createReport($service2->id, $tech->id);

        // When
        $reports = $service2->reports()->get();

        // Then
        $this->assertEquals(2, sizeof($reports));
        $this->assertSameObject($report2, $reports[0]);
        $this->assertSameObject($report3, $reports[1]);

    }

    /** @test */
    public function it_gets_service_contract()
    {
        // Given
        $admin = $this->createAdministrator();

        $service1 = $this->createService($admin->id);
        $service2 = $this->createService($admin->id);

        $contract1 = $this->createServiceContract($service1->id);
        $contract2 = $this->createServiceContract($service2->id);

        // When

        // Then


    }

    /** @test */
    public function if_is_scheduled_for_date()
    {
        // Given
        $admin = $this->createAdministrator();

        $service1 = factory(App\Service::class)->create([
            'admin_id' => $admin->id,
            // 42 is tuesday, thursday, saturday
            'service_days' => 42,
        ]);
        $service2 = factory(App\Service::class)->create([
            'admin_id' => $admin->id,
            // 89 is monday, thursday, friday, sunday
            'service_days' => 89,
        ]);

        // When
        // Then
        $this->assertTrue($service1->checkIfIsDo(new Carbon('last saturday', $admin->timezone)));
        $this->assertTrue($service1->checkIfIsDo(new Carbon('last tuesday', $admin->timezone)));
        $this->assertFalse($service1->checkIfIsDo(new Carbon('last sunday', $admin->timezone)));
        $this->assertTrue($service2->checkIfIsDo(new Carbon('last friday', $admin->timezone)));
        $this->assertTrue($service2->checkIfIsDo(new Carbon('last sunday', $admin->timezone)));
        $this->assertFalse($service2->checkIfIsDo(new Carbon('last tuesday', $admin->timezone)));

    }

    /** @test */
    public function if_a_report_was_done_for_this_service_in_this_date()
    {
        // Given
        $admin = $this->createAdministrator();

        $service = $this->createService($admin->id);

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        $report1 = factory(App\Report::class)->create([
            'service_id' => $service->id,
            'technician_id' => $tech->id,
            'completed' => (new Carbon('last saturday', $admin->timezone))->setTimezone('UTC')->toDateTimeString(),
        ]);
        $report2 = factory(App\Report::class)->create([
            'service_id' => $service->id,
            'technician_id' => $tech->id,
            'completed' => (new Carbon('last tuesday', $admin->timezone))->setTimezone('UTC')->toDateTimeString(),
        ]);
        $report3 = factory(App\Report::class)->create([
            'service_id' => $service->id,
            'technician_id' => $tech->id,
            'completed' => (new Carbon('last sunday', $admin->timezone))->setTimezone('UTC')->toDateTimeString(),
        ]);

        // When
        // Then
        $this->assertTrue($service->checkIfIsDone(new Carbon('last saturday', $admin->timezone)));
        $this->assertTrue($service->checkIfIsDone(new Carbon('last tuesday', $admin->timezone)));
        $this->assertTrue($service->checkIfIsDone(new Carbon('last sunday', $admin->timezone)));
        $this->assertFalse($service->checkIfIsDone(new Carbon('last monday', $admin->timezone)));

    }

    /** @test */
    public function it_adds_image()
    {
        // Given
        $admin = $this->createAdministrator();

        $service = $this->createService($admin->id);

		$image1 = new Image;
        $image1->normal_path = 'normal/image/path1';
        $image1->thumbnail_path = 'thumbnail/image/path1';
        $image1->icon_path = 'icon/image/path1';
		$image2 = new Image;
        $image2->normal_path = 'normal/image/path2';
        $image2->thumbnail_path = 'thumbnail/image/path2';
        $image2->icon_path = 'icon/image/path2';

        // When
        $service->addImage($image1);
        $service->addImage($image2);

        $images = $service->hasMany('App\Image')->get();

        // Then
        $this->assertEquals(2, sizeof($images));
        $this->assertSameObject($image1, $images[0]);

    }

    /** @test */
    public function it_gets_images()
    {
        // Given
        $admin = $this->createAdministrator();

        $service = $this->createService($admin->id);

		$image1 = new Image;
        $image1->normal_path = 'normal/image/path1';
        $image1->thumbnail_path = 'thumbnail/image/path1';
        $image1->icon_path = 'icon/image/path1';
		$image2 = new Image;
        $image2->normal_path = 'normal/image/path2';
        $image2->thumbnail_path = 'thumbnail/image/path2';
        $image2->icon_path = 'icon/image/path2';

        $service->addImage($image1);
        $service->addImage($image2);

        // When
        $images = $service->images()->get();

        // Then
        $this->assertEquals(2, sizeof($images));
        $this->assertSameObject($image1, $images[0]);

    }

    /** @test */
    public function it_gets_num_images()
    {
        // Given
        $admin = $this->createAdministrator();

        $service = $this->createService($admin->id);

		$image1 = new Image;
        $image1->normal_path = 'normal/image/path1';
        $image1->thumbnail_path = 'thumbnail/image/path1';
        $image1->icon_path = 'icon/image/path1';
		$image2 = new Image;
        $image2->normal_path = 'normal/image/path2';
        $image2->thumbnail_path = 'thumbnail/image/path2';
        $image2->icon_path = 'icon/image/path2';

        $service->addImage($image1);
        $service->addImage($image2);

        // When
        $num_images = $service->numImages();

        // Then
        $this->assertEquals(2, $num_images);

    }

    /** @test */
    public function it_gets_image_thumbnail_icon()
    {
        // Given
        $admin = $this->createAdministrator();

        $service = $this->createService($admin->id);

		$image = new Image;
        $image->normal_path = 'normal/image/path';
        $image->thumbnail_path = 'thumbnail/image/path';
        $image->icon_path = 'icon/image/path';

        $service->addImage($image);

        // When
        $normal = $service->image();
        $thumbnail = $service->thumbnail();
        $icon = $service->icon();

        // Then
        $this->assertEquals($normal, 'normal/image/path');
        $this->assertEquals($thumbnail, 'thumbnail/image/path');
        $this->assertEquals($icon, 'icon/image/path');

    }

}
