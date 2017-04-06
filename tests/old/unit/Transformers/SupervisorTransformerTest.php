<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\PRS\Transformers\ImageTransformer;
use App\PRS\Transformers\SupervisorTransformer;
use App\Image;
use App\Supervisor;

class SupervisorTransformerTest extends TestCase
{

    /** @test */
    public function it_transforms_supervisor()
    {
        // Given
        $mockImageTransformer = Mockery::mock(ImageTransformer::class);
        $mockImageTransformer->shouldReceive('transform')->once()->andReturn('Image');

        $mockUser = Mockery::mock();
        $mockUser->email = 'email@example.com';
        $mockUser->active = 1;

        $mockSupervisor = Mockery::mock(Supervisor::class);
        $mockSupervisor->shouldReceive('imageExists')->once()->andReturn(true);
        $mockSupervisor->shouldReceive('image')->once()->andReturn(Mockery::mock(Image::class));
        $mockSupervisor->shouldReceive('user')->times(2)->andReturn($mockUser);

        $mockSupervisor->shouldReceive('getAttribute')->with('seq_id')->andReturn(3);
        $mockSupervisor->shouldReceive('getAttribute')->with('name')->andReturn('Name');
        $mockSupervisor->shouldReceive('getAttribute')->with('last_name')->andReturn('LastName');
        $mockSupervisor->shouldReceive('getAttribute')->with('cellphone')->andReturn('Cellphone');
        $mockSupervisor->shouldReceive('getAttribute')->with('address')->andReturn('Address');
        $mockSupervisor->shouldReceive('getAttribute')->with('language')->andReturn('Language');
        $mockSupervisor->shouldReceive('getAttribute')->with('get_reports_emails')->andReturn(0);
        $mockSupervisor->shouldReceive('getAttribute')->with('comments')->andReturn('Comments');

        // When
        $array = (new SupervisorTransformer($mockImageTransformer))->transform($mockSupervisor);

        // Then
        $this->assertEquals($array, [
            'id' => 3,
            'name' => 'Name',
            'last_name' => 'LastName',
            'email' => 'email@example.com',
            'cellphone' => 'Cellphone',
            'address' => 'Address',
            'language' => 'Language',
            'status' => 1,
            'getReportsEmails' => 0,
            'comments' => 'Comments',
            'photo' => 'Image',
        ]);

    }

}
