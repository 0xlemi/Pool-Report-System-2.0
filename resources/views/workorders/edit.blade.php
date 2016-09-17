@extends('layouts.app')

@section('content')
	<header class="section-header">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>Edit Work Order</h3>
					<ol class="breadcrumb breadcrumb-simple">
						<li><a href="{{ url('workorders') }}">Work Orders</a></li>
						<li><a href="{{ url('workorders/'.$workOrder->seq_id) }}">View Work Order {{ $workOrder->seq_id }}</a></li>
						<li class="active">Edit Work Order</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xl-8 col-xl-offset-2">
			<section class="card">
					<header class="card-header card-header-lg">
						Work Order info:
					</header>
					<div class="card-block">
						<form method="POST" action="{{ url('workorders/'.$workOrder->seq_id) }}" enctype="multipart/form-data">
							{{ csrf_field() }}
							{{ method_field('PATCH') }}
							<input type="hidden" name="seq_id" value="{{ $workOrder->seq_id }}">

							<div class="form-group row {{($errors->has('name'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Name:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="name" maxlength="25" value="{{ $supervisor->name }}">
									@if ($errors->has('name'))
										<small class="text-muted">{{ $errors->first('name') }}</small>
									@endif
								</div>
							</div>

							<div class="form-group row {{($errors->has('last_name'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Last name:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control maxlength-simple"
											name="last_name" maxlength="40" value="{{ $supervisor->last_name }}">
									@if ($errors->has('last_name'))
										<small class="text-muted">{{ $errors->first('last_name') }}</small>
									@endif
								</div>
							</div>


							<div class="form-group row {{($errors->has('comments'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Comments:</label>
								<div class="col-sm-10">
									<textarea rows="5" class="form-control"
												placeholder="Any additional info about this supervisor."
												name="comments">{{ $supervisor->comments }}</textarea>
									@if ($errors->has('comments'))
										<small class="text-muted">{{ $errors->first('comments') }}</small>
									@endif
								</div>
							</div>

							<hr>
							<p style="float: left;">
								<a  class="btn btn-danger"
								href="{{ url('supervisors/'.$supervisor->seq_id) }}">
								<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back</a>
								<button  class="btn btn-success"
								type='submit'>
								<i class="font-icon font-icon-ok"></i>&nbsp;&nbsp;&nbsp;Edit Supervisor</button>
							</p>
							<br>
							<br>
						</form>
					</div>
			</section>
		</div>
	</div>
@endsection
