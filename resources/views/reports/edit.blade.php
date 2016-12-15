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
							<label class="col-sm-2 form-control-label">Service</label>
							<div class="col-sm-10">
								<dropdown :key="{{ $report->service()->seq_id }}"
											:options="{{ json_encode($services) }}"
											:name="'service'">
								</dropdown>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Technician</label>
							<div class="col-sm-10">
								<dropdown :key="{{ $report->technician()->seq_id }}"
											:options="{{ json_encode($technicians) }}"
											:name="'technician'">
								</dropdown>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">PH</label>
							<div class="col-md-3 col-lg-3 col-xl-4">
								<select class="bootstrap-select bootstrap-select-arrow" name="ph">
									@foreach($tags->ph()->asArrayWithColor() as $key => $tag)
									<option data-content='
										<span class="glyphicon glyphicon-asterisk"
												style="color: {{$tag->color}};">
										</span>
										&nbsp;&nbsp;{{$tag->text}}'
										value="{{$key}}"
										{{ ($report->ph == $key) ? 'selected':''}}>
									</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Chlorine</label>
							<div class="col-md-3 col-lg-3 col-xl-4">
								<select class="bootstrap-select bootstrap-select-arrow" name="chlorine">
									@foreach($tags->chlorine()->asArrayWithColor() as $key => $tag)
									<option data-content='
										<span class="glyphicon glyphicon-asterisk"
												style="color: {{$tag->color}};">
										</span>
										&nbsp;&nbsp;{{$tag->text}}'
										value="{{$key}}"
										{{ ($report->chlorine == $key) ? 'selected':''}}>
									</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Temperature</label>
							<div class="col-md-3 col-lg-3 col-xl-4">
								<select class="bootstrap-select bootstrap-select-arrow" name="temperature">
									@foreach($tags->temperature()->asArrayWithColor() as $key => $tag)
									<option data-content='
										<span class="glyphicon glyphicon-asterisk"
												style="color: {{$tag->color}};">
										</span>
										&nbsp;&nbsp;{{$tag->text}}'
										value="{{$key}}"
										{{ ($report->temperature == $key) ? 'selected':''}}>
									</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Turbidity</label>
							<div class="col-md-3 col-lg-3 col-xl-4">
								<select class="bootstrap-select bootstrap-select-arrow" name="turbidity">
									@foreach($tags->turbidity()->asArrayWithColor() as $key => $tag)
									<option data-content='
										<span class="glyphicon glyphicon-asterisk"
												style="color: {{$tag->color}};">
										</span>
										&nbsp;&nbsp;{{$tag->text}}'
										value="{{$key}}"
										{{ ($report->turbidity == $key) ? 'selected':''}}>
									</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Salt</label>
							<div class="col-md-3 col-lg-3 col-xl-4">
								<select class="bootstrap-select bootstrap-select-arrow" name="salt">
									@foreach($tags->salt()->asArrayWithColor() as $key => $tag)
									<option data-content='
										<span class="glyphicon glyphicon-asterisk"
												style="color: {{$tag->color}};">
										</span>
										&nbsp;&nbsp;{{$tag->text}}'
										value="{{$key}}"
										{{ ($report->salt == $key) ? 'selected':''}}>
									</option>
									@endforeach
								</select>
							</div>
						</div>

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
