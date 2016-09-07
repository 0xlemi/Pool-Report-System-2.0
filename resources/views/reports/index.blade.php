@extends('layouts.app')

@section('content')
<div class="reportVue">
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
					&nbsp;&nbsp;
					<button class="btn btn-warning" data-toggle="modal"
								data-target="#missingServicesModal"
								:class="( numServicesMissing < 1 ) ? 'btn-success' : 'btn-warning'"
								:disabled="( numServicesMissing < 1 )">
						<i class="glyphicon glyphicon-home"></i>&nbsp;&nbsp;
						@{{ missingServicesTag }}
					</button>
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
					            <th data-field="id">#</th>
						        <th data-field="service">Service</th>
						        <th data-field="on_time">On time</th>
						        <th data-field="technician">Technician</th>
					        </tr>
			            </thead>
			        </table>
				</div>
			</section><!--.box-typical-->
		</div>
	</div><!--.row-->

	<!-- Modal for email preview -->
	<div class="modal fade" id="missingServicesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
		    <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Missing Services</h4>
			</div>
			<div id="missingServicesToolbar">
				<div class="progress-steps-caption">@{{ numServicesDone }}/@{{ numServicesToDo }}&nbsp; Services Completed</div>
			</div>
	    	<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<section class="box-typical">
							<div class="table-responsive">
								<table id="missingServices"
				   					   data-toolbar="#missingServicesToolbar"
									   data-url='{{ $default_missing_table_url }}'
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
									        <th data-field="price" data-sortable="true">Price</th>
								        </tr>
						            </thead>
						        </table>
							</div>
						</section><!--.box-typical-->
					</div>
				</div>
	    	</div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>
</div>
@endsection
