@extends('layouts.app')

@inject('helper', 'App\PRS\Helpers\ServiceHelpers')
@section('content')
<header class="section-header">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>Create Service</h3>
					<ol class="breadcrumb breadcrumb-simple">
						<li><a href="{{ url('services') }}">Services</a></li>
						<li class="active">Create Service</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xl-8 col-xl-offset-2">
			<section class="card">
					<header class="card-header card-header-lg">
						Service info:
					</header>
					<div class="card-block">
						<form method="POST" action="{{ url('services') }}" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="form-group row {{($errors->has('name'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Name:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="name" maxlength="20" value="{{ old('name') }}">
									@if ($errors->has('name'))
										<small class="text-muted">{{ $errors->first('name') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row">
								<div class="col-sm-2">Location:</div>
								<div class="col-sm-10">
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#locationPickerModal">
									<i class="font-icon font-icon-pin-2"></i>&nbsp;&nbsp;Choose Location</button>
								</div>
							</div>

							<div class="form-group row {{($errors->has('address_line'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Street and number:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="address_line" maxlength="50" :value="serviceAddressLine1" value="{{ old('address_line') }}">
									@if ($errors->has('address_line'))
										<small class="text-muted">{{ $errors->first('address_line') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('city'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">City:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="city" maxlength="30" :value="serviceCity" value="{{ old('city') }}">
									@if ($errors->has('city'))
										<small class="text-muted">{{ $errors->first('city') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('state'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">State:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="state" maxlength="30" :value="serviceState" value="{{ old('state') }}">
									@if ($errors->has('state'))
										<small class="text-muted">{{ $errors->first('state') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('postal_code'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Postal Code:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="postal_code" maxlength="15" :value="servicePostalCode" value="{{ old('postal_code') }}">
									@if ($errors->has('postal_code'))
										<small class="text-muted">{{ $errors->first('postal_code') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('country'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Country:</label>
								<div class="col-sm-10">
										<countries></countries>	
									@if ($errors->has('country'))
										<small class="text-muted">{{ $errors->first('country') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Type:</label>
								<div class="col-sm-10">
									<input type="checkbox" data-toggle="toggle"
										data-on="chlorine" data-off="Salt"
										data-onstyle="info" data-offstyle="primary"
										data-size="small" name="type" {{ (old('type')) ? 'checked':'' }}>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Service Days:</label>
								<div class="col-sm-10">
									<div class="btn-group btn-group-sm" data-toggle="buttons">
										<label class="btn {{ (old('service_days_monday')) ? 'active':'' }}">
											<input type="checkbox" autocomplete="off"
													name="service_days_monday" {{ (old('service_days_monday')) ? 'checked':'' }}>Monday
										</label>
										<label class="btn {{ (old('service_days_tuesday')) ? 'active':'' }}">
											<input type="checkbox" autocomplete="off"
													name="service_days_tuesday" {{ (old('service_days_tuesday')) ? 'checked':'' }}>Tuesday
										</label>
										<label class="btn {{ (old('service_days_wednesday')) ? 'active':'' }}">
											<input type="checkbox" autocomplete="off"
													name="service_days_wednesday" {{ (old('service_days_wednesday')) ? 'checked':'' }}>Wednesday
										</label>
										<label class="btn {{ (old('service_days_thursday')) ? 'active':'' }}">
											<input type="checkbox" autocomplete="off"
													name="service_days_thursday" {{ (old('service_days_thursday')) ? 'checked':'' }}>Thursday
										</label>
										<label class="btn {{ (old('service_days_friday')) ? 'active':'' }}">
											<input type="checkbox" autocomplete="off"
													name="service_days_friday" {{ (old('service_days_friday')) ? 'checked':'' }}>Friday
										</label>
										<label class="btn {{ (old('service_days_saturday')) ? 'active':'' }}">
											<input type="checkbox" autocomplete="off"
													name="service_days_saturday" {{ (old('service_days_saturday')) ? 'checked':'' }}>Saturday
										</label>
										<label class="btn {{ (old('service_days_sunday')) ? 'active':'' }}">
											<input type="checkbox" autocomplete="off"
													name="service_days_sunday" {{ (old('service_days_sunday')) ? 'checked':'' }}>Sunday
										</label>
									</div>
								</div>
							</div>

							<div class="form-group row {{($errors->has('start_time') || $errors->has('end_time'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Time interval:</label>
								<div class="col-sm-10">
									<div class="input-group">
										<div class="input-group-addon">From:</div>
											<div class="input-group clockpicker" data-autoclose="true">
												<input type="text" class="form-control"
														name="start_time" value="{{ old('start_time') }}">
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-time"></span>
												</span>
											</div>
										<div class="input-group-addon">To:</div>
										<div class="input-group clockpicker" data-autoclose="true">
											<input type="text" class="form-control"
													name="end_time" value="{{ old('end_time') }}">
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-time"></span>
											</span>
										</div>
									</div>
									@if ($errors->has('start_time'))
										<small class="text-muted">{{ $errors->first('start_time') }}</small>
									@endif
									@if ($errors->has('end_time'))
										<small class="text-muted">{{ $errors->first('end_time') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('amount') || $errors->has('currency'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Price:</label>
								<div class="col-sm-10">
									<div class="input-group">
										<div class="input-group-addon">$</div>
										<input type="text" class="form-control money-mask-input"
										 		name="amount" placeholder="Amount"
										 		value="{{ old('amount') }}">
										 <div class="input-group-addon">
										 	<select name='currency' data-live-search="true">
										 		<option value="USD" {{ (old('currency') == 'USD') ? 'selected':'' }}>USD</option>
										 		<option value="MXN" {{ (old('currency') == 'MXN') ? 'selected':'' }}>MXN</option>
										 		<option value="CAD" {{ (old('currency') == 'CAD') ? 'selected':'' }}>CAD</option>
										 	</select>
										 </div>
									</div>
									@if ($errors->has('amount'))
										<small class="text-muted">{{ $errors->first('amount') }}</small>
									@endif
									@if ($errors->has('currency'))
										<small class="text-muted">{{ $errors->first('currency') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Status:</label>
								<div class="col-sm-10">
								<input type="checkbox" data-toggle="toggle"
										data-on="Active" data-off="Not Active"
										data-onstyle="success" data-offstyle="danger"
										data-size="small" name="status" {{ (old('status')) ? 'checked':'' }}>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Service Photo</label>
								<div class="col-sm-10">
					                <div class="fileupload fileupload-new" data-provides="fileupload">
					                  <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
					                  <img src="{{ url('img/no_image.png') }}" alt="Placeholder" /></div>
					                  <div class="fileupload-preview fileupload-exists thumbnail"
					                   		style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
					                  @if ($errors->has('photo'))
					                  	<br>
										<span class="label label-danger">{{ $errors->first('photo') }}</span>
										<br><br>
									  @endif
					                  <div>
					                    <span class="btn btn-default btn-file">
					                    <span class="fileupload-new">Select image</span>
					                    <span class="fileupload-exists">Change</span>
					                    <input type="file" name="photo" id="photo" ></span>
					                    <a href="#" class="btn btn-default fileupload-exists"
					                    	data-dismiss="fileupload">Remove</a>
					                  </div>
					                </div>
				              	</div>
							</div>

							<div class="form-group row {{($errors->has('comments'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Comments:</label>
								<div class="col-sm-10">
									<textarea rows="5" class="form-control"
												placeholder="Any additional info about this service."
												name="comments">{{ old('comments') }}</textarea>
									@if ($errors->has('comments'))
										<small class="text-muted">{{ $errors->first('comments') }}</small>
									@endif
								</div>
							</div>

							<hr>
							<p style="float: left;">
								<a  class="btn btn-danger"
								href="{{ url('services') }}">
								<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back</a>
								<button  class="btn btn-success"
								type='submit'>
								<i class="font-icon font-icon-ok"></i>&nbsp;&nbsp;&nbsp;Create Service</button>
							</p>
							<br>
							<br>
						</form>
					</div>
			</section>
		</div>
	</div>
	<!-- Modal for email preview -->
	<div class="modal fade" id="locationPickerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Choose Service Location</h4>
	      </div>
	      <div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<label class="col-sm-2 form-control-label">Search:</label>
							<input type="text" class="form-control"
												id="serviceAddress"
												name="serviceAddress">
					</div>
					<br>
					<br>
					<br>
					<div class="col-md-12">
						<div id="locationPicker" style="width: 650px; height: 450px;"></div>
					</div>
					<br>
					<div class="col-md-12">
						<label class="col-sm-2 form-control-label">Latitude</label>
						<input type="text" class="form-control maxlength-simple"
											id="serviceLatitude"
											name="latitude" maxlength="30">
						<label class="col-sm-2 form-control-label">Longitude</label>
						<input type="text" class="form-control maxlength-simple"
											id="serviceLongitude"
											name="longitude" maxlength="30">
					</div>
				</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-info" @click="populateAddressFields('create')" data-dismiss="modal"><i class="font-icon font-icon-map"></i>&nbsp;&nbsp;Populate Address Fields</button>
	        <button type="button" class="btn btn-success" data-dismiss="modal"><i class="font-icon font-icon-ok"></i>&nbsp;&nbsp;Set Location</button>
	      </div>
	    </div>
	  </div>
	</div>
@endsection
