@extends('layouts.app')

@section('content')
<div class="workOrderVue">
	<header class="section-header">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>All Work Orders</h3>
					<ol class="breadcrumb breadcrumb-simple">
						<li class="active">Work Orders</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="col-xl-12">
			<section class="box-typical">
				<div id="toolbar">
					<a href="{{ url('workorders/create') }}" class="btn btn-primary">
						<i class="glyphicon glyphicon-briefcase"></i>&nbsp;&nbsp;&nbsp;New Work Order
					</a>
					<div class="checkbox-toggle" style="display:inline;position:relative;left:30px;">
						<input type="checkbox" id="finishedSwitch" v-model="finishedSwitch"
								@click="changeWorkOrderListFinished(finishedSwitch)">
						<label for="finishedSwitch">Finished</label>
					</div>
				</div>
				<div class="table-responsive">
					<table class="generic_table"
						   data-toolbar="#toolbar"
						   data-url='{{ $default_table_url }}'
						   data-page-list='[5, 10, 20, 50, 100, 200]'
						   data-search='true'
						   data-show-export="true"
						   data-export-types="['excel', 'pdf']"
						   data-minimum-count-columns="2"
						   data-show-footer="false"
						   >
						<thead>
						    <tr>
						        <th data-field="id" data-sortable="true">#</th>
						        <th data-field="service" data-sortable="true">Service</th>
						        <th data-field="supervisor" data-sortable="true">Supervisor</th>
						        <th data-field="start" data-sortable="true">Start at</th>
						        <th data-field="end" data-sortable="true">End at</th>
						        <th data-field="price" data-sortable="true">Price</th>
						    </tr>
						</thead>
					</table>
				</div>
			</section><!--.box-typical-->
		</div>
	</div><!--.row-->
</div>
@endsection
