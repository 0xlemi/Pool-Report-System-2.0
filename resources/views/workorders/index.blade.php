@extends('layouts.app')

@section('content')
<div class="serviceVue">
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
						<i class="font-icon font-icon-home"></i>&nbsp;&nbsp;&nbsp;New Work Order
					</a>
				</div>
				<div class="table-responsive">
					<table class="generic_table"
						   data-toolbar="#toolbar"
						   data-url=''
						   data-page-list='[5, 10, 20, 50, 100, 200]'
						   data-search='true'
						   data-show-export="true"
						   data-export-types="['excel', 'pdf']"
						   data-minimum-count-columns="2"
						   data-show-footer="false"
						   >
						<thead>
						    <tr>
						    </tr>
						</thead>
					</table>
				</div>
			</section><!--.box-typical-->
		</div>
	</div><!--.row-->
</div>
@endsection
