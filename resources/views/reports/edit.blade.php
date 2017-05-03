@extends('layouts.app')

@section('content')
<header class="section-header">
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>Edit Report</h3>
				<ol class="breadcrumb breadcrumb-simple">
					<li><a href="{{ url('reports') }}">Reports</a></li>
					<li><a href="{{ url('reports/'.$report->seq_id) }}">View Report {{ $report->seq_id }}</a></li>
					<li class="active">Edit Report {{ $report->seq_id }}</li>
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
					<form method="POST" action="{{ url('reports/'.$report->seq_id) }}">
						{{ csrf_field() }}
						{{ method_field('PATCH') }}

						<input type="hidden" name="service" value="{{ $report->service->seq_id }}">

						<div class="form-group row {{($errors->has('completed_at'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Compleated at:</label>
							<div class="col-sm-10">
								<div class='input-group date' id="editGenericDatepicker">
									<input type='text' name='completed_at' class="form-control" id="editGenericDatepickerInput"/>
									@if($errors->has('completed_at'))
										<small class="text-muted">{{ $errors->first('completed_at') }}</small>
									@endif
									<span class="input-group-addon">
										<i class="font-icon font-icon-calend"></i>
									</span>
								</div>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Person</label>
							<div class="col-sm-10">
								<dropdown :key="{{ $report->userRoleCompany->seq_id }}"
											:options="{{ json_encode($people) }}"
											:name="'person'">
								</dropdown>
							</div>
						</div>


						@foreach($measurements as $measurement)
							<div class="form-group row {{($errors->has('readings.'.$measurement->id))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">{{ $measurement->name }}</label>
								<div class="col-md-3 col-lg-3 col-xl-4">
									<select class="bootstrap-select bootstrap-select-arrow" name="readings[{{ $measurement->id }}]">
										@foreach($measurement->labels as $label)
											<option data-content='
												<span class="fa fa-circle"
														style="color:#{{ $label->color }};">
												</span>
												&nbsp;&nbsp;{{ $label->name }}'
												value="{{ $label->value }}"
												{{ ((isset($readings[$measurement->id])) && ($readings[$measurement->id] == $label->value)) ? 'selected':''}}>
											</option>
										@endforeach
									</select>
									@if($errors->has('readings.'.$measurement->id))
										<small class="text-muted">{{ $errors->first('readings.'.$measurement->id) }}</small>
									@endif
								</div>
							</div>
						@endforeach

						<br>
						<br>
						<p style="float: right;">
							<a  class="btn btn-warning"
							href="{{ url('/reports/'.$report->seq_id) }}">
							<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back</a>
							<button  class="btn btn-success"
							type='submit'>
							<i class="font-icon font-icon-ok"></i>&nbsp;&nbsp;&nbsp;Save Changes</button>
						</p>
					</form>
					<br>
					<br>
					<hr>
					<edit-report-photos :id="{{ $report->seq_id }}"></edit-report-photos>
				</div>
		</section>
	</div>
</div>
@endsection
