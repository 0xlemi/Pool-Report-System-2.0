<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Image;

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
    public function it_gets_service_days_by_days()
    {
        // Given
        $admin = $this->createAdministrator();

        $service1 = factory(App\Service::class)->create([
            'admin_id' => $admin->id,
            'service_days' => 42,
        ]);
        $service2 = factory(App\Service::class)->create([
            'admin_id' => $admin->id,
            'service_days' => 89,
        ]);

        // Service day number 42 equates to
        $service_days1 = array(
            'monday'    => false,
            'tuesday'   => true,
            'wednesday' => false,
            'thursday'  => true,
            'friday'    => false,
            'saturday'  => true,
            'sunday'    => false,
        );
        $service_days2 = array(
            'monday'    => true,
            'tuesday'   => false,
            'wednesday' => false,
            'thursday'  => true,
            'friday'    => true,
            'saturday'  => false,
            'sunday'    => true,
        );

        // When
        $service_days_1 = $service1->service_days_by_day();
        $service_days_2 = $service2->service_days_by_day();


        // Then
        $this->assertSameArray(
                    array_map('json_encode', $service_days1),
                    array_map('json_encode', $service_days_1),
                    true
                );
        $this->assertSameArray(
                    array_map('json_encode', $service_days2),
                    array_map('json_encode', $service_days_2),
                    true
                );

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
