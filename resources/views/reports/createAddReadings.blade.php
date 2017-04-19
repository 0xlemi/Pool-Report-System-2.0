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
					Report Add Readings:
				</header>
				<div class="card-block">
					<form method="POST" action="{{ url('reports') }}" enctype="multipart/form-data">
						{{ csrf_field() }}

						<input type="hidden" name="service" value="{{ $info->service }}">
						<input type="hidden" name="person" value="{{ $info->person }}">
						<input type="hidden" name="completed_at" value="{{ $info->completed_at }}">

						@foreach($chemicals as $chemical)
							<div class="form-group row {{($errors->has('readings.'.$chemical->id))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">{{ $chemical->name }}</label>
								<div class="col-md-3 col-lg-3 col-xl-4">
									<select class="bootstrap-select bootstrap-select-arrow" name="readings[{{ $chemical->id }}]">
										@foreach($chemical->labels as $label)
											<option data-content='
												<span class="fa fa-circle"
														style="color:#{{ $label->color }};">
												</span>
												&nbsp;&nbsp;{{ $label->name }}'
												value="{{ $label->value }}">
											</option>
										@endforeach
									</select>
									@if($errors->has('readings.'.$chemical->id))
										<small class="text-muted">{{ $errors->first('readings.'.$chemical->id) }}</small>
									@endif
								</div>
							</div>
						@endforeach

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
