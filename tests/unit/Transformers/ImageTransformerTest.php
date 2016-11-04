<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Image;
use App\PRS\Transformers\ImageTransformer;

class ImageTransformerTest extends TestCase
{

    /** @test */
    public function it_transforms_image()
    {
        // Given
        $mockImage = Mockery::mock(Image::class);
        $mockImage->shouldReceive('getAttribute')->with('normal_path')->andReturn('FullSize');
        $mockImage->shouldReceive('getAttribute')->with('thumbnail_path')->andReturn('Thumbnail');
        $mockImage->shouldReceive('getAttribute')->with('icon_path')->andReturn('Icon');
        $mockImage->shouldReceive('getAttribute')->with('order')->andReturn(3);

        // When
        $array = (new ImageTransformer)->transform($mockImage);

        // Then
        $this->assertEquals($array, [
            'full_size' => url('FullSize'),
            'thumbnail' => url('Thumbnail'),
            'icon' => url('Icon'),
            'order' => 3,
            'title' => 'Photo title',
        ]);

    }

}
