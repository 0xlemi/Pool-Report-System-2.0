@extends('layouts.app')

@section('content')
<header class="section-header">
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>Create Client</h3>
				<ol class="breadcrumb breadcrumb-simple">
					<li><a href="{{ url('clients') }}">Clients</a></li>
					<li class="active">Create Client</li>
				</ol>
			</div>
		</div>
	</div>
</header>
<div class="row">
	<div class="col-md-12 col-lg-12 col-xl-8 col-xl-offset-2">
		<section class="card">
				<header class="card-header card-header-lg">
					Client info:
				</header>
				<div class="card-block">
					<form method="POST" action="{{ url('clients') }}" enctype="multipart/form-data">
						{{ csrf_field() }}

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Client Photo:</label>
							<div class="col-sm-10">
				                <div class="fileupload fileupload-new" data-provides="fileupload">
				                  <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
				                  <img src="{{ \Storage::url('images/assets/app/no_image.png') }}" alt="Placeholder" /></div>
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

						<div class="form-group row {{($errors->has('name'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Name:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control maxlength-simple"
										name="name" maxlength="30" value="{{ old('name') }}">
								<small class="text-muted">This value is only used if client don't have a account already.</small>
								@if ($errors->has('name'))
									<small class="text-muted">{{ $errors->first('name') }}</small>
								@endif
							</div>
						</div>

						<div class="form-group row {{($errors->has('last_name'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Last name:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control maxlength-simple"
										name="last_name" maxlength="60" value="{{ old('last_name') }}">
								<small class="text-muted">This value is only used if client don't have a account already.</small>
								@if ($errors->has('last_name'))
									<small class="text-muted">{{ $errors->first('last_name') }}</small>
								@endif
							</div>
						</div>

						<div class="form-group row {{($errors->has('email'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Email:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control"
										name="email" value="{{ old('email') }}">
								@if ($errors->has('email'))
									<small class="text-muted">{{ $errors->first('email') }}</small>
								@endif
							</div>
						</div>

						<div class="form-group row {{($errors->has('cellphone'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Mobile Phone:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control maxlength-simple"
										name="cellphone" maxlength="50" value="{{ old('cellphone') }}">
								@if ($errors->has('cellphone'))
									<small class="text-muted">{{ $errors->first('cellphone') }}</small>
								@endif
							</div>
						</div>

						<div class="form-group row {{($errors->has('address'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Address:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control maxlength-simple"
										name="address" maxlength="100" value="{{ old('address') }}">
								@if ($errors->has('address'))
									<small class="text-muted">{{ $errors->first('address') }}</small>
								@endif
							</div>
						</div>

						<div class="form-group row {{($errors->has('type'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Type:</label>
							<div class="col-md-3 col-lg-3 col-xl-4">
								<select class="bootstrap-select bootstrap-select-arrow" name="type">
									<option value="1" {{ (old('type') == 1) ? 'selected':'' }}>
										House Owner
									</option>
									<option value="2" {{ (old('type') == 2) ? 'selected':'' }}>
										House Administrator
									</option>
								</select>
								@if ($errors->has('type'))
									<small class="text-muted">{{ $errors->first('type') }}</small>
								@endif
							</div>
						</div>

						<div class="form-group row {{($errors->has('language'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Language:</label>
							<div class="col-md-3 col-lg-3 col-xl-4">
								<select class="bootstrap-select bootstrap-select-arrow" name="language">
									<option value="en" {{ (old('language') == 'en') ? 'selected':'' }}>
										English
									</option>
									<option value="es" {{ (old('language') == 'es') ? 'selected':'' }}>
										Español
									</option>
								</select>
								<small class="text-muted">This value is only used if client don't have a account already.</small>
								@if ($errors->has('language'))
									<small class="text-muted">{{ $errors->first('language') }}</small>
								@endif
							</div>
						</div>

						<div class="form-group row {{($errors->has('services'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Services:</label>
							<div class="col-sm-10">
								<select class="select2" multiple="multiple" name="services[]">
									@foreach($services as $service)
										<option value={{ $service->seq_id }} >
											{{ $service->seq_id.' '.$service->name }}
										</option>
									@endforeach
								</select>
								@if ($errors->has('services'))
									<small class="text-muted">{{ $errors->first('services') }}</small>
								@endif
							</div>
						</div>

						<div class="form-group row {{($errors->has('about'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">About Client:</label>
							<div class="col-sm-10">
								<textarea rows="5" class="form-control"
											placeholder="Any additional info about this client."
											name="about">{{ old('about') }}</textarea>
								@if ($errors->has('about'))
									<small class="text-muted">{{ $errors->first('about') }}</small>
								@endif
							</div>
						</div>

						<hr>
						<p style="float: left;">
							<a  class="btn btn-danger"
							href="{{ url('clients') }}">
							<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back</a>
							<button  class="btn btn-success"
							type='submit'>
							<i class="font-icon font-icon-ok"></i>&nbsp;&nbsp;&nbsp;Create Client</button>
						</p>
						<br>
						<br>
					</form>
				</div>
		</section>
	</div>
</div>
@endsection
