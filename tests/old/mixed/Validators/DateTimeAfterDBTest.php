<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DateTimeAfterDBTest extends TestCase
{

    use FactoryTrait;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }

    /** @test */
    public function it_validates_that_provided_dateTime_happens_after_dateTime_in_DB()
    {
        // Given


        // When


        // Then


    }

}
