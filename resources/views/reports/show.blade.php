@extends('layouts.app')

@section('content')
<header class="section-header">
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>View Report</h3>
				<ol class="breadcrumb breadcrumb-simple">
					<li><a href="{{ url('reports') }}">Reports</a></li>
					<li class="active">View Report {{ $report->seq_id }}</li>
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
					<form>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">ID</label>
							<div class="col-sm-10">
								<p class="form-control-static"><input type="text" readonly class="form-control" id="inputPassword" value="{{ $report->seq_id }}"></p>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Compleated at:</label>
							<div class="col-sm-10">
								<p class="form-control-static"><input type="text" readonly class="form-control" id="inputPassword" value="{{ $report->completed()->format('d M Y h:i:s A') }}"></p>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Was made on time?</label>
							<div class="col-sm-10">
								<p class="form-control-static">{!! $report->onTime()->styled() !!}</p>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Service Name</label>
							<div class="col-sm-10">
								<p class="form-control-static"><input type="text" readonly class="form-control" id="inputPassword" value="{{ $report->service->name }}"></p>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Technician Name</label>
							<div class="col-sm-10">
								<p class="form-control-static"><input type="text" readonly class="form-control" id="inputPassword" value="{{ $report->technician->name }}"></p>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">PH</label>
							<div class="col-sm-10">
								<p class="form-control-static">{!! $report->ph()->styled() !!}</p>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Chlorine</label>
							<div class="col-sm-10">
								<p class="form-control-static">{!! $report->chlorine()->styled() !!}</p>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Temperature</label>
							<div class="col-sm-10">
								<p class="form-control-static">{!! $report->temperature()->styled() !!}</p>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Turbidity</label>
							<div class="col-sm-10">
								<p class="form-control-static">{!! $report->turbidity()->styled() !!}</p>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Salt</label>
							<div class="col-sm-10">
								<p class="form-control-static">{!! $report->salt()->styled() !!}</p>
							</div>
						</div>
					</form>
					<br>
					<h4>Pool Photos</h4>
					<hr>
					<div class="row">
						<div class="col-md-12">
                            <photo-list :data="{{ json_encode($images) }}" :can-delete="false" list-class="col-xxl-3 col-xl-4 col-lg-4 col-md-4 col-sm-5 m-b-md">
							</photo-list>
						</div>
					</div>
					<hr>
					<span style="float: left;display:inline;">
						<button  class="btn btn-info"
						 data-toggle="modal" @click="previewEmailReport({{ $report->seq_id }})" >
						<i class="font-icon font-icon-mail"></i>&nbsp;&nbsp;Preview email</button>
						&nbsp;&nbsp;&nbsp;&nbsp;
					</span>
					<span style="float: right;display:inline;">
    					@can('delete', $report)
							<delete-button url="reports/" object-id="{{ $report->seq_id }}">
							</delete-button>
    					@endcan
    					@can('update', $report)
							&nbsp;&nbsp;&nbsp;&nbsp;
							<a  class="btn btn-primary"
							href="{{ url('/reports/'.$report->seq_id.'/edit') }}">
							<i class="font-icon font-icon-pencil"></i>&nbsp;&nbsp;Edit Report</a>
						@endcan
					</span>
					<br>
					<br>
				</div>
		</section>
	</div>
</div>
<!-- Modal for email preview -->
<div class="modal fade" id="emailPreview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Preview email</h4>
      </div>
      <div class="modal-body">
			<div class="row">
				<div class="col-md-12">
        			<img style="width:100%;" v-bind:src="reportEmailPreview" alt="Preview of the email for this report" />
				</div>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection
