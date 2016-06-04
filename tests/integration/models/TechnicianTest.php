<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Technician;
use App\User;
use App\Image;

class TechnicianTest extends ModelTester
{

    /** @test */
    public function it_gets_user()
    {
        // Given
        $admin = $this->createAdministrator();

        $sup = $this->createSupervisor($admin->id);

        $technician = factory(Technician::class)->create([
            'supervisor_id' => $sup->id,
        ]);
        $original_user = factory(User::class)->create([
            'userable_id' => $technician->id,
            'userable_type' => 'App\Technician',
        ]);

        // When
        $user = $technician->user();

        // Then
        $this->assertSameObject($original_user, $user);

    }

    /** @test */
    public function it_gets_supervisor()
    {
        // Given
        $admin = $this->createAdministrator();

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

        // When
        $supervisor = $tech->supervisor();

        // Then
        $this->assertSameObject($sup, $supervisor);

    }

    /** @test */
    public function it_gets_reports()
    {
        // Given
        $admin = $this->createAdministrator();

        $sup = $this->createSupervisor($admin->id);

        $service = $this->createService($admin->id);

        $tech = $this->createTechnician($sup->id);

        $rep1 = $this->createReport($service->id, $tech->id);
        $rep2 = $this->createReport($service->id, $tech->id);
        $rep3 = $this->createReport($service->id, $tech->id);

        // When
        $reports = $tech->reports();

        // Then
        $this->assertEquals(3, sizeof($reports));
        $this->assertSameObject($rep1, $reports[0]);
        $this->assertSameObject($rep2, $reports[1]);
        $this->assertSameObject($rep3, $reports[2]);

    }

    /** @test */
    public function it_gets_admin()
    {
        // Given
        $admin = $this->createAdministrator();

        $sup = $this->createSupervisor($admin->id);

        $service = $this->createService($admin->id);

        $tech = $this->createTechnician($service->id);

        // When
        $administrator = $tech->admin();

        // Then
        $this->assertSameObject($admin, $administrator);

    }

    /** @test */
    public function it_adds_image()
    {
        // Given
        $admin = $this->createAdministrator();

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

		$image1 = Image::create([
			'technician_id' => $tech->id,
			'normal_path' => 'normal/image/path1',
            'thumbnail_path' => 'thumbnail/image/path1',
            'icon_path' => 'icon/image/path1',
		]);
        $image2 = Image::create([
			'technician_id' => $tech->id,
			'normal_path' => 'normal/image/path2',
            'thumbnail_path' => 'thumbnail/image/path2',
            'icon_path' => 'icon/image/path2',
		]);

        // When
        $tech->addImage($image1);
        $tech->addImage($image2);

        $images = $tech->hasMany('App\Image')->get();

        // Then
        $this->assertEquals(2, sizeof($images));
        $this->assertSameObject($image1, $images[0]);

    }

    /** @test */
    public function it_gets_images()
    {
        // Given
        $admin = $this->createAdministrator();

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

		$image1 = Image::create([
			'technician_id' => $tech->id,
			'normal_path' => 'normal/image/path1',
            'thumbnail_path' => 'thumbnail/image/path1',
            'icon_path' => 'icon/image/path1',
		]);
        $image2 = Image::create([
			'technician_id' => $tech->id,
			'normal_path' => 'normal/image/path2',
            'thumbnail_path' => 'thumbnail/image/path2',
            'icon_path' => 'icon/image/path2',
		]);
        $tech->addImage($image1);
        $tech->addImage($image2);

        // When
        $images = $tech->images()->get();

        // Then
        $this->assertEquals(2, sizeof($images));
        $this->assertSameObject($image1, $images[0]);

    }

    /** @test */
    public function it_gets_num_images()
    {
        // Given
        $admin = $this->createAdministrator();

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

		$image1 = Image::create([
			'technician_id' => $tech->id,
			'normal_path' => 'normal/image/path1',
            'thumbnail_path' => 'thumbnail/image/path1',
            'icon_path' => 'icon/image/path1',
		]);
        $image2 = Image::create([
			'technician_id' => $tech->id,
			'normal_path' => 'normal/image/path2',
            'thumbnail_path' => 'thumbnail/image/path2',
            'icon_path' => 'icon/image/path2',
		]);
        $tech->addImage($image1);
        $tech->addImage($image2);

        // When
        $num_images = $tech->numImages();

        // Then
        $this->assertEquals(2, $num_images);

    }

    /** @test */
    public function it_gets_image_thumbnail_icon()
    {
        // Given
        $admin = $this->createAdministrator();

        $sup = $this->createSupervisor($admin->id);

        $tech = $this->createTechnician($sup->id);

		$image = Image::create([
			'technician_id' => $tech->id,
			'normal_path' => 'normal/image/path',
            'thumbnail_path' => 'thumbnail/image/path',
            'icon_path' => 'icon/image/path',
		]);
        $tech->addImage($image);

        // When
        $normal = $tech->image();
        $thumbnail = $tech->thumbnail();
        $icon = $tech->icon();

        // Then
        $this->assertEquals($normal, 'normal/image/path');
        $this->assertEquals($thumbnail, 'thumbnail/image/path');
        $this->assertEquals($icon, 'icon/image/path');

    }


}
