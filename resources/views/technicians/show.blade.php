@extends('layouts.app')

@inject('helper', 'App\PRS\Helpers\UserRoleCompanyHelpers')
@section('content')
<div class="technicianVue">
	<header class="section-header">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>View Technician</h3>
					<ol class="breadcrumb breadcrumb-simple">
						<li><a href="{{ url('technicians') }}">Technician</a></li>
						<li class="active">View Technician {{ $technician->seq_id }}</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xl-8 col-xl-offset-2">
			<section class="card">
					<header class="card-header card-header-lg">
						Technician info:
					</header>
					<div class="card-block">
						<form>

							@if(!$technician->user->verified)
							<div class="form-group row">
								<email-verification-notice
									name="Technician"
									seq-id="{{ $technician->seq_id }}">
								</email-verification-noctice>
							</div>
							<br>
							@endif

							@if($image)
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Technician photo</label>
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
									{!! $helper->styleStatus($technician->paid) !!}
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">ID</label>
								<div class="col-sm-10">
									<input type="text" readonly class="form-control" value="{{ $technician->seq_id }}">
								</div>
							</div>

							<reference-real-values
								real-value="{{ $user->name }}"
								reference-value="{{ $technician->name_extra }}"
								name="name"
								:disabled="{{ $user->requestUserChanges->contains('name', 'name') }}"
								urc-id="{{ $technician->seq_id }}">
							</reference-real-values>

							<reference-real-values
								real-value="{{ $user->last_name }}"
								reference-value="{{ $technician->last_name_extra }}"
								name="last_name"
								:disabled="{{ $user->requestUserChanges->contains('name', 'last_name') }}"
								urc-id="{{ $technician->seq_id }}">
							</reference-real-values>

							<reference-real-values
								real-value="{{ $user->email }}"
								reference-value="{{ $technician->email_extra }}"
								name="email"
								text="Technician logs in and recives emails to this email."
								:disabled="{{ $user->requestUserChanges->contains('name', 'email') }}"
								urc-id="{{ $technician->seq_id }}">
							</reference-real-values>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Password</label>
									<change-technician-password
										id="{{ $technician->seq_id }}">
									</change-technician-password>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Mobile Phone</label>
								<div class="col-sm-10">
									<input type="text" readonly class="form-control" value="{{ $technician->cellphone }}">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Address Line</label>
								<div class="col-sm-10">
									<input type="text" readonly class="form-control" value="{{ $technician->address }}">
								</div>
							</div>


							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Language</label>
								<div class="col-sm-10">
									<input type="text" readonly class="form-control" value="{{ languageCode_to_text($user->language) }}">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">About Techinician</label>
								<div class="col-sm-10">
									<textarea rows="4" class="form-control"
												placeholder="Any additional info about this technician."
												readonly>{{ $technician->about }}</textarea>
								</div>
							</div>
						</form>
						<hr>
						<span style="float: right;">
        					@can('delete', $technician)
								<delete-button url="technicians/" object-id="{{ $technician->seq_id }}">
								</delete-button>
        					@endcan
        					@can('update', $technician)
								&nbsp;&nbsp;&nbsp;&nbsp;
								<a  class="btn btn-primary"
								href="{{ url('/technicians/'.$technician->seq_id.'/edit') }}">
								<i class="font-icon font-icon-pencil"></i>&nbsp;&nbsp;Edit Technician</a>
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
