@extends('layouts.app')

@section('content')
<div class="technicianVue">
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
					<div class="checkbox-toggle" style="display:inline;position:relative;left:30px;">
						<input type="checkbox" id="statusSwitch" v-model="statusSwitch"
								@click="changeTechnicianListStatus(statusSwitch)">
						<label for="statusSwitch">Status</label>
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
						        <th data-field="name" data-sortable="true">Name</th>
						        <th data-field="username" data-sortable="true">Username</th>
						        <th data-field="cellphone" data-sortable="true">Cellphone</th>
						        <th data-field="supervisor" data-sortable="true">Supervisor</th>
						    </tr>
						</thead>
					</table>
				</div>
			</section><!--.box-typical-->
		</div>
	</div><!--.row-->
</div>
@endsection
