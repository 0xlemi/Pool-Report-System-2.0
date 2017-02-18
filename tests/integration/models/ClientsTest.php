<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Client;
use App\Image;
use App\Service;

class ClientsTest extends DatabaseTester
{

    /** @test */
    public function it_gets_admin()
    {
        // Given
        $admin = $this->createAdministrator();

        $service = $this->createService($admin->id);

        $client = factory(Client::class)->create([
            'admin_id' => $admin->id,
        ]);

        // When
        // Then
        $this->assertSameObject($admin, $client->admin());

    }

    /** @test */
    public function it_gets_user()
    {
        // Given
        $admin = $this->createAdministrator();

        $service = $this->createService($admin->id);

        $client = factory(Client::class)->create([
            'admin_id' => $admin->id,
        ]);

        $original_user = factory(User::class)->create([
            'userable_id' => $client->id,
            'userable_type' => 'App\Client',
        ]);

        // fill the pivot table that connects with the service
         DB::table('client_service')->insert([
            'client_id' => $client->id,
            'service_id' => $service->id,
        ]);

        // When
        $user = $client->user;

        // Then
        $this->assertSameObject($original_user, $user);

    }

    /** @test */
    public function it_gets_services()
    {
        // Given
        $admin = $this->createAdministrator();

        $service1 = $this->createService($admin->id);
        $service2 = $this->createService($admin->id);
        $service3 = $this->createService($admin->id);

        $client = $this->createClient(
            $admin->id,
            [
                $service1->id,
                $service2->id,
                $service3->id
        ]);

        // When
        $services = $client->services()->get();

        // Then
        $this->assertSameArray(
            array_flat($service1->toArray()),
            array_flat($services[0]->toArray())
            );
        $this->assertSameArray(
            array_flat($service2->toArray()),
            array_flat($services[1]->toArray())
        );
        $this->assertSameArray(
            array_flat($service3->toArray()),
            array_flat($services[2]->toArray())
        );

    }

    /** @test */
    public function if_has_service_from_seq_id()
    {
        // Given
        $admin = $this->createAdministrator();

        $ser1 = $this->createService($admin->id);
        $ser2 = $this->createService($admin->id);
        $ser3 = $this->createService($admin->id);

        $client1 = $this->createClient(
            $admin->id,
            [
                $ser1->id,
                $ser2->id,
        ]);
        $client2 = $this->createClient(
            $admin->id,
            [
                $ser3->id
        ]);

        // When
        $service_1 = Service::find($ser1->id);
        $service_2 = Service::find($ser2->id);
        $service_3 = Service::find($ser3->id);

        // Then
        $this->assertTrue($client1->hasService($service_1->seq_id));
        $this->assertTrue($client1->hasService($service_2->seq_id));
        $this->assertTrue($client2->hasService($service_3->seq_id));
        $this->assertFalse($client2->hasService($service_1->seq_id));

    }

    /** @test */
    public function setting_services_from_seq_id_array()
    {
        // Given
        $admin = $this->createAdministrator();

        $ser1 = $this->createService($admin->id);
        $ser2 = $this->createService($admin->id);
        $ser3 = $this->createService($admin->id);
        $ser1_seq_id = Service::find($ser1->id)->seq_id;
        $ser2_seq_id = Service::find($ser2->id)->seq_id;
        $ser3_seq_id = Service::find($ser3->id)->seq_id;

        $client = $this->createClient($admin->id);

        // When
        $client->setServices([
            $ser1_seq_id,
            $ser2_seq_id,
            $ser3_seq_id,
        ]);

        // Then
        $this->assertTrue($client->hasService($ser1_seq_id));
        $this->assertTrue($client->hasService($ser2_seq_id));
        $this->assertTrue($client->hasService($ser3_seq_id));

    }

    /** @test */
    public function unsetting_services_from_seq_id_array()
    {
        // Given
        $admin = $this->createAdministrator();

        $client = $this->createClient($admin->id);

        $ser1 = $client->services()->create([
            'admin_id' => $admin->id,
        ]);
        $ser2 = $client->services()->create([
            'admin_id' => $admin->id,
        ]);
        $ser3 = $client->services()->create([
            'admin_id' => $admin->id,
        ]);

        $ser1_seq_id = Service::find($ser1->id)->seq_id;
        $ser2_seq_id = Service::find($ser2->id)->seq_id;
        $ser3_seq_id = Service::find($ser3->id)->seq_id;

        // When
        $client->unsetServices([
            $ser1_seq_id,
            $ser2_seq_id,
        ]);

        // Then
        $this->assertFalse($client->hasService($ser1_seq_id));
        $this->assertFalse($client->hasService($ser2_seq_id));
        $this->assertTrue($client->hasService($ser3_seq_id));

    }

    /** @test */
    public function it_adds_image()
    {
        // Given
        $admin = $this->createAdministrator();

        $service = $this->createService($admin->id);

        $client = $this->createClient($admin->id, [$service->id]);

		$image1 = new Image;
        $image1->normal_path = 'normal/image/path1';
        $image1->thumbnail_path = 'thumbnail/image/path1';
        $image1->icon_path = 'icon/image/path1';
		$image2 = new Image;
        $image2->normal_path = 'normal/image/path2';
        $image2->thumbnail_path = 'thumbnail/image/path2';
        $image2->icon_path = 'icon/image/path2';

        // When
        $client->addImage($image1);
        $client->addImage($image2);

        $images = $client->hasMany('App\Image')->get();

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

        $client = $this->createClient($admin->id, [$service->id]);

		$image1 = new Image;
        $image1->normal_path = 'normal/image/path1';
        $image1->thumbnail_path = 'thumbnail/image/path1';
        $image1->icon_path = 'icon/image/path1';
		$image2 = new Image;
        $image2->normal_path = 'normal/image/path2';
        $image2->thumbnail_path = 'thumbnail/image/path2';
        $image2->icon_path = 'icon/image/path2';

        $client->addImage($image1);
        $client->addImage($image2);

        // When
        $images = $client->images()->get();

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

        $client = $this->createClient($admin->id, [$service->id]);

		$image1 = new Image;
        $image1->normal_path = 'normal/image/path1';
        $image1->thumbnail_path = 'thumbnail/image/path1';
        $image1->icon_path = 'icon/image/path1';
		$image2 = new Image;
        $image2->normal_path = 'normal/image/path2';
        $image2->thumbnail_path = 'thumbnail/image/path2';
        $image2->icon_path = 'icon/image/path2';

        $client->addImage($image1);
        $client->addImage($image2);

        // When
        $num_images = $client->numImages();

        // Then
        $this->assertEquals(2, $num_images);

    }

    /** @test */
    public function it_gets_image_thumbnail_icon()
    {
        // Given
        $admin = $this->createAdministrator();

        $service = $this->createService($admin->id);

        $client = $this->createClient($admin->id, [$service->id]);

		$image = new Image;
        $image->normal_path = 'normal/image/path';
        $image->thumbnail_path = 'thumbnail/image/path';
        $image->icon_path = 'icon/image/path';

        $client->addImage($image);

        // When
        $normal = $client->image();
        $thumbnail = $client->thumbnail();
        $icon = $client->icon();

        // Then
        $this->assertEquals($normal, 'normal/image/path');
        $this->assertEquals($thumbnail, 'thumbnail/image/path');
        $this->assertEquals($icon, 'icon/image/path');

    }

}
