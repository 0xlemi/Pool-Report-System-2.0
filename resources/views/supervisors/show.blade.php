@extends('layouts.app')

@inject('helper', 'App\PRS\Helpers\UserRoleCompanyHelpers')
@section('content')
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

						@if(!$supervisor->user->verified)
						<div class="form-group row">
							<email-verification-notice
								name="Supervisor"
								seq-id="{{ $supervisor->seq_id }}">
							</email-verification-noctice>
						</div>
						<br>
						@endif

						@if($image)
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Supervisor photo</label>
							<div class="col-sm-10">
								<div class="col-xl-3 col-lg-4 col-md-4 col-sm-5 m-b-md">
									<photo :image="{{ json_encode($image) }}" :can-delete="false"></photo>
								</div>
							</div>
						</div>
						@endif

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Status:</label>
							<div class="col-sm-10">
								{!! $helper->styleStatus($supervisor->paid) !!}
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">ID</label>
							<div class="col-sm-10">
								<input type="text" readonly class="form-control" value="{{ $supervisor->seq_id }}">
							</div>
						</div>

						<reference-real-values
							real-value="{{ $user->name }}"
							reference-value="{{ $supervisor->name_extra }}"
							name="name"
							:disabled="{{ $user->requestUserChanges->contains('name', 'name') }}"
							urc-id="{{ $supervisor->seq_id }}">
						</reference-real-values>

						<reference-real-values
							real-value="{{ $user->last_name }}"
							reference-value="{{ $supervisor->last_name_extra }}"
							name="last_name"
							:disabled="{{ $user->requestUserChanges->contains('name', 'last_name') }}"
							urc-id="{{ $supervisor->seq_id }}">
						</reference-real-values>

						<reference-real-values
							real-value="{{ $user->email }}"
							reference-value="{{ $supervisor->email_extra }}"
							name="email"
							text="Supervisor logs in and recives emails to this email."
							:disabled="{{ $user->requestUserChanges->contains('name', 'email') }}"
							urc-id="{{ $supervisor->seq_id }}">
						</reference-real-values>

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
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Language</label>
							<div class="col-sm-10">
								<input type="text" readonly class="form-control" value="{{ languageCode_to_text($user->language) }}">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Comments</label>
							<div class="col-sm-10">
								<textarea rows="4" class="form-control"
											placeholder="Any additional info about this supervisor."
											name="about" readonly>{{ $supervisor->about }}</textarea>
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
@endsection
