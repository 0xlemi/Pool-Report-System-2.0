@extends('layouts.app')

@inject('workOrderHelpers', 'App\PRS\Helpers\WorkOrderHelpers')
@section('content')
<div class="workOrderVue">
	<header class="section-header">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>View Work Order</h3>
					<ol class="breadcrumb breadcrumb-simple">
						<li><a href="{{ url('workorders') }}">Work Orders</a></li>
						<li class="active">View Work Order {{ $workOrder->seq_id }}</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xl-8 col-xl-offset-2">
			<section class="card">
					<header class="card-header card-header-lg">
						Work Order info:
					</header>
					<div class="card-block">

                            <div class="form-group row">
								<label class="col-sm-2 form-control-label">Status:</label>
								<div class="col-sm-10">
									{!! $workOrderHelpers->styleFinishedStatus($workOrder->finished) !!}
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">ID</label>
								<div class="col-sm-10">
									<p class="form-control-static"><input type="text" readonly class="form-control" value="{{ $workOrder->seq_id }}"></p>
								</div>
							</div>

							<div class="form-group row {{($errors->has('title'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Title:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="title" maxlength="50" value="{{ $workOrder->title }}">
									@if ($errors->has('title'))
										<small class="text-muted">{{ $errors->first('title') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Service Name</label>
								<div class="col-sm-10">
									<p class="form-control-static"><input type="text" readonly class="form-control" value="{{ $workOrder->service()->name }}"></p>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Supervisor Name</label>
								<div class="col-sm-10">
									<p class="form-control-static"><input type="text" readonly class="form-control" value="{{ $workOrder->supervisor()->name }}"></p>
								</div>
							</div>

                            <div class="form-group row">
								<label class="col-sm-2 form-control-label">Price</label>
								<div class="col-sm-10">
									<input type="text" readonly class="form-control" value="{{ $workOrder->price.' '.$workOrder->currency }}">
								</div>
							</div>

                            <div class="form-group row">
								<label class="col-sm-2 form-control-label">Started at</label>
								<div class="col-sm-10">
									<p class="form-control-static"><input type="text" readonly class="form-control" value="{{ $workOrderHelpers->format_date($workOrder->start) }}"></p>
								</div>
							</div>

							<div class="form-group row" v-if="finished">
								<label class="col-sm-2 form-control-label">Finished at</label>
								<div class="col-sm-10">
									<p class="form-control-static"><input type="text" readonly class="form-control" value="{{ $workOrderHelpers->format_date($workOrder->end) }}"></p>
								</div>
							</div>

							<div class="form-group row {{($errors->has('description'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Description:</label>
								<div class="col-sm-10">
									<textarea rows="5" class="form-control"
												placeholder="Describe the work order to be done."
												name="description">{{ $workOrder->description }}</textarea>
									@if ($errors->has('description'))
										<small class="text-muted">{{ $errors->first('description') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Photos</label>
								<div class="col-sm-10">
									<button type="button" class="btn btn-warning" @click="openPhotosModal(1)">
										<i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;Before Work
									</button>
									<button v-if="finished" type="button" class="btn btn-info" @click="openPhotosModal(2)">
										<i class="glyphicon glyphicon-check"></i>&nbsp;&nbsp;After Work
									</button>
								</div>
							</div>

						<br>

						<h5>Work Done:</h4>
						<div id="toolbar">
							<button tyle="button" class="btn btn-primary" @click="openWorkModal(1)">
								<i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;&nbsp;Add Work
							</button>
						</div>
						<div class="table-responsive">
							<table id="worksTable"
								   data-toolbar="#toolbar"
								   data-url='{{ $default_table_url }}'
								   data-page-size="5"
								   data-search='true'
								   data-show-export="true"
								   data-export-types="['excel', 'pdf']"
								   data-minimum-count-columns="2"
								   data-show-footer="false"
								   >
								<thead>
								    <tr>
								        <th data-field="id" data-visible="false"></th>
								        <th data-field="title" data-sortable="true">Title</th>
								        <th data-field="quantity" data-sortable="true">Quantity</th>
								        <th data-field="cost" data-sortable="true">Cost</th>
								        <th data-field="technician" data-sortable="true">Technician</th>
								    </tr>
								</thead>
							</table>
						</div>

						<hr>
						<!-- <p style="float: left;display:inline;">
							<button  class="btn btn-info"
							 data-toggle="modal" >
							<i class="font-icon font-icon-mail"></i>&nbsp;&nbsp;Preview email</button>
						</p> -->
						<p style="float: right;display:inline;">
							<a class="btn btn-danger"
							data-method="delete" data-token="{{ csrf_token() }}"
			        		data-confirm="Are you sure?" href="{{ url('/workorders/'.$workOrder->seq_id) }}">
							<i class="font-icon font-icon-close-2"></i>&nbsp;&nbsp;Delete</a>
							<a  class="btn btn-primary"
							href="{{ url('/workorders/'.$workOrder->seq_id.'/edit') }}">
							<i class="font-icon font-icon-pencil"></i>&nbsp;&nbsp;Edit Work Order</a>
							<button v-if="!(finished)" class="btn btn-success" @click="openFinishModal()">
							<i class="font-icon font-icon-ok"></i>&nbsp;&nbsp;Finish Work Order</button>
						</p>
						<br>
						<br>
					</div>
			</section>
		</div>
	</div>

@include('workorders.works')
@include('workorders.finish')
@include('workorders.photos')

</div>
@endsection
