@extends('layouts.app')

@inject('helper', 'App\PRS\Helpers\SupervisorHelpers')
@section('content')
<div class="supervisorVue">
	<header class="section-header">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>View Supervisor</h3>
					<ol class="breadcrumb breadcrumb-simple">
						<li><a href="{{ url('supervisors') }}">Supervisor</a></li>
						<li class="active">View Supervisor {{ $supervisor->seq_id }}</li>
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
						<form>
							@if($supervisor->numImages() > 0)
								<div class="form-group row">
									<label class="col-sm-2 form-control-label">Photo</label>
									<div class="col-sm-10">
										<div class="col-xl-3 col-lg-4 col-md-4 col-sm-5 m-b-md">
			                                <div class="gallery-col">
												<article class="gallery-item">
													<img class="gallery-picture" src="{{ url($supervisor->thumbnail()) }}" alt="" height="158">
													<div class="gallery-hover-layout">
														<div class="gallery-hover-layout-in">
															<p class="gallery-item-title">Supervisor Photo</p>
															<div class="btn-group">
																<a class="fancybox btn" href="{{ url($supervisor->image()) }}" title="Supervisor Photo">
																	<i class="font-icon font-icon-eye"></i>
																</a>
															</div>
														</div>
													</div>
												</article>
											</div><!--.gallery-col-->
			                            </div><!--.col-->
									</div>
								</div>
							@endif

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Status:</label>
								<div class="col-sm-10">
									{!! $helper->styleStatus($supervisor->user()->active) !!}
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">ID</label>
								<div class="col-sm-10">
									<input type="text" readonly class="form-control" value="{{ $supervisor->seq_id }}">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Name</label>
								<div class="col-sm-10">
									<input type="text" readonly class="form-control" value="{{ $supervisor->name }}">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Last Name</label>
								<div class="col-sm-10">
									<input type="text" readonly class="form-control" value="{{ $supervisor->last_name }}">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Email</label>
								<div class="col-sm-10">
									<input type="text" readonly class="form-control" value="{{ $supervisor->user()->email }}">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Mobile Phone</label>
								<div class="col-sm-10">
									<input type="text" readonly class="form-control" value="{{ $supervisor->cellphone }}">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Address Line</label>
								<div class="col-sm-10">
									<input type="text" readonly class="form-control" value="{{ $supervisor->address }}">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Receives email</label>
								<div class="col-sm-10">
									{!! $helper->styleEmailPermissions($supervisor) !!}
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Language</label>
								<div class="col-sm-10">
									<input type="text" readonly class="form-control" value="{{ languageCode_to_text($supervisor->language) }}">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Comments</label>
								<div class="col-sm-10">
									<textarea rows="4" class="form-control"
												placeholder="Any additional info about this supervisor."
												name="comments" readonly>{{ $supervisor->comments }}</textarea>
								</div>
							</div>
						</form>
						<hr>
						<span style="float: right;">
        					@can('delete', $supervisor)
								<delete-button url="supervisors/" object-id="{{ $supervisor->seq_id }}">
								</delete-button>
        					@endcan
        					@can('update', $supervisor)
								&nbsp;&nbsp;&nbsp;&nbsp;
								<a  class="btn btn-primary"
								href="{{ url('/supervisors/'.$supervisor->seq_id.'/edit') }}">
								<i class="font-icon font-icon-pencil"></i>&nbsp;&nbsp;Edit Supervisor</a>
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
