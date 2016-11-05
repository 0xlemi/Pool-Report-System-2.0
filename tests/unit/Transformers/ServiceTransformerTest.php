<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\PRS\Transformers\ImageTransformer;
use App\PRS\Transformers\ServiceTransformer;
use App\PRS\Classes\Logged;
use App\Image;
use App\Service;

class ServiceTransformerTest extends TestCase
{

    /** @test */
    public function it_transforms_service()
    {
        // Given
        $mockImageTransformer = Mockery::mock(ImageTransformer::class);
        $mockImageTransformer->shouldReceive('transform')->once()->andReturn('Image');

        $mockUser = Mockery::mock();
        $mockUser->api_token = 'ApiToken';
        $mockLogged = Mockery::mock(Logged::class);
        $mockLogged->shouldReceive('user')->once()->andReturn($mockUser);

        $mockService = Mockery::mock(Service::class);
        $mockService->shouldReceive('equipment->count')->once()->andReturn(3);
        $mockService->shouldReceive('imageExists')->once()->andReturn(true);
        $mockService->shouldReceive('image')->once()->andReturn(Mockery::mock(Image::class));

        $mockService->shouldReceive('getAttribute')->with('seq_id')->andReturn(2);
        $mockService->shouldReceive('getAttribute')->with('name')->andReturn('HouseName');
        $mockService->shouldReceive('getAttribute')->with('address_line')->andReturn('AddressLine');
        $mockService->shouldReceive('getAttribute')->with('city')->andReturn('City');
        $mockService->shouldReceive('getAttribute')->with('state')->andReturn('State');
        $mockService->shouldReceive('getAttribute')->with('postal_code')->andReturn('PostalCode');
        $mockService->shouldReceive('getAttribute')->with('country')->andReturn('Country');
        $mockService->shouldReceive('getAttribute')->with('latitude')->andReturn(123.123123);
        $mockService->shouldReceive('getAttribute')->with('longitude')->andReturn(345.345345);
        $mockService->shouldReceive('getAttribute')->with('comments')->andReturn('Comments');

        // When
        $array = (new ServiceTransformer($mockImageTransformer, $mockLogged))->transform($mockService);

        // Then
        $this->assertEquals($array, [
            'id' => 2,
            'name' => 'HouseName',
            'address_line' => 'AddressLine',
            'city' => 'City',
            'state' => 'State',
            'postal_code' => 'PostalCode',
            'country' => 'Country',
            'comments' => 'Comments',
            'location' =>
                [
                    'latitude' => 123.123123,
                    'longitude' => 345.345345,
                ],
            'photo' => 'Image',
            'equipment' => [
                'number' => 3,
                'href' => url("api/v1/services/2/equipment?api_token=ApiToken"),
            ],
        ]);

    }

}
