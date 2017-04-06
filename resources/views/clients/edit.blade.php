@extends('layouts.app')

@section('content')
	<header class="section-header">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>Edit Client</h3>
					<ol class="breadcrumb breadcrumb-simple">
						<li><a href="{{ url('clients') }}">Clients</a></li>
						<li><a href="{{ url('clients/'.$client->seq_id) }}">View Client {{ $client->seq_id }}</a></li>
						<li class="active">Edit Client</li>
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
						<form method="POST" action="{{ url('clients/'.$client->seq_id) }}" enctype="multipart/form-data">
							{{ csrf_field() }}
							{{ method_field('PATCH') }}
							<input type="hidden" name="seq_id" value="{{ $client->seq_id }}">
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Client Photo:</label>
								<div class="col-sm-10">
					                <div class="fileupload fileupload-new" data-provides="fileupload">
					                  <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
					                  <img src="{{ \Storage::url($client->thumbnail()) }}" alt="Placeholder" /></div>
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

							<div class="form-group row {{($errors->has('cellphone'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Mobile Phone:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="cellphone" maxlength="20" value="{{ $client->cellphone }}">
									@if ($errors->has('cellphone'))
										<small class="text-muted">{{ $errors->first('cellphone') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('address'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Address:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="address" maxlength="50" value="{{ $client->address }}">
									@if ($errors->has('address'))
										<small class="text-muted">{{ $errors->first('address') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('type'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Type:</label>
								<div class="col-md-3 col-lg-3 col-xl-4">
									<select class="bootstrap-select bootstrap-select-arrow" name="type">
										<option value="1" {{ ($client->type == 1) ? 'selected':'' }}>
											House Owner
										</option>
										<option value="2" {{ ($client->type == 2) ? 'selected':'' }}>
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
										<option value="en" {{ ($client->language == 'en') ? 'selected':'' }}>
											English
										</option>
										<option value="es" {{ ($client->language == 'es') ? 'selected':'' }}>
											Español
										</option>
									</select>
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
											<option value={{ $service->seq_id }} {{ ($client->hasService($service->seq_id)) ? 'selected' : ''}}>
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
												name="about">{{ $client->about }}</textarea>
									@if ($errors->has('about'))
										<small class="text-muted">{{ $errors->first('about') }}</small>
									@endif
								</div>
							</div>

							<hr>
							<span style="float:right;">
								<a  class="btn btn-warning"
								href="{{ url('clients/'.$client->seq_id) }}">
								<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back</a>
								<button  class="btn btn-success"
								type='submit'>
								<i class="font-icon font-icon-ok"></i>&nbsp;&nbsp;&nbsp;Edit Client</button>
							</span>
							<br>
							<br>
						</form>
					</div>
			</section>
		</div>
	</div>
@endsection
