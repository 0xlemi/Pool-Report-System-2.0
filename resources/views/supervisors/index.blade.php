@extends('layouts.app')

@section('content')
<div class="supervisorVue">
	<header class="section-header">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>All Supervisors</h3>
					<ol class="breadcrumb breadcrumb-simple">
						<li class="active">Supervisors</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="col-xl-12">
			<section class="box-typical">
				<supervisor-table></supervisor-table>	
			</section><!--.box-typical-->
		</div>
	</div><!--.row-->
</div>
@endsection
