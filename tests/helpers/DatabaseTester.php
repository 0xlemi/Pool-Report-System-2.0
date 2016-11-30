<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * parent class for testnig models
 */
abstract class DatabaseTester extends TestCase
{
    use TesterTrait;
    use FactoryTrait;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }

}
