<?php

namespace App\PRS\Transformers;


use Carbon\Carbon;
use App\Invoice;
use App\PRS\Transformers\PreviewTransformers\ServicePreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\ContractPreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\WorkOrderPreviewTransformer;
use App\PRS\Classes\Logged;


/**
 * Transformer for the invoice class
 */
class InvoiceTransformer extends Transformer
{
    protected $servicePreviewTransformer;
    protected $contractPreviewTransformer;
    protected $workOrderPreviewTransformer;
    protected $logged;

    public function __construct(ServicePreviewTransformer $servicePreviewTransformer,
                                ContractPreviewTransformer $contractPreviewTransformer,
                                WorkOrderPreviewTransformer $workOrderPreviewTransformer,
                                Logged $logged)
    {
        $this->servicePreviewTransformer = $servicePreviewTransformer;
        $this->contractPreviewTransformer = $contractPreviewTransformer;
        $this->workOrderPreviewTransformer = $workOrderPreviewTransformer;
        $this->logged = $logged;
    }

    /**
     * Transform Invoice to api friendly array
     * @param  Inovice $invoice
     * @return array
     * tested
     */
    public function transform(Invoice $invoice)
    {
        $invoiceable = 'Unknown';
        if($invoice->invoiceable_type == 'App\ServiceContract'){
            $invoiceable = $this->contractPreviewTransformer->transform($invoice->invoiceable);
        }elseif($invoice->invoiceable_type == 'App\WorkOrder'){
            $invoiceable = $this->workOrderPreviewTransformer->transform($invoice->invoiceable);
        }

        return [
            'id' => $invoice->seq_id,
            'closed' => $invoice->closed,
            'amount' => $invoice->amount,
            'currency' => $invoice->currency,
            'type' => (string) $invoice->type(),
            'invoiceable' => $invoiceable,
            'service' => $this->servicePreviewTransformer
                                ->transform($invoice->invoiceable->service),
            'payments' => [
                'number' => $invoice->payments()->count(),
                'href' => url("api/v1/invoices/{$invoice->seq_id}/payments?api_token={$this->logged->user()->api_token}"),
            ],
        ];
    }

}
