@extends('layouts.app')

@inject('serviceHelpers', 'App\PRS\Helpers\ServiceHelpers')
@inject('clientHelpers', 'App\PRS\Helpers\ClientHelpers')
@section('content')
<header class="section-header">
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>View Service</h3>
				<ol class="breadcrumb breadcrumb-simple">
					<li><a href="{{ url('services') }}">Services</a></li>
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
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Service photo</label>
							<div class="col-sm-10">
								<photo-list :data="{{ json_encode($images) }}" :can-delete="false"></photo-list>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">ID</label>
							<div class="col-sm-10">
								<input type="text" readonly class="form-control" id="inputPassword" value="{{ $service->seq_id }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Name</label>
							<div class="col-sm-10">
								<input type="text" readonly class="form-control" id="inputPassword" value="{{ $service->name }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Street and Number</label>
							<div class="col-sm-10">
								<input type="text" readonly class="form-control" id="inputPassword" value="{{ $service->address_line }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">City</label>
							<div class="col-sm-10">
								<input type="text" readonly class="form-control" id="inputPassword" value="{{ $service->city }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">State</label>
							<div class="col-sm-10">
								<input type="text" readonly class="form-control" id="inputPassword" value="{{ $service->state }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Postal Code</label>
							<div class="col-sm-10">
								<input type="text" readonly class="form-control" id="inputPassword" value="{{ $service->postal_code }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Country</label>
							<div class="col-sm-10">
								<input type="text" readonly class="form-control" id="inputPassword" value="{{ $serviceHelpers->get_country_by_code($service->country) }}">
							</div>
						</div>

						<contract service-id="{{ $service->seq_id }}"
					        service-contract-url="{{ url('servicecontracts').'/' }}"
					        :currencies="{{ json_encode(config('constants.currencies')) }}">
						</contract>

						<chemical service-id="{{ $service->seq_id }}"
						    base-url="{{ url('chemicals').'/' }}">
						</chemical>

						<equipment service-id="{{ $service->seq_id }}">
						</equipment>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Location</label>
							<div class="col-sm-10">
								<button type="button" class="btn btn-success"
									data-toggle="modal"
									data-target="#mapModal">
									<i class="font-icon font-icon-earth-bordered"></i>&nbsp;&nbsp;&nbsp;Show Map</button>
							</div>
						</div>

    					@can('list', App\Client::class)
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Clients</label>
								<div class="col-sm-10">
									<button type="button" class="btn btn-warning"
										data-toggle="modal"
										data-target="#clientsModal">
										<i class="font-icon glyphicon glyphicon-user"></i>&nbsp;&nbsp;&nbsp;List of Clients</button>
								</div>
							</div>
						@endcan

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Comments</label>
							<div class="col-sm-10">
								<textarea rows="4" class="form-control"
											placeholder="Any additional info about this service."
											name="comments" readonly>{{ $service->comments }}</textarea>
							</div>
						</div>
					</form>
					<hr>

					<span style="float: right;">
    					@can('delete', $service)
							<delete-button url="services/" object-id="{{ $service->seq_id }}">
							</delete-button>
    					@endcan
    					@can('update', $service)
							&nbsp;&nbsp;&nbsp;&nbsp;
							<a  class="btn btn-primary"
							href="{{ url('/services/'.$service->seq_id.'/edit') }}">
							<i class="font-icon font-icon-pencil"></i>&nbsp;&nbsp;Edit Service</a>
						@endcan
					</span>
					<br>
					<br>
				</div>
		</section>
	</div>
</div>
@include('services.showMap')
@include('services.listClients')

@endsection
