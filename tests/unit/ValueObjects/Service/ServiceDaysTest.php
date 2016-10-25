<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\PRS\ValueObjects\Service\ServiceDays;

class ServiceDaysTest extends TestCase
{
    use TesterTrait;


    /** @test */
    public function get_service_days_as_string_short_names()
    {
        // Given
        $mock = Mockery::mock('App\PRS\ValueObjects\Service\ServiceDays[asArray]', array(0));
        $mock->shouldReceive('asArray')
                            ->once()
                            ->andReturn([
                                'monday'    => true,
                                'tuesday'   => false,
                                'wednesday' => true,
                                'thursday'  => true,
                                'friday'    => false,
                                'saturday'  => false,
                                'sunday'    => false,
                            ]);

        // When
        $string = $mock->shortNames();

        // Then
        $this->assertEquals($string, 'mon, wed, thu');

    }

    /** @test */
    public function get_service_days_as_string_short_names_styled()
    {
        // Given
        $mock = Mockery::mock('App\PRS\ValueObjects\Service\ServiceDays[shortNames]', array(0));
        $mock->shouldReceive('shortNames')
                            ->once()
                            ->andReturn('mon, tue, wed');

        // When
        $string = $mock->shortNamesStyled('success');

        // Then
        $this->assertEquals($string, '<span class="label label-pill label-success">mon, tue, wed</span>');

    }

    /** @test */
    public function get_service_days_as_string_full_names()
    {
        // Given
        $mock = Mockery::mock('App\PRS\ValueObjects\Service\ServiceDays[asArray]', array(0));
        $mock->shouldReceive('asArray')
                            ->once()
                            ->andReturn([
                                'monday'    => true,
                                'tuesday'   => false,
                                'wednesday' => true,
                                'thursday'  => true,
                                'friday'    => true,
                                'saturday'  => false,
                                'sunday'    => true,
                            ]);

        // When
        $string = $mock->fullNames();

        // Then
        $this->assertEquals($string, 'monday, wednesday, thursday, friday, sunday');

    }

    /** @test */
    public function transform_number_to_array()
    {
        // Given
        $mock1 = new ServiceDays(5);
        $mock2 = new ServiceDays(23);

        // When
        $array1 = $mock1  ->asArray();
        $array2 = $mock2->asArray();

        // Then
        $this->assertSameArray($array1, array(
            'monday'    => true,
            'tuesday'   => false,
            'wednesday' => true,
            'thursday'  => false,
            'friday'    => false,
            'saturday'  => false,
            'sunday'    => false,
        ));
        $this->assertSameArray($array2, array(
            'monday'    => true,
            'tuesday'   => true,
            'wednesday' => true,
            'thursday'  => false,
            'friday'    => true,
            'saturday'  => false,
            'sunday'    => false,
        ));
    }

}
