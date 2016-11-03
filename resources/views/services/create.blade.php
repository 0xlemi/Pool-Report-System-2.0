@extends('layouts.app')

@inject('helper', 'App\PRS\Helpers\ServiceHelpers')
@section('content')
<div class="serviceVue">
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

							<div class="form-group row {{($errors->has('longitude') || $errors->has('latitude'))? 'form-group-error':''}}">
								<div class="col-sm-2">Location:</div>
								<div class="col-sm-10">
									<button type="button" class="btn btn-primary" data-toggle="modal"
										:class="locationPickerTag.class"
										data-target="#locationPickerModal">
										<i class="@{{ locationPickerTag.icon }}"></i>&nbsp;&nbsp;&nbsp;
										@{{ locationPickerTag.text }}
									</button>
									<input type="hidden" name="latitude" :value="serviceLatitude">
									<input type="hidden" name="longitude" :value="serviceLongitude">
									@if ($errors->has('latitude') || $errors->has('longitude'))
										<small class="text-muted">Location is required</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('address_line'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Street and number:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="address_line" maxlength="50" :value="serviceAddressLine1" >
									@if ($errors->has('address_line'))
										<small class="text-muted">{{ $errors->first('address_line') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('city'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">City:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="city" maxlength="30" :value="serviceCity" >
									@if ($errors->has('city'))
										<small class="text-muted">{{ $errors->first('city') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('state'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">State:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="state" maxlength="30" :value="serviceState" >
									@if ($errors->has('state'))
										<small class="text-muted">{{ $errors->first('state') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('postal_code'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Postal Code:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="postal_code" maxlength="15" :value="servicePostalCode" >
									@if ($errors->has('postal_code'))
										<small class="text-muted">{{ $errors->first('postal_code') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('country'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Country:</label>
								<div class="col-sm-10">
										<countries country="{{ old('country') }}" ></countries>
										<input type="hidden" name="country" :value="serviceCountry">
									@if ($errors->has('country'))
										<small class="text-muted">{{ $errors->first('country') }}</small>
									@endif
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

	@include('services.locationPicker')
</div>
@endsection
