<?php

namespace App\PRS\Transformers;

use App\Payment;
use App\PRS\Transformers\PreviewTransformers\InvoicePreviewTransformer;

/**
 * Transformer for the payment class
 */
class PaymentTransformer extends Transformer
{
    protected $invoicePreviewTransformer;

    public function __construct(InvoicePreviewTransformer $invoicePreviewTransformer)
    {
        $this->invoicePreviewTransformer = $invoicePreviewTransformer;
    }

    /**
     * Transform Payment to api friendly array
     * @param  Payment $payment
     * @return array
     */
    public function transform(Payment $payment)
    {

        return [
            'id' => $payment->seq_id,
            'ammount' => $payment->amount,
            'currency' => $payment->invoice->currency,
            'paid_at' => $payment->createdAt(),
            // 'invoice' => $this->invoicePreviewTransformer
            //                 ->transform($payment->invoice),
        ];
    }

}
