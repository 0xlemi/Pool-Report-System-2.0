<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\PRS\Transformers\PreviewTransformers\ServicePreviewTransformer;
use App\PRS\Transformers\ClientTransformer;
use App\PRS\Transformers\ImageTransformer;
use App\Image;
use App\Client;

class ClientTransformerTest extends TestCase
{

    /** @test */
    public function it_transforms_client()
    {
        // Given
        $mockServicePreviewTransformer = Mockery::mock(ServicePreviewTransformer::class);
        $mockServicePreviewTransformer->shouldReceive('transformCollection')->once()
                                        ->andReturn([
                                            'service1',
                                            'service2'
                                        ]);

        $mockImageTransformer = Mockery::mock(ImageTransformer::class);
        $mockImageTransformer->shouldReceive('transform')->once()->andReturn('image');

        $mockUser = Mockery::mock();
        $mockUser->email = 'email@example.com';

        $mockClient = Mockery::mock(Client::class);
        $mockClient->shouldReceive('image')->once()->andReturn(Mockery::mock(Image::class));
        $mockClient->shouldReceive('imageExists')->once()->andReturn(true);
        $mockClient->shouldReceive('services->get')->once()->andReturn(null);
        $mockClient->shouldReceive('user')->once()->andReturn($mockUser);

        $mockClient->shouldReceive('getAttribute')->with('seq_id')->andReturn(3);
        $mockClient->shouldReceive('getAttribute')->with('name')->andReturn('firstName');
        $mockClient->shouldReceive('getAttribute')->with('last_name')->andReturn('lastName');
        $mockClient->shouldReceive('getAttribute')->with('cellphone')->andReturn('123');
        $mockClient->shouldReceive('getAttribute')->with('type')->andReturn(1);
        $mockClient->shouldReceive('getAttribute')->with('language')->andReturn('en');
        $mockClient->shouldReceive('getAttribute')->with('get_reports_emails')->andReturn(true);
        $mockClient->shouldReceive('getAttribute')->with('comments')->andReturn('Comments');

        $clientTransformer = new ClientTransformer($mockServicePreviewTransformer,
                                                $mockImageTransformer);

        // When
        $array = $clientTransformer->transform($mockClient);

        // Then
        $this->assertEquals($array, [
            'id' => 3,
            'name' => 'firstName',
            'last_name' => 'lastName',
            'email' => 'email@example.com',
            'cellphone' => '123',
            'type' => 'Owner',
            'language' => 'en',
            'getReportsEmails' => true,
            'comments' => 'Comments',
            'photo' => 'image',
            'services' =>
                [
                    'service1',
                    'service2'
                ],
        ]);

    }

}
