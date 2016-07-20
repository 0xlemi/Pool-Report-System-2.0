@extends('layouts.app')

@inject('helper', 'App\PRS\Helpers\ServiceHelpers')
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
				<div class="checkbox-toggle" style="display:inline;position:relative;left:30px;">
					<input type="checkbox" id="statusSwitch" v-model="statusSwitch"
							@click="changeServiceListStatus(statusSwitch)">
					<label for="statusSwitch">Status</label>
				</div>
			</div>
			<div class="table-responsive">
				<table id="generic_table"
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
					        <th data-field="address" data-sortable="true">Address</th>
					        <th data-field="type" data-sortable="true">Type</th>
					        <th data-field="serviceDays" data-sortable="true">Service Days</th>
					        <th data-field="price" data-sortable="true">Price</th>
					    </tr>
					</thead>
				</table>
			</div>
		</section><!--.box-typical-->
	</div>
</div><!--.row-->
@endsection
