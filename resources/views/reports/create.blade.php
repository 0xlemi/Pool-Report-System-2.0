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
					<form method="POST" action="{{ url('reports/readings') }}">
						{{ csrf_field() }}

						@if ($errors->has('*'))
							<div class="alert alert-warning alert-fill alert-close alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
								<i class="font-icon font-icon-inline font-icon-warning"></i>
								<strong>Ups, you missed something.</strong><br>
								{{$errors->first('*')}}
							</div>
							<br>
						@endif

        				@role('admin')
						<div class="form-group row {{($errors->has('completed_at'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">completed at:</label>
							<div class="col-sm-10">
								<div class='input-group date' id="genericDatepicker">
									<input type='text' name='completed_at' class="form-control"
											id="genericDatepickerInput"
											value="{{ old('completed_at') }}"/>
									@if ($errors->has('completed_at'))
										<small class="text-muted">{{ $errors->first('completed_at') }}</small>
									@endif
									<span class="input-group-addon">
										<i class="font-icon font-icon-calend"></i>
									</span>
								</div>
							</div>
						</div>

						<div class="form-group row {{($errors->has('person'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Person</label>
							<div class="col-sm-10">
								<dropdown :key="{{ old('person') }}"
											:options="{{ $people }}"
											:name="'person'">
								</dropdown>
								@if ($errors->has('person'))
									<small class="text-muted">{{ $errors->first('person') }}</small>
								@endif
							</div>
						</div>
        				@endrole

						<div class="form-group row {{($errors->has('service'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Service</label>
							<div class="col-sm-10">
								<dropdown :key="{{ old('service') }}"
											:options="{{ $services }}"
											:name="'service'">
								</dropdown>
								@if ($errors->has('service'))
									<small class="text-muted">{{ $errors->first('service') }}</small>
								@endif
							</div>
						</div>

						<br>
						<p style="float: right;">
							<a  class="btn btn-warning"
							href="{{ url('reports') }}">
							<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back</a>
							<button  class="btn btn-primary" type='submit'>
							Next&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-arrow-right"></i></button>
						</p>
						<br>
						<br>
					</form>
				</div>
		</section>
	</div>
</div>
@endsection
