@extends('layouts.app')

@inject('helper', 'App\PRS\Helpers\ServiceHelpers')
@section('content')
<div class="serviceVue">
	<header class="section-header">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>Today's Route</h3>
					<ol class="breadcrumb breadcrumb-simple">
						<li class="active">Services Missing</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="col-xl-12">
			<section class="box-typical">
				<route-table url="{{ $defaultTableUrl }}" click-url="{{ $clickUrl }}" ></route-table>
			</section><!--.box-typical-->
		</div>
	</div><!--.row-->
</div>
@endsection
