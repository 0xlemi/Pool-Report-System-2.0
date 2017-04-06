<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Payment;
use App\PRS\Transformers\PaymentTransformer;

class PaymentTransformerTest extends TestCase
{

    /** @test */
    public function it_transforms_payment()
    {
        // Given

        $mockInvoice = Mockery::mock();
        $mockInvoice->currency = 'USD';

        $mockPayment = Mockery::mock(Payment::class);
        $mockPayment->shouldReceive('getAttribute')->with('seq_id')->andReturn(5);
        $mockPayment->shouldReceive('getAttribute')->with('amount')->andReturn('150.40');
        $mockPayment->shouldReceive('getAttribute')->with('invoice')->andReturn($mockInvoice);
        $mockPayment->shouldReceive('createdAt')->andReturn('Paid At');

        // When
        $array = (new PaymentTransformer)->transform($mockPayment);

        // Then
        $this->assertEquals($array, [
            'id' => 5,
            'ammount' => '150.40',
            'currency' => 'USD',
            'paid_at' => 'Paid At',
        ]);

    }

}
