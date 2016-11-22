<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\PRS\ValueObjects\All\Type;

class TypeTest extends TestCase
{

    /** @test */
    public function it_get_type_as_a_string()
    {
        // Given
        $type = new Type("App\ThisIsTheModelName");

        // When
        $toString = (string)$type;

        // Then
        $this->assertEquals($toString, "This Is The Model Name");

    }

    /** @test */
    public function it_gets_type_url_route()
    {
        // Given
        $type = new Type("App\ThisIsTheModelName");

        // When
        $url = $type->url();

        // Then
        $this->assertEquals($url, 'thisisthemodelnames');

    }

}
