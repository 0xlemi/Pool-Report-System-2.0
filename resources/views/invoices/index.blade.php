@extends('layouts.app')

@section('content')
<div class="invoiceVue">
	<header class="section-header">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>All Invoices</h3>
					<ol class="breadcrumb breadcrumb-simple">
						<li class="active">Invoices</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="col-xl-12">
			<section class="box-typical">
				<div id="toolbar">
					<div class="checkbox-toggle" style="display:inline;position:relative;left:30px;">
						<input type="checkbox" id="statusSwitch" v-model="statusSwitch"
								@click="changeStatus(statusSwitch)">
						<label for="statusSwitch">Closed</label>
					</div>
				</div>
				<div class="table-responsive">
					<table class="generic_table"
						   data-toolbar="#toolbar"
						   data-url='{{ $defaultTableUrl }}'
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
						        <th data-field="type" data-sortable="true">Type</th>
						        <th data-field="amount" data-sortable="true">Amount</th>
						        <th data-field="closed" data-sortable="true">Closed</th>
						    </tr>
						</thead>
					</table>
				</div>
			</section><!--.box-typical-->
		</div>
	</div><!--.row-->
</div>
@endsection
