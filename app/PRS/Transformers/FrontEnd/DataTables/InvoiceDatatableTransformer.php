<?php

namespace App\PRS\Transformers\FrontEnd\DataTables;

use App\PRS\Transformers\Transformer;
use App\Invoice;

/**
 * Transformer for the invoice class
 */
class InvoiceDatatableTransformer extends Transformer
{

    /**
     * Transform invoice for today's route to datatable friendly array
     * @param  invoice $invoice
     * @return array
     */
    public function transform(Invoice $invoice)
    {
        $closedText = "<span class=\"label label-pill label-default\">Not Closed</span>";
        if($invoice->closed){
            $closedText = $invoice->closed()->format('d M Y h:i:s A');
        }
        return [
            'id' => $invoice->seq_id,
            'service' => $invoice->invoiceable->service->name,
            'type' => $invoice->type()->styled(true),
            'amount' => "{$invoice->amount} {$invoice->currency}",
            'closed' => $closedText,
        ];
    }

}
