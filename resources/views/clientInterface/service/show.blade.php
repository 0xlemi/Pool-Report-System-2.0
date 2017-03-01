@extends('layouts.app')

@inject('serviceHelpers', 'App\PRS\Helpers\ServiceHelpers')
@section('content')
<header class="section-header">
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>View Service</h3>
				<ol class="breadcrumb breadcrumb-simple">
					<li><a href="{{ url('service') }}">Services</a></li>
					<li class="active">View Service {{ $service->seq_id }}</li>
				</ol>
			</div>
		</div>
	</div>
</header>
<div class="row">
	<div class="col-md-12 col-lg-12 col-xl-8 col-xl-offset-2">
		<section class="card">
				<header class="card-header card-header-lg">
					Service info:
				</header>
				<div class="card-block">
					<form>

						@if($service->images->count() > 0)
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Service photo</label>
							<div class="col-sm-10">
								<div class="col-xl-3 col-lg-4 col-md-4 col-sm-5 m-b-md">
									<photo :image="{{ json_encode($image) }}" :can-delete="false"></photo>
								</div>
							</div>
						</div>
						@endif

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">ID</label>
							<div class="col-sm-10">
								<input type="text" readonly class="form-control" value="{{ $service->seq_id }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Name</label>
							<div class="col-sm-10">
								<input type="text" readonly class="form-control" value="{{ $service->name }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Street and Number</label>
							<div class="col-sm-10">
								<input type="text" readonly class="form-control" value="{{ $service->address_line }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">City</label>
							<div class="col-sm-10">
								<input type="text" readonly class="form-control" value="{{ $service->city }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">State</label>
							<div class="col-sm-10">
								<input type="text" readonly class="form-control" value="{{ $service->state }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Postal Code</label>
							<div class="col-sm-10">
								<input type="text" readonly class="form-control" value="{{ $service->postal_code }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Country</label>
							<div class="col-sm-10">
								<input type="text" readonly class="form-control" value="{{ $serviceHelpers->get_country_by_code($service->country) }}">
							</div>
						</div>

						@if($contract)
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Service Contract</label>
							<div class="col-sm-10">
								<client-contract
									service-days-string="{{ $contract->serviceDays()->shortNames() }}"
									start-time="{{ $contract->startTime()->timePickerValue() }}"
									end-time="{{ $contract->endTime()->timePickerValue() }}"
									price="{{ $contract->amount.' '.$contract->currency }}"
									start="{{ $contract->start() }}">
								</client-contract>
							</div>
						</div>
						@endif

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Equipment</label>
							<div class="col-sm-10">
								<client-equipment
								service-id="{{ $service->seq_id }}">
								</client-equipment>
							</div>
						</div>


						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Location</label>
							<div class="col-sm-10">
								<button type="button" class="btn btn-success"
									data-toggle="modal"
									data-target="#mapModal">
									<i class="font-icon font-icon-earth-bordered"></i>&nbsp;&nbsp;&nbsp;Show Map</button>
							</div>
						</div>

					</form>
				</div>
		</section>
	</div>
</div>
@include('services.showMap')

@endsection
