<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\PRS\ValueObjects\Invoice\TypeInvoice;

class TypeInvoiceTest extends TestCase
{

    /** @test */
    public function it_shows_the_styled_type()
    {
        // Given
        $serviceContractType = new TypeInvoice("App\\ServiceContract");
        $workOrderType = new TypeInvoice("App\\WorkOrder");

        // When
        $serviceContractStyled = $serviceContractType->styled();
        $workOrderStyled = $workOrderType->styled(true);

        // Then
        $this->assertEquals($serviceContractStyled, '<span class="label  label-primary">Service Contract</span>');
        $this->assertEquals($workOrderStyled, '<span class="label label-pill label-success">Work Order</span>');

    }

}
