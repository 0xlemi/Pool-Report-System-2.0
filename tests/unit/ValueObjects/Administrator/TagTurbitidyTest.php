<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\PRS\Classes\ValueObjects\Administrator\TagTurbidity;

class TagTurbitidyTest extends TestCase
{
    use TesterTrait;


    /** @test */
    public function get_tag_turbidity_as_array()
    {
        // Given
        $tag = new TagTurbidity('first', 'second',
                            'third', 'fourth');

        // When
        $array = $tag->asArray();

        // Then
        $this->assertSameArray($array, [
            1 => 'first',
            2 => 'second',
            3 => 'third',
            4 => 'fourth',
        ]);

    }

    /** @test */
    public function get_tag_turbidity_from_number_of_the_reading()
    {
        // Given
        $mock = Mockery::mock('App\PRS\Classes\ValueObjects\Administrator\TagTurbidity[asArray]', ['','','','','']);
        $mock->shouldReceive('asArray')
                ->times(2)
                ->andReturn([
                        1 => 'first',
                        2 => 'second',
                        3 => 'third',
                        4 => 'fourth',
                    ]);

        // When
        $second = $mock->fromReading(2);
        $third = $mock->fromReading(3);

        // Then
        $this->assertEquals($second, 'second');
        $this->assertEquals($third, 'third');

    }
}
