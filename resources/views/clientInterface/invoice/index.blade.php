@extends('layouts.app')

@section('content')
<header class="section-header">
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>Invoices</h3>
			</div>
		</div>
	</div>
</header>
<div class="row">
    <div class="col-xl-12">
		<section class="box-typical">
            <invoice-client-table></invoice-client-table>    
        </section>
    </div>
</div><!--.row-->
@endsection
