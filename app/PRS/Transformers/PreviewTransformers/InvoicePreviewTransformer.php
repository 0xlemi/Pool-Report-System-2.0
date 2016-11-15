<?php

namespace App\PRS\Transformers\PreviewTransformers;

use App\PRS\Transformers\Transformer;
use App\PRS\Classes\Logged;
use App\Invoice;

/**
 * Transformer for the invoice class
 */
class InvoicePreviewTransformer extends Transformer
{

    private $logged;

    public function __construct(Logged $logged)
    {
        $this->logged = $logged;
    }


    public function transform(Invoice $invoice)
    {
        return [
            'id' => $invoice->seq_id,
            'amount' => "{$invoice->amount} {$invoice->currency}",
            'href' => url("api/v1/invoices/{$invoice->seq_id}?api_token={$this->logged->user()->api_token}"),
        ];
    }


}
