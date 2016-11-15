<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\PRS\Transformers\PreviewTransformers\ServicePreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\ContractPreviewTransformer;
use App\PRS\Transformers\PreviewTransformers\WorkOrderPreviewTransformer;
use App\PRS\Transformers\InvoiceTransformer;
use App\PRS\Classes\Logged;
use App\WorkOrder;
use App\ServiceContract;
use App\Invoice;
use App\Service;

class InvoiceTransformerTest extends TestCase
{
    /** @test */
    public function it_transforms_invoice_with_service_contract()
    {
        // Given
        $mockServicePreviewTransformer = Mockery::mock(ServicePreviewTransformer::class);
        $mockServicePreviewTransformer->shouldReceive('transform')->once()->andReturn('ServicePreview');

        $mockContractPreviewTransformer = Mockery::mock(ContractPreviewTransformer::class);
        $mockContractPreviewTransformer ->shouldReceive('transform')->once()->andReturn('ContractPreview');

        $mockWorkOrderPreviewTrasformer = Mockery::mock(WorkOrderPreviewTransformer::class);

        $mockUser = Mockery::mock();
        $mockUser->api_token = 'ApiToken';
        $mockLogged = Mockery::mock(Logged::class);
        $mockLogged->shouldReceive('user')->once()->andReturn($mockUser);

        $serviceContractMock = Mockery::mock(ServiceContract::class);
        $serviceContractMock->shouldReceive('getAttribute')->with('service')->andReturn(Mockery::mock(Service::class));

        $mockInvoice = Mockery::mock(Invoice::class);
        $mockInvoice->shouldReceive('getAttribute')->with('invoiceable_type')->andReturn('App\ServiceContract');
        $mockInvoice->shouldReceive('getAttribute')->with('invoiceable')->andReturn($serviceContractMock);
        $mockInvoice->shouldReceive('type')->andReturn('Service Contract');
        $mockInvoice->shouldReceive('payments->count')->andReturn(10);

        $mockInvoice->shouldReceive('getAttribute')->with('seq_id')->andReturn(3);
        $mockInvoice->shouldReceive('getAttribute')->with('closed')->andReturn('Closed');
        $mockInvoice->shouldReceive('getAttribute')->with('amount')->andReturn('Amount');
        $mockInvoice->shouldReceive('getAttribute')->with('currency')->andReturn('Currency');
        $mockInvoice->shouldReceive('getAttribute')->with('closed')->andReturn('Closed');

        // When
        $array = (new InvoiceTransformer($mockServicePreviewTransformer,
                                        $mockContractPreviewTransformer,
                                        $mockWorkOrderPreviewTrasformer,
                                        $mockLogged))
                                    ->transform($mockInvoice);

        // Then
        $this->assertEquals($array, [
            'id' => 3,
            'closed' => 'Closed',
            'amount' => 'Amount',
            'currency' => 'Currency',
            'type' => 'Service Contract',
            'invoiceable' => 'ContractPreview',
            'service' => 'ServicePreview',
            'payments' => [
                'number' => 10,
                'href' => url("api/v1/invoices/3/payments?api_token=ApiToken"),
            ]
        ]);

    }

    /** @test */
    public function it_transforms_invoice_with_work_order()
    {
        // Given
        $mockServicePreviewTransformer = Mockery::mock(ServicePreviewTransformer::class);
        $mockServicePreviewTransformer->shouldReceive('transform')->once()->andReturn('ServicePreview');

        $mockContractPreviewTransformer = Mockery::mock(ContractPreviewTransformer::class);

        $mockWorkOrderPreviewTrasformer = Mockery::mock(WorkOrderPreviewTransformer::class);
        $mockWorkOrderPreviewTrasformer->shouldReceive('transform')->once()->andReturn('WorkOrderPreview');

        $mockUser = Mockery::mock();
        $mockUser->api_token = 'ApiToken';
        $mockLogged = Mockery::mock(Logged::class);
        $mockLogged->shouldReceive('user')->once()->andReturn($mockUser);

        $serviceContractMock = Mockery::mock(WorkOrder::class);
        $serviceContractMock->shouldReceive('getAttribute')->with('service')->andReturn(Mockery::mock(Service::class));

        $mockInvoice = Mockery::mock(Invoice::class);
        $mockInvoice->shouldReceive('getAttribute')->with('invoiceable_type')->andReturn('App\WorkOrder');
        $mockInvoice->shouldReceive('getAttribute')->with('invoiceable')->andReturn($serviceContractMock);
        $mockInvoice->shouldReceive('type')->andReturn('Service Contract');
        $mockInvoice->shouldReceive('payments->count')->andReturn(10);

        $mockInvoice->shouldReceive('getAttribute')->with('seq_id')->andReturn(3);
        $mockInvoice->shouldReceive('getAttribute')->with('closed')->andReturn('Closed');
        $mockInvoice->shouldReceive('getAttribute')->with('amount')->andReturn('Amount');
        $mockInvoice->shouldReceive('getAttribute')->with('currency')->andReturn('Currency');
        $mockInvoice->shouldReceive('getAttribute')->with('closed')->andReturn('Closed');

        // When
        $array = (new InvoiceTransformer($mockServicePreviewTransformer,
                                        $mockContractPreviewTransformer,
                                        $mockWorkOrderPreviewTrasformer,
                                        $mockLogged))
                                    ->transform($mockInvoice);

        // Then
        $this->assertEquals($array, [
            'id' => 3,
            'closed' => 'Closed',
            'amount' => 'Amount',
            'currency' => 'Currency',
            'type' => 'Service Contract',
            'invoiceable' => 'WorkOrderPreview',
            'service' => 'ServicePreview',
            'payments' => [
                'number' => 10,
                'href' => url("api/v1/invoices/3/payments?api_token=ApiToken"),
            ]
        ]);

    }
}
