<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Image;

class ReportTest extends DatabaseTester
{

    /** @test */
    public function it_gets_service()
    {
        // Given
        $admin = $this->createAdministrator();

        $ser = $this->createService($admin->id);

        $sup = $this->createSupervisor($admin->id);

        $tech= $this->createTechnician($sup->id);

        $report = $this->createReport($ser->id, $tech->id);

        // When
        $service = $report->service;

        // Then
        $this->assertSameObject($ser, $service);

    }

    /** @test */
    public function it_gets_clients()
    {
        // Given
        $admin = $this->createAdministrator();

        $ser = $this->createService($admin->id);

        $client1 = $this->createClient(
                $admin->id,
                [ $ser->id ]
        );

        $client2 = $this->createClient(
                $admin->id,
                [ $ser->id ]
        );

        $sup = $this->createSupervisor($admin->id);

        $tech= $this->createTechnician($sup->id);

        $report = $this->createReport($ser->id, $tech->id);

        // When
        $clients = $report->clients()->get();

        // Then
        $this->assertSameObject($client1, $clients->shift(), true);
        $this->assertSameObject($client2, $clients->shift(), true);

    }

    /** @test */
    public function it_gets_admin()
    {
        $admin = $this->createAdministrator();

        $ser = $this->createService($admin->id);

        $sup = $this->createSupervisor($admin->id);

        $tech= $this->createTechnician($sup->id);

        $report = $this->createReport($ser->id, $tech->id);

        // When
        // Then
        $this->assertSameObject($admin, $report->admin());

    }

    /** @test */
    public function it_gets_technician()
    {
        // Given
        $admin = $this->createAdministrator();

        $ser = $this->createService($admin->id);

        $sup = $this->createSupervisor($admin->id);

        $tech= $this->createTechnician($sup->id);

        $report = $this->createReport($ser->id, $tech->id);

        // When
        $technician = $report->technician;

        // Then
        $this->assertSameObject($tech, $technician);

    }

    /** @test */
    public function it_adds_image()
    {
        // Given
        $admin = $this->createAdministrator();

        $ser = $this->createService($admin->id);

        $sup = $this->createSupervisor($admin->id);

        $tech= $this->createTechnician($sup->id);

        $report = $this->createReport($ser->id, $tech->id);

		$image1 = new Image;
        $image1->normal_path = 'normal/image/path1';
        $image1->thumbnail_path = 'thumbnail/image/path1';
        $image1->icon_path = 'icon/image/path1';
		$image2 = new Image;
        $image2->normal_path = 'normal/image/path2';
        $image2->thumbnail_path = 'thumbnail/image/path2';
        $image2->icon_path = 'icon/image/path2';

        // When
        $report->addImage($image1);
        $report->addImage($image2);

        $images = $report->hasMany('App\Image')->get();

        // Then
        $this->assertEquals(2, sizeof($images));
        $this->assertSameObject($image1, $images[0]);

    }

    /** @test */
    public function it_gets_images()
    {
        // Given
        $admin = $this->createAdministrator();

        $ser = $this->createService($admin->id);

        $sup = $this->createSupervisor($admin->id);

        $tech= $this->createTechnician($sup->id);

        $report = $this->createReport($ser->id, $tech->id);


        $image1 = new Image;
        $image1->normal_path = 'normal/image/path1';
        $image1->thumbnail_path = 'thumbnail/image/path1';
        $image1->icon_path = 'icon/image/path1';
		$image2 = new Image;
        $image2->normal_path = 'normal/image/path2';
        $image2->thumbnail_path = 'thumbnail/image/path2';
        $image2->icon_path = 'icon/image/path2';

        $report->addImage($image1);
        $report->addImage($image2);

        // When
        $images = $report->images()->get();

        // Then
        $this->assertEquals(2, sizeof($images));
        $this->assertSameObject($image1, $images[0]);

    }

    /** @test */
    public function it_gets_num_images()
    {
        // Given
        $admin = $this->createAdministrator();

        $ser = $this->createService($admin->id);

        $sup = $this->createSupervisor($admin->id);

        $tech= $this->createTechnician($sup->id);

        $report = $this->createReport($ser->id, $tech->id);

		$image1 = new Image;
        $image1->normal_path = 'normal/image/path1';
        $image1->thumbnail_path = 'thumbnail/image/path1';
        $image1->icon_path = 'icon/image/path1';
		$image2 = new Image;
        $image2->normal_path = 'normal/image/path2';
        $image2->thumbnail_path = 'thumbnail/image/path2';
        $image2->icon_path = 'icon/image/path2';

        $report->addImage($image1);
        $report->addImage($image2);

        // When
        $num_images = $report->numImages();

        // Then
        $this->assertEquals(2, $num_images);

    }

    /** @test */
    public function it_gets_image_by_order_num()
    {
        // Given
        $admin = $this->createAdministrator();

        $ser = $this->createService($admin->id);

        $sup = $this->createSupervisor($admin->id);

        $tech= $this->createTechnician($sup->id);

        $report = $this->createReport($ser->id, $tech->id);

        $image1 = new Image;
        $image1->normal_path = 'normal/image/path1';
        $image1->thumbnail_path = 'thumbnail/image/path1';
        $image1->icon_path = 'icon/image/path1';
        $image1->order = $report->numImages() + 1;
        $report->addImage($image1);

		$image2 = new Image;
        $image2->normal_path = 'normal/image/path2';
        $image2->thumbnail_path = 'thumbnail/image/path2';
        $image2->icon_path = 'icon/image/path2';
        $image2->order = $report->numImages() + 1;
        $report->addImage($image2);

        // When
        $image_1 = $report->image(1, false);
        $image_2 = $report->image(2, false);

        // Then
        $this->assertSameObject($image1, $image_1);
        $this->assertSameObject($image2, $image_2);

    }



}
