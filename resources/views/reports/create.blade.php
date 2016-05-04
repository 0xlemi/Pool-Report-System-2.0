@extends('layouts.app')

@section('content')
	<header class="section-header">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>Create Report</h3>
					<ol class="breadcrumb breadcrumb-simple">
						<li><a href="{{ url('reports') }}">Reports</a></li>
						<li class="active">Create Report</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xl-8 col-xl-offset-2">
			<section class="card">
					<header class="card-header card-header-lg">
						Report info:
					</header>
					<div class="card-block">
						<form method="POST" action="{{ url('reports') }}">
							{{ csrf_field() }}
							<div class="form-group row {{($errors->has('completed_at'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Compleated at:</label>
								<div class="col-sm-10">
									<div class='input-group date' id="edit_report_datepicker">
										<input type='text' name='completed_at' class="form-control" id="edit_report_datepicker_input"/>
										@if ($errors->has('completed_at'))
											<small class="text-muted">{{ $errors->first('completed_at') }}</small>
										@endif
										<span class="input-group-addon">
											<i class="font-icon font-icon-calend"></i>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Service</label>
								<div class="col-sm-10">
									<select class="bootstrap-select bootstrap-select-arrow" name="service" data-live-search="true">
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #000;">
																</span>&nbsp;&nbsp;Choose a service'
																value="0" >Choose a service
										</option>
										@foreach($services as $service)
											<option data-content='<span class="user-item"><img src="{{ url($service->icon()) }}"/>
														{{ $service->seq_id.' '.$service->name.' '.$service->last_name}}
														</span>' value="{{ $service->seq_id }}">
														{{ $service->name.' '.$service->last_name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Technician</label>
								<div class="col-sm-10">
									<select class="bootstrap-select bootstrap-select-arrow" name="technician" data-live-search="true">
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #000;">
																</span>&nbsp;&nbsp;Choose a technician'
																value="0" >Choose a technician
										</option>
										@foreach($technicians as $technician)
											<option data-content='<span class="user-item">
														<img src="{{ url($technician->icon()) }}"/>
														{{ $technician->seq_id.' '.$technician->name.' '.$technician->last_name}}
														</span>' value="{{ $technician->seq_id }}">
														{{ $technician->name.' '.$technician->last_name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">PH</label>
								<div class="col-md-3 col-lg-3 col-xl-4">
									<select class="bootstrap-select bootstrap-select-arrow" name="ph">
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #000;">
																</span>&nbsp;&nbsp;Choose an option'
																value="0" >Choose an option
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #FA424A;">
																</span>&nbsp;&nbsp;Very High'
																value="5" >Very High
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #FDAD2A;">
																</span>&nbsp;&nbsp;High'
																value="4" >High
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #46C35F;">
																</span>&nbsp;&nbsp;Perfect'
																value="3" >Perfect
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #00A8FF;">
																</span>&nbsp;&nbsp;Low'
																value="2" >Low
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #AC6BEC;">
																</span>&nbsp;&nbsp;Very Low'
																value="1" >Very Low
										</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Clorine</label>
								<div class="col-md-3 col-lg-3 col-xl-4">
									<select class="bootstrap-select bootstrap-select-arrow" name="clorine">
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #000;">
																</span>&nbsp;&nbsp;Choose an option'
																value="0" >Choose an option
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #FA424A;">
																</span>&nbsp;&nbsp;Very High'
																value="5" >Very High
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #FDAD2A;">
																</span>&nbsp;&nbsp;High'
																value="4" >High
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #46C35F;">
																</span>&nbsp;&nbsp;Perfect'
																value="3" >Perfect
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #00A8FF;">
																</span>&nbsp;&nbsp;Low'
																value="2" >Low
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #AC6BEC;">
																</span>&nbsp;&nbsp;Very Low'
																value="1" >Very Low
										</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Temperature</label>
								<div class="col-md-3 col-lg-3 col-xl-4">
									<select class="bootstrap-select bootstrap-select-arrow" name="temperature">
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #000;">
																</span>&nbsp;&nbsp;Choose an option'
																value="0" >Choose an option
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #FA424A;">
																</span>&nbsp;&nbsp;Very High'
																value="5" >Very High
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #FDAD2A;">
																</span>&nbsp;&nbsp;High'
																value="4" >High
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #46C35F;">
																</span>&nbsp;&nbsp;Perfect'
																value="3" >Perfect
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #00A8FF;">
																</span>&nbsp;&nbsp;Low'
																value="2" >Low
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #AC6BEC;">
																</span>&nbsp;&nbsp;Very Low'
																value="1" >Very Low
										</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Turbidity</label>
								<div class="col-md-3 col-lg-3 col-xl-4">
									<select class="bootstrap-select bootstrap-select-arrow" name="turbidity">
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #000;">
																</span>&nbsp;&nbsp;Choose an option'
																value="0" >Choose an option
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #FA424A;">
																</span>&nbsp;&nbsp;Very High'
																value="4" >Very High
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #FDAD2A;">
																</span>&nbsp;&nbsp;High'
																value="3" >High
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #00A8FF;">
																</span>&nbsp;&nbsp;Low'
																value="2" >Low
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #46C35F;">
																</span>&nbsp;&nbsp;Perfect'
																value="1" >Perfect
										</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Salt</label>
								<div class="col-md-3 col-lg-3 col-xl-4">
									<select class="bootstrap-select bootstrap-select-arrow" name="salt">
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #000;">
																</span>&nbsp;&nbsp;Choose an option'
																value="0" >Choose an option
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #FA424A;">
																</span>&nbsp;&nbsp;Very High'
																value="5" >Very High
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #FDAD2A;">
																</span>&nbsp;&nbsp;High'
																value="5" >High
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #46C35F;">
																</span>&nbsp;&nbsp;Perfect'
																value="3" >Perfect
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #00A8FF;">
																</span>&nbsp;&nbsp;Low'
																value="2" >Low
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk" 
																style="color: #AC6BEC;">
																</span>&nbsp;&nbsp;Very Low'
																value="1" >Very Low
										</option>
									</select>
								</div>
							</div>
							<hr>
							<p style="float: left;">
								<a  class="btn btn-danger"
								href="{{ url('reports') }}">
								<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back</a>
								<button  class="btn btn-success"
								type='submit'>
								<i class="font-icon font-icon-ok"></i>&nbsp;&nbsp;&nbsp;Create Report</button>
							</p>
							<br>
							<br>
						</form>
					</div>
			</section>
		</div>
	</div>
@endsection