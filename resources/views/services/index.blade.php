@extends('layouts.app')

@inject('helper', 'App\PRS\Helpers\ServiceHelpers')
@section('content')
<div class="serviceVue">
	<header class="section-header">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>All Services</h3>
					<ol class="breadcrumb breadcrumb-simple">
						<li class="active">Services</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="col-xl-12">
			<section class="box-typical">
				<service-table></service-table>
			</section><!--.box-typical-->
		</div>
	</div><!--.row-->
</div>
@endsection
