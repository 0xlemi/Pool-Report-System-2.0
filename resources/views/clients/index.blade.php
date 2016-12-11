@extends('layouts.app')

@section('content')
<header class="section-header">
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>All Clients</h3>
				<ol class="breadcrumb breadcrumb-simple">
					<li class="active">Clients</li>
				</ol>
			</div>
		</div>
	</div>
</header>
<div class="row">
	<div class="col-xl-12">
		<section class="box-typical">
			<client-table></client-table>
		</section><!--.box-typical-->
	</div>
</div><!--.row-->
@endsection
