@extends('layouts.app')

@section('content')
<header class="section-header">
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>New Report</h3>
				<ol class="breadcrumb breadcrumb-simple">
					<li><a href="{{ url('todaysroute') }}">Services Missing</a></li>
					<li class="active">New Report</li>
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
					<form method="POST" action="{{ url('todaysroute/report') }}" enctype="multipart/form-data">
						{{ csrf_field() }}

                        <input type="hidden" name='service_id' value="{{ $service_id }}">

						<div class="form-group row {{($errors->has('technician'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Technician</label>
							<div class="col-sm-10">
								<dropdown :key.sync="dropdownKey2"
											:options="{{ $technicians }}"
											:name="'technician_id'">
								</dropdown>
								@if ($errors->has('technician'))
									<small class="text-muted">{{ $errors->first('technician') }}</small>
								@endif
							</div>
						</div>

						<div class="form-group row {{($errors->has('ph'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">PH</label>
							<div class="col-md-3 col-lg-3 col-xl-4">
								<select class="bootstrap-select bootstrap-select-arrow" name="ph">
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #000;">
															</span>&nbsp;&nbsp;Choose an option'
															value="0"
															{{ (old('ph') == 0) ? 'selected':'' }}
															>Choose an option
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #FA424A;">
															</span>&nbsp;&nbsp;Very High'
															value="5"
															{{ (old('ph') == 5) ? 'selected':'' }}
															>Very High
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #FDAD2A;">
															</span>&nbsp;&nbsp;High'
															value="4"
															{{ (old('ph') == 4) ? 'selected':'' }}
															>High
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #46C35F;">
															</span>&nbsp;&nbsp;Perfect'
															value="3"
															{{ (old('ph') == 3) ? 'selected':'' }}
															>Perfect
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #00A8FF;">
															</span>&nbsp;&nbsp;Low'
															value="2"
															{{ (old('ph') == 2) ? 'selected':'' }}
															>Low
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #AC6BEC;">
															</span>&nbsp;&nbsp;Very Low'
															value="1"
															{{ (old('ph') == 1) ? 'selected':'' }}
															>Very Low
									</option>
								</select>
								@if ($errors->has('ph'))
									<small class="text-muted">{{ $errors->first('ph') }}</small>
								@endif
							</div>
						</div>
						<div class="form-group row {{($errors->has('chlorine'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Chlorine</label>
							<div class="col-md-3 col-lg-3 col-xl-4">
								<select class="bootstrap-select bootstrap-select-arrow" name="chlorine">
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #000;">
															</span>&nbsp;&nbsp;Choose an option'
															value="0"
															{{ (old('chlorine') == 0) ? 'selected':'' }}
															>Choose an option
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #FA424A;">
															</span>&nbsp;&nbsp;Very High'
															value="5"
															{{ (old('chlorine') == 5) ? 'selected':'' }}
															>Very High
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #FDAD2A;">
															</span>&nbsp;&nbsp;High'
															value="4"
															{{ (old('chlorine') == 4) ? 'selected':'' }}
															>High
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #46C35F;">
															</span>&nbsp;&nbsp;Perfect'
															value="3"
															{{ (old('chlorine') == 3) ? 'selected':'' }}
															>Perfect
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #00A8FF;">
															</span>&nbsp;&nbsp;Low'
															value="2"
															{{ (old('chlorine') == 2) ? 'selected':'' }}
															>Low
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #AC6BEC;">
															</span>&nbsp;&nbsp;Very Low'
															value="1"
															{{ (old('chlorine') == 1) ? 'selected':'' }}
															>Very Low
									</option>
								</select>
								@if ($errors->has('chlorine'))
									<small class="text-muted">{{ $errors->first('chlorine') }}</small>
								@endif
							</div>
						</div>
						<div class="form-group row {{($errors->has('temperature'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Temperature</label>
							<div class="col-md-3 col-lg-3 col-xl-4">
								<select class="bootstrap-select bootstrap-select-arrow" name="temperature">
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #000;">
															</span>&nbsp;&nbsp;Choose an option'
															value="0"
															{{ (old('temperature') == 0) ? 'selected':'' }}
															>Choose an option
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #FA424A;">
															</span>&nbsp;&nbsp;Very High'
															value="5"
															{{ (old('temperature') == 5) ? 'selected':'' }}
															>Very High
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #FDAD2A;">
															</span>&nbsp;&nbsp;High'
															value="4"
															{{ (old('temperature') == 4) ? 'selected':'' }}
															>High
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #46C35F;">
															</span>&nbsp;&nbsp;Perfect'
															value="3"
															{{ (old('temperature') == 3) ? 'selected':'' }}
															>Perfect
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #00A8FF;">
															</span>&nbsp;&nbsp;Low'
															value="2"
															{{ (old('temperature') == 2) ? 'selected':'' }}
															>Low
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #AC6BEC;">
															</span>&nbsp;&nbsp;Very Low'
															value="1"
															{{ (old('temperature') == 1) ? 'selected':'' }}
															>Very Low
									</option>
								</select>
								@if ($errors->has('temperature'))
									<small class="text-muted">{{ $errors->first('temperature') }}</small>
								@endif
							</div>
						</div>
						<div class="form-group row {{($errors->has('turbidity'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Turbidity</label>
							<div class="col-md-3 col-lg-3 col-xl-4">
								<select class="bootstrap-select bootstrap-select-arrow" name="turbidity">
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #000;">
															</span>&nbsp;&nbsp;Choose an option'
															value="0"
															{{ (old('turbidity') == 0) ? 'selected':'' }}
															>Choose an option
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #FA424A;">
															</span>&nbsp;&nbsp;Very High'
															value="4"
															{{ (old('turbidity') == 4) ? 'selected':'' }}
															>Very High
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #FDAD2A;">
															</span>&nbsp;&nbsp;High'
															value="3"
															{{ (old('turbidity') == 3) ? 'selected':'' }}
															>High
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #00A8FF;">
															</span>&nbsp;&nbsp;Low'
															value="2"
															{{ (old('turbidity') == 2) ? 'selected':'' }}
															>Low
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #46C35F;">
															</span>&nbsp;&nbsp;Perfect'
															value="1"
															{{ (old('turbidity') == 1) ? 'selected':'' }}
															>Perfect
									</option>
								</select>
								@if ($errors->has('turbidity'))
									<small class="text-muted">{{ $errors->first('turbidity') }}</small>
								@endif
							</div>
						</div>
						<div class="form-group row {{($errors->has('salt'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Salt</label>
							<div class="col-md-3 col-lg-3 col-xl-4">
								<select class="bootstrap-select bootstrap-select-arrow" name="salt">
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #000;">
															</span>&nbsp;&nbsp;Choose an option'
															value="0"
															{{ (old('salt') == 0) ? 'selected':'' }}
															>Choose an option
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #FA424A;">
															</span>&nbsp;&nbsp;Very High'
															value="5"
															{{ (old('salt') == 5) ? 'selected':'' }}
															>Very High
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #FDAD2A;">
															</span>&nbsp;&nbsp;High'
															value="5"
															{{ (old('salt') == 4) ? 'selected':'' }}
															>High
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #46C35F;">
															</span>&nbsp;&nbsp;Perfect'
															value="3"
															{{ (old('salt') == 3) ? 'selected':'' }}
															>Perfect
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #00A8FF;">
															</span>&nbsp;&nbsp;Low'
															value="2"
															{{ (old('salt') == 2) ? 'selected':'' }}
															>Low
									</option>
									<option data-content='<span class="glyphicon glyphicon-asterisk"
															style="color: #AC6BEC;">
															</span>&nbsp;&nbsp;Very Low'
															value="1"
															{{ (old('salt') == 1) ? 'selected':'' }}
															>Very Low
									</option>
								</select>
								@if ($errors->has('salt'))
									<small class="text-muted">{{ $errors->first('salt') }}</small>
								@endif
							</div>
						</div>
						<br>
						<div class="form-group row">
							<label class="col-sm-3 form-control-label">Photo 1 (Full Pool)</label>
							<div class="col-sm-9">
				                <div class="fileupload fileupload-new" data-provides="fileupload">
				                  <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
				                  <img src="{{ \Storage::url('images/assets/app/no_image.png') }}" alt="Placeholder" /></div>
				                  <div class="fileupload-preview fileupload-exists thumbnail"
				                   		style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
				                  @if ($errors->has('photo1'))
				                  	<br>
									<span class="label label-danger">{{ $errors->first('photo1') }}</span>
									<br><br>
								  @endif
				                  <div>
				                    <span class="btn btn-default btn-file">
				                    <span class="fileupload-new">Select image</span>
				                    <span class="fileupload-exists">Change</span>
				                    <input type="file" name="photo1" id="photo1" ></span>
				                    <a href="#" class="btn btn-default fileupload-exists"
				                    	data-dismiss="fileupload">Remove</a>
				                  </div>
				                </div>
			              	</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 form-control-label">Photo 2 (Water Quality)</label>
							<div class="col-sm-9">
				                <div class="fileupload fileupload-new" data-provides="fileupload">
				                  <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
				                  <img src="{{ \Storage::url('images/assets/app/no_image.png') }}" alt="Placeholder" /></div>
				                  <div class="fileupload-preview fileupload-exists thumbnail"
				                   		style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
				                  @if ($errors->has('photo2'))
				                  	<br>
									<span class="label label-danger">{{ $errors->first('photo2') }}</span>
									<br><br>
								  @endif
				                  <div>
				                    <span class="btn btn-default btn-file">
				                    <span class="fileupload-new">Select image</span>
				                    <span class="fileupload-exists">Change</span>
				                    <input type="file" name="photo2" id="photo2" ></span>
				                    <a href="#" class="btn btn-default fileupload-exists"
				                    	data-dismiss="fileupload">Remove</a>
				                  </div>
				                </div>
			              	</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 form-control-label">Photo 3 (Engine Room)</label>
							<div class="col-sm-9">
				                <div class="fileupload fileupload-new" data-provides="fileupload">
				                  <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
				                  <img src="{{ \Storage::url('images/assets/app/no_image.png') }}" alt="Placeholder" /></div>
				                  <div class="fileupload-preview fileupload-exists thumbnail"
				                   		style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
				                  @if ($errors->has('photo3'))
				                  	<br>
									<span class="label label-danger">{{ $errors->first('photo3') }}</span>
									<br><br>
								  @endif
				                  <div>
				                    <span class="btn btn-default btn-file">
				                    <span class="fileupload-new">Select image</span>
				                    <span class="fileupload-exists">Change</span>
				                    <input type="file" name="photo3" id="photo3" ></span>
				                    <a href="#" class="btn btn-default fileupload-exists"
				                    	data-dismiss="fileupload">Remove</a>
				                  </div>
				                </div>
			              	</div>
						</div>
						<hr>
						<p style="float: right;">
							<a  class="btn btn-warning"
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
