@extends('layouts.app')

@section('content')
<div class="container-fluid messenger">
	<div class="box-typical chat-container">
		<chat :sb="sb" :current-user="currentUser" sound-url="{{ $soundUrl }}"></chat>
	</div><!--.chat-container-->
</div><!--.chat-messenger-->
@endsection
