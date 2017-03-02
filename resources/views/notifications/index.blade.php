@extends('layouts.app')

@inject('carbon', 'Carbon\Carbon')
@section('content')
<header class="section-header">
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>View Notifications</h3>
				<ol class="breadcrumb breadcrumb-simple">
					<li>Notifications</li>
				</ol>
			</div>
		</div>
	</div>
</header>
<div class="row">
	<div class="col-md-12 col-lg-12 col-xl-8 col-xl-offset-2">
        <section class="box-typical">
			<div class="box-typical-body">
				@if(!$notifications->isEmpty())
	                <table id="table-edit" class="table table-bordered table-hover">
	    				<thead>
	    				<tr>
	    					<th>Description</th>
	    					<th width="150">When</th>
							<th class="table-icon-cell">
								<i class="fa fa-photo"></i>
							</th>
	    				</tr>
	    				</thead>
	    				<tbody>
	                        @foreach($notifications as $notification)
	    					<tr>
	    						<td class="color-blue-grey-lighter">
									@if($notification->read_at === null)
									<i class="fa fa-circle" style="color: #FA424A;"></i>
									&nbsp;&nbsp;
									@endif
									{!! $notification->data['message'] !!}
								</td>
	    						<td class="table-date">{{ $carbon::parse($notification->created_at)->diffForHumans() }}</td>
								<td class="table-photo">
									<img src="{{ $notification->data['icon'] }}" alt="" data-toggle="tooltip" data-placement="bottom" title="Photo">
								</td>
	    					</tr>
	                        @endforeach
	    				</tbody>
	    			</table>
	            	<div class="col-md-12">
						<nav>
							{{ $notifications->links() }}
							<all-notifications-as-read-button></all-notifications-as-read-button>
						</nav>
					</div>
				@else
					<br>
            		<h4 style="text-align: center;padding: 60px 0;">There are no notifications yet.</h4>
				@endif
        	</div><!--.box-typical-body-->
		</section><!--.box-typical-->
	</div>
</div>
@endsection
