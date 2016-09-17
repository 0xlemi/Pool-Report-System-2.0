@extends('layouts.app')

@section('content')
<div class="workOrderVue">
	<header class="section-header">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>Edit Work Order</h3>
					<ol class="breadcrumb breadcrumb-simple">
						<li><a href="{{ url('workorders') }}">Work Orders</a></li>
						<li><a href="{{ url('workorders/'.$workOrder->seq_id) }}">View Work Order {{ $workOrder->seq_id }}</a></li>
						<li class="active">Edit Work Order</li>
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
						<form method="POST" action="{{ url('workorders/'.$workOrder->seq_id) }}">
							{{ csrf_field() }}
							{{ method_field('PATCH') }}
							<input type="hidden" name="seq_id" value="{{ $workOrder->seq_id }}">

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

							<div class="form-group row {{($errors->has('service'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Service</label>
								<div class="col-sm-10">
									<dropdown :key.sync="serviceId"
												:options="{{ $services }}"
												:name="'service'">
									</dropdown>
									@if ($errors->has('service'))
										<small class="text-muted">{{ $errors->first('service') }}</small>
									@endif
								</div>
							</div>

                            <div class="form-group row {{($errors->has('supervisor'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Supervisor</label>
								<div class="col-sm-10">
									<dropdown :key.sync="supervisorId"
												:options="{{ $supervisors }}"
												:name="'supervisor'">
									</dropdown>
									@if ($errors->has('supervisor'))
										<small class="text-muted">{{ $errors->first('supervisor') }}</small>
									@endif
								</div>
							</div>

                            <div class="form-group row {{($errors->has('price') || $errors->has('currency'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Price:</label>
								<div class="col-sm-10">
									<div class="input-group">
										<div class="input-group-addon">$</div>
										<input type="text" class="form-control money-mask-input"
										 		name="price" placeholder="Amount"
										 		value="{{ $workOrder->price }}">
										 <div class="input-group-addon">
										 	<select name='currency' data-live-search="true">
										 		<option value="USD" {{ ($workOrder->currency == 'USD') ? 'selected':'' }}>USD</option>
										 		<option value="MXN" {{ ($workOrder->currency == 'MXN') ? 'selected':'' }}>MXN</option>
										 		<option value="CAD" {{ ($workOrder->currency == 'CAD') ? 'selected':'' }}>CAD</option>
										 	</select>
										 </div>
									</div>
									@if ($errors->has('price'))
										<small class="text-muted">{{ $errors->first('price') }}</small>
									@endif
									@if ($errors->has('currency'))
										<small class="text-muted">{{ $errors->first('currency') }}</small>
									@endif
								</div>
							</div>

                            <div class="form-group row">
								<label class="col-sm-2 form-control-label">Started at</label>
								<div class="col-sm-10">
									<div class='input-group date' id="editGenericDatepicker">
										<input type='text' name='start' class="form-control"
												id="editGenericDatepickerInput">
										@if ($errors->has('start'))
											<small class="text-muted">{{ $errors->first('start') }}</small>
										@endif
										<span class="input-group-addon">
											<i class="font-icon font-icon-calend"></i>
										</span>
									</div>
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
									<button type="button" class="btn btn-warning" @click="openPhotosModal(3)">
										<i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;Before Work
									</button>
								</div>
							</div>

							<hr>
							<p style="float: left;">
								<a  class="btn btn-danger"
								href="{{ url('workorders/'.$workOrder->seq_id) }}">
								<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back</a>
								<button  class="btn btn-success"
								type='submit'>
								<i class="font-icon font-icon-ok"></i>&nbsp;&nbsp;&nbsp;Update Work Order</button>
							</p>
							<br>
							<br>
						</form>
					</div>
			</section>
		</div>
	</div>

@include('workorders.photos')

</div>
@endsection