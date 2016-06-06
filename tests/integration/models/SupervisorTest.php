<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Administrator;
use App\Supervisor;
use App\User;
use App\Image;

class SupervisorTest extends ModelTester
{

    /** @test */
    public function it_gets_admin()
    {
        // Given
        $original_admin = $this->createAdministrator();

        $sup = $this->createSupervisor($original_admin->id);

        // When
        $admin = $sup->admin();

        // Then
        $this->assertSameObject($original_admin, $admin);

    }

    /** @test */
    public function it_gets_user()
    {
        // Given
        $admin = $this->createAdministrator();

        $supervisor = factory(Supervisor::class)->create([
            'admin_id' => $admin->id,
        ]);
        $original_user = factory(User::class)->create([
            'userable_id' => $supervisor->id,
            'userable_type' => 'App\Supervisor',
        ]);

        // When
        $user = $supervisor->user();

        // Then
        $this->assertSameObject($original_user, $user);

    }

    /** @test */
    public function it_gets_technicians()
    {
        // Given
        $admin = $this->createAdministrator();

        $sup1 = $this->createSupervisor($admin->id);
        $sup2 = $this->createSupervisor($admin->id);

        $tech1 = $this->createTechnician($sup1->id);
        $tech2 = $this->createTechnician($sup2->id);
        $tech3 = $this->createTechnician($sup2->id);

        // When
        $tech = $sup2->technicians()->get();

        // Then
        $this->assertEquals(2, sizeof($tech));
        $this->assertSameObject($tech2, $tech[0]);
        $this->assertSameObject($tech3, $tech[1]);

    }

    /** @test */
    public function it_adds_image()
    {
        // Given
        $admin = $this->createAdministrator();

        $sup = $this->createSupervisor($admin->id);

		$image1 = new Image;
        $image1->normal_path = 'normal/image/path1';
        $image1->thumbnail_path = 'thumbnail/image/path1';
        $image1->icon_path = 'icon/image/path1';
		$image2 = new Image;
        $image2->normal_path = 'normal/image/path2';
        $image2->thumbnail_path = 'thumbnail/image/path2';
        $image2->icon_path = 'icon/image/path2';

        // When
        $sup->addImage($image1);
        $sup->addImage($image2);

        $images = $sup->hasMany('App\Image')->get();

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

		$image1 = new Image;
        $image1->normal_path = 'normal/image/path1';
        $image1->thumbnail_path = 'thumbnail/image/path1';
        $image1->icon_path = 'icon/image/path1';
		$image2 = new Image;
        $image2->normal_path = 'normal/image/path2';
        $image2->thumbnail_path = 'thumbnail/image/path2';
        $image2->icon_path = 'icon/image/path2';

        $sup->addImage($image1);
        $sup->addImage($image2);

        // When
        $images = $sup->images()->get();

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

		$image1 = new Image;
        $image1->normal_path = 'normal/image/path1';
        $image1->thumbnail_path = 'thumbnail/image/path1';
        $image1->icon_path = 'icon/image/path1';
		$image2 = new Image;
        $image2->normal_path = 'normal/image/path2';
        $image2->thumbnail_path = 'thumbnail/image/path2';
        $image2->icon_path = 'icon/image/path2';

        $sup->addImage($image1);
        $sup->addImage($image2);

        // When
        $num_images = $sup->numImages();

        // Then
        $this->assertEquals(2, $num_images);

    }

    /** @test */
    public function it_gets_image_thumbnail_icon()
    {
        // Given
        $admin = $this->createAdministrator();

        $sup = $this->createSupervisor($admin->id);

		$image = new Image;
        $image->normal_path = 'normal/image/path';
        $image->thumbnail_path = 'thumbnail/image/path';
        $image->icon_path = 'icon/image/path';

        $sup->addImage($image);

        // When
        $normal = $sup->image();
        $thumbnail = $sup->thumbnail();
        $icon = $sup->icon();

        // Then
        $this->assertEquals($normal, 'normal/image/path');
        $this->assertEquals($thumbnail, 'thumbnail/image/path');
        $this->assertEquals($icon, 'icon/image/path');

    }



}
