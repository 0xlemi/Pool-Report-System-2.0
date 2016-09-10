@extends('layouts.app')

@section('content')
<div class="workOrderVue">
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
						<form method="POST" action="{{ url('reports') }}" enctype="multipart/form-data">
							{{ csrf_field() }}

							<div class="form-group row {{($errors->has('service'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Service</label>
								<div class="col-sm-10">
									<dropdown :key.sync="dropdownKey"
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
									<dropdown :key.sync="dropdownKey"
												:options="{{ $supervisor }}"
												:name="'supervisor'">
									</dropdown>
									@if ($errors->has('supervisor'))
										<small class="text-muted">{{ $errors->first('supervisor') }}</small>
									@endif
								</div>
							</div>

                            <div class="form-group row {{($errors->has('start'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Started at:</label>
								<div class="col-sm-10">
									<div class='input-group date' id="new_report_datepicker">
										<input type='text' name='start' class="form-control"
												id="new_report_datepicker_input"
												value="{{ old('start') }}"/>
										@if ($errors->has('start'))
											<small class="text-muted">{{ $errors->first('start') }}</small>
										@endif
										<span class="input-group-addon">
											<i class="font-icon font-icon-calend"></i>
										</span>
									</div>
								</div>
							</div>

                            <div class="form-group row {{($errors->has('end'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Ended at:</label>
								<div class="col-sm-10">
									<div class='input-group date' id="new_report_datepicker">
										<input type='text' name='end' class="form-control"
												id="new_report_datepicker_input"
												value="{{ old('end') }}"/>
										@if ($errors->has('end'))
											<small class="text-muted">{{ $errors->first('end') }}</small>
										@endif
										<span class="input-group-addon">
											<i class="font-icon font-icon-calend"></i>
										</span>
									</div>
								</div>
							</div>



							<br>
							<div class="form-group row">
								<label class="col-sm-3 form-control-label">Photo 1 (Full Pool)</label>
								<div class="col-sm-9">
					                <div class="fileupload fileupload-new" data-provides="fileupload">
					                  <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
					                  <img src="{{ url('img/no_image.png') }}" alt="Placeholder" /></div>
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
					                  <img src="{{ url('img/no_image.png') }}" alt="Placeholder" /></div>
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
					                  <img src="{{ url('img/no_image.png') }}" alt="Placeholder" /></div>
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
</div>
@endsection
