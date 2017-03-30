@extends('layouts.app')

@inject('helper', 'App\PRS\Helpers\UserHelpers')
@section('content')
<div class="container-fluid">
	<div class="box-typical box-typical-padding">
		<h2>Welcome back </h2>
        <h2><strong>{{ $user->fullName }}</strong></h2>
        <br>
        <h4><small class="text-muted">You are logged in as
            &nbsp;{!! $helper->styledType($user->userable_type) !!}
        </small></h4>
    </div>
</div>
@endsection
