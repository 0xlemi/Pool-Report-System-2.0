@extends('layouts.app')

@section('content')
<header class="section-header">
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>View Invoice</h3>
				<ol class="breadcrumb breadcrumb-simple">
					<li><a href="{{ url('invoices') }}">Invoices</a></li>
					<li class="active">View Invoice #{{ $invoice->seq_id }}</li>
				</ol>
			</div>
		</div>
	</div>
</header>
<div class="row">
	<div class="col-md-12 col-lg-12 col-xl-8 col-xl-offset-2">
		<section class="card">
				<header class="card-header card-header-xxl">
					Invoice #{{ $invoice->seq_id }}
				</header>
				<div class="card-block">

                    @if($invoice->closed == NULL)
                        <div class="form-group row">
							<div class="col-md-10 col-md-offset-2">
                                <h3><span class="label label-primary">Invoice Open</span></h3>
                            </div>
                        </div>
                    @else
                        <div class="form-group row">
                            <div class="col-md-10 col-md-offset-2">
                                <h3><span class="label label-default">Invoice Closed</span></h3>
                            </div>
							<label class="col-md-2 form-control-label">Closed at:</label>
							<div class="col-md-10">
								<input type="text" readonly class="form-control" value="{{ $invoice->closed()->format('d M Y h:i:s A') }}">
							</div>
						</div>
                    @endif

					<div class="form-group row">
						<label class="col-md-2 form-control-label">Created:</label>
						<div class="col-md-10">
							<input type="text" readonly class="form-control" value="{{ $service->created_at->format('d M Y h:i:s A') }}">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-2 form-control-label">Service</label>
						<div class="col-md-10">
							<input type="text" readonly class="form-control" value="{{ $service->name }}">
						</div>
					</div>

                    <div class="form-group row">
						<label class="col-md-2 form-control-label">Type</label>
						<div class="col-md-10">
							{!! $invoice->type()->styled(false) !!}
						</div>
					</div>

                    <div class="form-group row">
						<label class="col-md-2 form-control-label">Amount Charged</label>
						<div class=" col-xxl-4 col-xl-6 col-lg-5 col-md-5 col-sm-10">
                            <div class="input-group">
								<div class="input-group-addon">$</div>
					            <input type="text" readonly class="form-control" value="{{ $invoice->amount }}">
								<div class="input-group-addon">{{ $invoice->currency }}</div>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-md-2 form-control-label">Total Paid</label>
						<div class=" col-xxl-4 col-xl-6 col-lg-5 col-md-5 col-sm-10">
                            <div class="input-group">
								<div class="input-group-addon">$</div>
					            <input type="text" readonly class="form-control" value="{{ $invoice->totalPayments() }}">
								<div class="input-group-addon">{{ $invoice->currency }}</div>
							</div>
						</div>
					</div>

					<payments invoice-id="{{ $invoice->seq_id }}"
					    base-url="{{ url('/') }}">
					</payments>

					<div class="form-group row">
						<label class="col-sm-2 form-control-label">Description</label>
						<div class="col-sm-10">
							<textarea rows="4" class="form-control" name="description" placeholder="This invoice has no description." readonly>{{ $invoice->description }}</textarea>
						</div>
					</div>

					<hr>
					<span style="float: right;">
    					@can('delete', $invoice)
							<delete-button url="invoices/" object-id="{{ $invoice->seq_id }}">
							</delete-button>
    					@endcan
					</span>
					<br>
					<br>
				</div>
		</section>
	</div>
</div>
@endsection
