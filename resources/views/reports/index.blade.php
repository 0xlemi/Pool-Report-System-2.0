@extends('layouts.app')

@section('content')
<header class="section-header">
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>All Reports</h3>
				<ol class="breadcrumb breadcrumb-simple">
					<li class="active">Reports</li>
				</ol>
			</div>
		</div>
	</div>
</header>
<div class="row">
	<div class="col-xl-2">
		<section class='box-typical'>
			<section class="calendar-page-side-section">
				<div class="calendar-page-side-section-in">
					<div class="datepicker-inline" id="side-datetimepicker"></div>
				</div>
			</section>
		</section>
	</div>
	<div class="col-xl-10">
		<section class="box-typical">
			<div id="toolbar">
				<a href="{{ url('reports/create') }}" class="btn btn-primary">
					<i class="font-icon font-icon-page"></i>&nbsp;&nbsp;&nbsp;New Report
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
					        <th data-field="service" data-sortable="true">Service</th>
					        <th data-field="on_time" data-sortable="true">On time</th>
					        <th data-field="technician" data-sortable="true">Technician</th>
					    </tr>
					</thead>
					<tbody>
						@foreach ($reports as $report)
							<tr>
								<td>{{ $report->seq_id }}</td>
								<td>{{ $report->service()->name }}</td>
								<td>{{ $report->on_time }}</td>
								<td>{{ $report->technician()->name }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</section><!--.box-typical-->
	</div>
</div><!--.row-->
@endsection
