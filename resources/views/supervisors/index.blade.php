@extends('layouts.app')

@section('content')
<header class="section-header">
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>All Supervisors</h3>
				<ol class="breadcrumb breadcrumb-simple">
					<li class="active">Supervisors</li>
				</ol>
			</div>
		</div>
	</div>
</header>
<div class="row">
	<div class="col-xl-12">
		<section class="box-typical">
			<div id="toolbar">
				<a href="{{ url('supervisors/create') }}" class="btn btn-primary">
					<i class="font-icon font-icon-eye"></i>&nbsp;&nbsp;&nbsp;New Supervisor
				</a>
			</div>
			<div class="table-responsive">
				<table id="generic_table"
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
					        <th data-field="address" data-sortable="true">Email</th>
					        <th data-field="service_days" data-sortable="true">Cellphone</th>
					    </tr>
					</thead>
					<tbody>
						@foreach ($supervisors as $supervisor)
							<tr>
								<td>{{ $supervisor->seq_id }}</td>
								<td>{{ $supervisor->name.' '.$supervisor->last_name }}</td>
								<td>{{ $supervisor->user()->email }}</td>
								<td>{{ $supervisor->cellphone }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</section><!--.box-typical-->
	</div>
</div><!--.row-->
@endsection
