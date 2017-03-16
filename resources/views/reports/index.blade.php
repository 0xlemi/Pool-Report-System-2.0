@extends('layouts.app')

@section('content')
<header class="section-header">
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>All Reports</h3>
				<ol class="breadcrumb breadcrumb-simple">
					<li class="active">Reports</li>
				</ol>
			</div>
		</div>
	</div>
</header>
<div class="row">
	<report-index>
	</report-index>	
</div><!--.row-->
@endsection
