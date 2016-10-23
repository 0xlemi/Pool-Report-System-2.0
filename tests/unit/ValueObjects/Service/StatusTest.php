<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\PRS\Classes\ValueObjects\Service\Status;

class StatusTest extends TestCase
{
    /** @test */
    public function get_status_as_string()
    {
        // Given
        $statusTrue = new Status(true);
        $statusFalse = new Status(false);

        // When
        $stringTrue = (string) $statusTrue;
        $stringFalse = (string) $statusFalse;

        // Then
        $this->assertEquals($stringTrue, 'Active');
        $this->assertEquals($stringFalse, 'Inactive');

    }

    /** @test */
    public function get_status_styled_as_html_span_pill_and_squeare()
    {
        // Given
        $statusTrue = new Status(true);
        $statusFalse = new Status(false);

        // When
        $stringTrue = $statusTrue->styled();
        $stringFalse = $statusFalse->styled(true);

        // Then
        $this->assertEquals($stringTrue, '<span class="label  label-success">Active</span>');
        $this->assertEquals($stringFalse, '<span class="label label-pill label-danger">Inactive</span>');

    }
    
}
