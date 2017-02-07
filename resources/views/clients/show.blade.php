@extends('layouts.app')

@inject('helper', 'App\PRS\Helpers\ClientHelpers')
@section('content')
	<header class="section-header">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>View Client</h3>
					<ol class="breadcrumb breadcrumb-simple">
						<li><a href="{{ url('clients') }}">Client</a></li>
						<li class="active">View Client {{ $client->seq_id }}</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xl-8 col-xl-offset-2">
			<section class="card">
					<header class="card-header card-header-lg">
						Client info:
					</header>
					<div class="card-block">
						<form>

							@if($client->images->count() > 0)
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Client photo</label>
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
									<input type="text" readonly class="form-control" value="{{ $client->seq_id }}">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Name</label>
								<div class="col-sm-10">
									<input type="text" readonly class="form-control" value="{{ $client->name }}">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Last Name</label>
								<div class="col-sm-10">
									<input type="text" readonly class="form-control" value="{{ $client->last_name }}">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Email</label>
								<div class="col-sm-10">
									<input type="text" readonly class="form-control" value="{{ $client->user()->email }}">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Mobile Phone</label>
								<div class="col-sm-10">
									<input type="text" readonly class="form-control" value="{{ $client->cellphone }}">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Type</label>
								<div class="col-sm-10">
									{!! $helper->styledType($client->type, false) !!}
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Receives email</label>
								<div class="col-sm-10">
									{!! $helper->styleEmailPermissions($client->user) !!}
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Language</label>
								<div class="col-sm-10">
									<input type="text" readonly class="form-control" value="{{ languageCode_to_text($client->language) }}">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Comments</label>
								<div class="col-sm-10">
									<textarea rows="4" class="form-control"
												placeholder="Any additional info about this client."
												name="comments" readonly>{{ $client->comments }}</textarea>
								</div>
							</div>
						</form>
						<hr>
						<div id="toolbar">
							<h3><strong>List of Services</strong></h3>
						</div>
						<div class="table-responsive">
							<table class="generic_table"
								   class="table"
								   data-toolbar="#toolbar"
								   data-search="true"
								   data-show-export="true"
								   data-export-types="['excel', 'pdf']"
								   data-minimum-count-columns="2"
								   data-pagination="true"
								   data-show-footer="false"
								   data-response-handler="responseHandler"
								   >
								<thead>
								    <tr>
								        <th data-field="id" data-sortable="true">#</th>
								        <th data-field="name" data-sortable="true">Name</th>
								        <th data-field="address" data-sortable="true">Address</th>
								        <th data-field="price" data-sortable="true">Price</th>
								    </tr>
								</thead>
								<tbody>
									@foreach ($services as $service)
										<tr>
											<td>{{ $service->seq_id }}</td>
											<td>{{ $service->name }}</td>
											<td>{{ $service->address_line }}</td>
											<td>{!! $service->amount.' <strong>'.$service->currency.'</strong>' !!}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>

						<hr>
						<span style="float: right;">
        					@can('delete', $client)
								<delete-button url="clients/" object-id="{{ $client->seq_id }}">
								</delete-button>
        					@endcan
        					@can('update', $client)
								&nbsp;&nbsp;&nbsp;&nbsp;
								<a  class="btn btn-primary"
								href="{{ url('/clients/'.$client->seq_id.'/edit') }}">
								<i class="font-icon font-icon-pencil"></i>&nbsp;&nbsp;Edit Client</a>
        					@endcan
						</span>
						<br>
						<br>
					</div>
			</section>
		</div>
	</div>
	<div class="row">
	</div>

@endsection
