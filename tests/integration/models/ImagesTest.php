<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Image;

class ImagesTest extends ModelTester
{

    /** @test */
    public function it_deletes_image_by_order()
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

        // When
        $image_1_deleted = $report->deleteImage(1);
        $image_2_deleted = $report->deleteImage(2);

        // Then
        $this->assertTrue($image_1_deleted);
        $this->assertFalse($image_2_deleted);

    }

}
