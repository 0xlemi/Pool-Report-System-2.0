@extends('layouts.app')

@inject('workOrderHelpers', 'App\PRS\Helpers\WorkOrderHelpers')
@section('content')
<div class="workOrderVue">
	<header class="section-header">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>View Work Order</h3>
					<ol class="breadcrumb breadcrumb-simple">
						<li><a href="{{ url('workorders') }}">Work Orders</a></li>
						<li class="active">View Work Order {{ $workOrder->seq_id }}</li>
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

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Status:</label>
							<div class="col-sm-10">
								{!! $workOrderHelpers->styleFinishedStatus($workOrder->end()->finished()) !!}
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">ID</label>
							<div class="col-sm-10">
								<p class="form-control-static"><input type="text" readonly class="form-control" value="{{ $workOrder->seq_id }}"></p>
							</div>
						</div>

						<div class="form-group row {{($errors->has('title'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Title:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" readonly
										name="title" value="{{ $workOrder->title }}">
								@if ($errors->has('title'))
									<small class="text-muted">{{ $errors->first('title') }}</small>
								@endif
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Service Name</label>
							<div class="col-sm-10">
								<p class="form-control-static"><input type="text" readonly class="form-control" value="{{ $workOrder->service->name }}"></p>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Supervisor Name</label>
							<div class="col-sm-10">
								<p class="form-control-static"><input type="text" readonly class="form-control" value="{{ $workOrder->supervisor->name }}"></p>
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Price</label>
							<div class="col-sm-10">
								<input type="text" readonly class="form-control" value="{{ $workOrder->price.' '.$workOrder->currency }}">
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Started at</label>
							<div class="col-sm-10">
								<p class="form-control-static"><input type="text" readonly class="form-control" value="{{ $workOrderHelpers->format_date($workOrder->start) }}"></p>
							</div>
						</div>

						@if($workOrder->end()->finished())
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Finished at</label>
								<div class="col-sm-10">
									<p class="form-control-static"><input type="text" readonly class="form-control" value="{{ $workOrder->end()->long() }}"></p>
								</div>
							</div>
						@endif

						<works work-order-id="{{ $workOrder->seq_id }}" :technicians="{{ $technicians }}">
						</works>

						<work-order-photos-show work-order-id="{{ $workOrder->seq_id }}" finished="{{ $workOrder->end()->finished() }}">
						</work-order-photos-show>

						<div class="form-group row {{($errors->has('description'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Description:</label>
							<div class="col-sm-10">
								<textarea rows="5" class="form-control" readonly
											placeholder="Describe the work order to be done."
											name="description">{{ $workOrder->description }}</textarea>
								@if ($errors->has('description'))
									<small class="text-muted">{{ $errors->first('description') }}</small>
								@endif
							</div>
						</div>
						<hr>
        				@can('delete', $workOrder)
							<delete-button url="workorders/" object-id="{{ $workOrder->seq_id }}">
							</delete-button>
        				@endcan
						<span style="float: right;display:inline;">
    						@can('update', $workOrder)
								<a class="btn btn-primary"
										href="{{ url('/workorders/'.$workOrder->seq_id.'/edit') }}">
									<i class="font-icon font-icon-pencil"></i>
									&nbsp;&nbsp;Edit Work Order
								</a>
    						@endcan
    						@can('finish', $workOrder)
								<finish-work-order-button work-order-id="{{ $workOrder->seq_id }}">
								</finish-work-order-button>
    						@endcan
						</span>
						<br>
						<br>
					</div>
			</section>
		</div>
	</div>
</div>
@endsection
