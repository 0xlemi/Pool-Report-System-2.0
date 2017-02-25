@extends('layouts.app')

@section('content')
<header class="section-header">
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>Reports</h3>
			</div>
		</div>
	</div>
</header>
<div class="row">
	<client-reports
    	today="{{ $today }}">
	</client-reports>
</div><!--.row-->
@endsection
