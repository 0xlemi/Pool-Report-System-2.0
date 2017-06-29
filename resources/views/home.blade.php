@extends('layouts.app')

@inject('helper', 'App\PRS\Helpers\UserHelpers')
@section('content')
<div class="container-fluid">
	<div class="box-typical box-typical-padding">
		<h2>Welcome back </h2>
        <h2><strong>{{ $user->fullName }}</strong></h2>
        <br>
        <h4><small class="text-muted">You are logged in as
            &nbsp;{{ $user->selectedUser->role->text }}
        </small></h4>
		<br>

		<h3 class="semibold">Reports</h3>
		<br>
		<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#reportModal">Services for the Month</button>
    </div>
</div>

<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" class="" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Service pending payments for the month</h4>
      </div>
      <div class="modal-body">
			<div class="row">
				hello
			</div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection
