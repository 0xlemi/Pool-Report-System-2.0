@extends('layouts.app')

@section('content')
	<header class="section-header">
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>All Services</h3>
				<ol class="breadcrumb breadcrumb-simple">
					<li class="active">Services</li>
				</ol>
			</div>
		</div>
	</div>
</header>
<div class="row">
	<div class="col-xl-12">
		<section class="box-typical">
			<div id="toolbar">
				<a href="{{ url('services/create') }}" class="btn btn-primary">
					<i class="font-icon font-icon-home"></i>&nbsp;&nbsp;&nbsp;New Service
				</a>
			</div>
			<div class="table-responsive">
				<table id="reports_table"
					   class="table"
					   data-toolbar="#toolbar"
					   data-search="true"
					   data-show-export="true"
					   data-export-types="['excel', 'pdf']"
					   data-detail-view="true"
					   data-detail-formatter="detailFormatter"
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
					        <th data-field="type" data-sortable="true">Type</th>
					        <th data-field="service_days" data-sortable="true">Service Days</th>
					        <th data-field="price" data-sortable="true">Price</th>
					    </tr>
					</thead>
					<tbody>
						@foreach ($services as $service)
							<tr>
								<td>{{ $service->seq_id }}</td>
								<td>{{ $service->name }}</td>
								<td>{{ $service->address_line }}</td>
								<td>{!! get_styled_type($service->type) !!}</td>
								<td>{!! get_styled_service_days($service->service_days) !!}</td>
								<td>{!! $service->amount.' <strong>'.$service->currency.'</strong>' !!}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</section><!--.box-typical-->
	</div>
</div><!--.row-->
@endsection