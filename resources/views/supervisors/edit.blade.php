@extends('layouts.app')

@section('content')
	<header class="section-header">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>Edit Supervisor</h3>
					<ol class="breadcrumb breadcrumb-simple">
						<li><a href="{{ url('supervisors') }}">Supervisors</a></li>
						<li><a href="{{ url('supervisors/'.$supervisor->seq_id) }}">View Supervisor {{ $supervisor->seq_id }}</a></li>
						<li class="active">Edit Supervisor</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xl-8 col-xl-offset-2">
			<section class="card">
					<header class="card-header card-header-lg">
						Supervisor info:
					</header>
					<div class="card-block">
						<form method="POST" action="{{ url('supervisors/'.$supervisor->seq_id) }}" enctype="multipart/form-data">
							{{ csrf_field() }}
							{{ method_field('PATCH') }}
							<input type="hidden" name="seq_id" value="{{ $supervisor->seq_id }}">

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Photo:</label>
								<div class="col-sm-10">
					                <div class="fileupload fileupload-new" data-provides="fileupload">
					                  <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
					                  <img src="{{ \Storage::url($supervisor->thumbnail()) }}" alt="Placeholder" /></div>
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
											name="cellphone" maxlength="50" value="{{ $supervisor->cellphone }}">
									@if ($errors->has('cellphone'))
										<small class="text-muted">{{ $errors->first('cellphone') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('address'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Address Line:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="address" maxlength="100" value="{{ $supervisor->address }}">
									@if ($errors->has('address'))
										<small class="text-muted">{{ $errors->first('address') }}</small>
									@endif
								</div>
							</div>

							<!-- <div class="form-group row">
								<label class="col-sm-2 form-control-label">Status:</label>
								<div class="col-sm-10">
								<input type="checkbox" data-toggle="toggle"
										data-on="Active" data-off="Not Active"
										data-onstyle="success" data-offstyle="danger"
										data-size="small" name="paid" {{ ($supervisor->paid) ? 'checked':'' }}>
								<small class="text-muted">You are only charged for active supervisors.</small>
								</div>
							</div> -->

							<div class="form-group row {{($errors->has('about'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">About Supervisor:</label>
								<div class="col-sm-10">
									<textarea rows="5" class="form-control"
												placeholder="Any additional info about this supervisor."
												name="about">{{ $supervisor->about }}</textarea>
									@if ($errors->has('about'))
										<small class="text-muted">{{ $errors->first('about') }}</small>
									@endif
								</div>
							</div>

							<hr>
							<span style="float:right;">
								<a  class="btn btn-warning"
								href="{{ url('supervisors/'.$supervisor->seq_id) }}">
								<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back</a>
								<button  class="btn btn-success"
								type='submit'>
								<i class="font-icon font-icon-ok"></i>&nbsp;&nbsp;&nbsp;Edit Supervisor</button>
							</span>
							<br>
							<br>
						</form>
					</div>
			</section>
		</div>
	</div>
@endsection
