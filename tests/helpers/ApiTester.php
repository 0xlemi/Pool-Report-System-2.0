<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\PRS\Transformers\ServiceTransformer;

/**
 *
 */
abstract class ApiTester extends TestCase
{

    use FactoryTrait;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }


}
