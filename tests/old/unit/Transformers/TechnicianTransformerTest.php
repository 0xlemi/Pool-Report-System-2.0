<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Technician;
use App\Supervisor;
use App\PRS\Transformers\ImageTransformer;
use App\PRS\Transformers\PreviewTransformers\SupervisorPreviewTransformer;
use App\PRS\Transformers\TechnicianTransformer;
use App\Image;

class TechnicianTransformerTest extends TestCase
{

    /** @test */
    public function it_transforms_technician()
    {
        // Given
        $mockImageTransformer = Mockery::mock(ImageTransformer::class);
        $mockImageTransformer->shouldReceive('transform')->once()->andReturn('Image');

        $mockSupervisorPreviewTransformer = Mockery::mock(SupervisorPreviewTransformer::class);
        $mockSupervisorPreviewTransformer->shouldReceive('transform')->once()->andReturn('SupervisorPreview');

        $mockUser = Mockery::mock();
        $mockUser->email = 'Username';
        $mockUser->active = 1;

        $mockTechnician = Mockery::mock(Technician::class);
        $mockTechnician->shouldReceive('imageExists')->once()->andReturn(true);
        $mockTechnician->shouldReceive('image')->once()->andReturn(Mockery::mock(Image::class));
        $mockTechnician->shouldReceive('user')->times(2)->andReturn($mockUser);
        $mockTechnician->shouldReceive('supervisor')->once()->andReturn(Mockery::mock(Supervisor::class));

        $mockTechnician->shouldReceive('getAttribute')->with('seq_id')->andReturn(3);
        $mockTechnician->shouldReceive('getAttribute')->with('name')->andReturn('Name');
        $mockTechnician->shouldReceive('getAttribute')->with('last_name')->andReturn('LastName');
        $mockTechnician->shouldReceive('getAttribute')->with('cellphone')->andReturn('Cellphone');
        $mockTechnician->shouldReceive('getAttribute')->with('address')->andReturn('Address');
        $mockTechnician->shouldReceive('getAttribute')->with('language')->andReturn('Language');
        $mockTechnician->shouldReceive('getAttribute')->with('get_reports_emails')->andReturn(0);
        $mockTechnician->shouldReceive('getAttribute')->with('comments')->andReturn('Comments');

        // When
        $array = (new TechnicianTransformer($mockSupervisorPreviewTransformer, $mockImageTransformer))->transform($mockTechnician);

        // Then
        $this->assertEquals($array, [
            'id' => 3,
            'name' => 'Name',
            'last_name' => 'LastName',
            'username' => 'Username',
            'cellphone' => 'Cellphone',
            'address' => 'Address',
            'language' => 'Language',
            'status' => 1,
            'getReportsEmails' => 0,
            'comments' => 'Comments',
            'photo' => 'Image',
            'supervisor' => 'SupervisorPreview',
        ]);

    }

}
