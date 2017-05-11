<?php

namespace App\PRS\Transformers\PreviewTransformers;

use App\PRS\Transformers\Transformer;
use App\Invoice;

/**
 * Transformer for the invoice class
 */
class InvoicePreviewTransformer extends Transformer
{

    public function transform(Invoice $invoice)
    {
        return [
            'id' => $invoice->seq_id,
            'amount' => "{$invoice->amount} {$invoice->currency}",
            'href' => url("api/v1/invoices/{$invoice->seq_id}"),
        ];
    }


}
