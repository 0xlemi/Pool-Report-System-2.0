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
	<div class="col-xxl-2 col-xl-3 col-lg-4 col-md-12">
		<section class='box-typical'>
			<section class="calendar-page-side-section">
				<div class="calendar-page-side-section-in">
					<div class="datepicker-inline" id="side-datetimepicker"></div>
				</div>
			</section>
		</section>
	</div>
	<div class="col-xxl-10 col-xl-9 col-lg-8 col-md-12">
        <client-reports-group
            :reports="{{ json_encode($reports) }}"
        ></client-reports-group>
	</div>
</div><!--.row-->
@endsection
