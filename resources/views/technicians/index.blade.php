@extends('layouts.app')

@section('content')
<header class="section-header">
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>All Technicians</h3>
				<ol class="breadcrumb breadcrumb-simple">
					<li class="active">Technicians</li>
				</ol>
			</div>
		</div>
	</div>
</header>
<div class="row">
	<div class="col-xl-12">
		<section class="box-typical">
			<div id="toolbar">
				<a href="{{ url('technicians/create') }}" class="btn btn-primary">
					<i class="glyphicon glyphicon-wrench"></i>&nbsp;&nbsp;&nbsp;New Technician
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
					        <th data-field="username" data-sortable="true">Username</th>
					        <th data-field="cellphone" data-sortable="true">Cellphone</th>
					        <th data-field="supervisor" data-sortable="true">Supervisor</th>
					    </tr>
					</thead>
					<tbody>
						@foreach ($technicians as $technician)
							<tr>
								<td>{{ $technician->seq_id }}</td>
								<td>{{ $technician->name.' '.$technician->last_name }}</td>
								<td>{{ $technician->user()->email }}</td>
								<td>{{ $technician->cellphone }}</td>
								<td>{{ $technician->supervisor()->name.' '.$technician->supervisor()->last_name }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</section><!--.box-typical-->
	</div>
</div><!--.row-->
@endsection
