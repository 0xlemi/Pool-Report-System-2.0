@extends('layouts.app')

@inject('carbon', 'Carbon\Carbon')
@section('content')
	<header class="section-header">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>View Notifications</h3>
					<ol class="breadcrumb breadcrumb-simple">
						<li>Notifications</a></li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xl-8 col-xl-offset-2">
            <section class="box-typical">
                <table id="table-edit" class="table table-bordered table-hover">
    				<thead>
    				<tr>
    					<th>Description</th>
    					<th width="150">When</th>
                        <th width="90">Link</th>
    				</tr>
    				</thead>
    				<tbody>
                        @foreach($notifications as $notification)
    					<tr>
    						<td class="color-blue-grey-lighter">{{ $notification->data['message'] }}</td>
    						<td class="table-date">{{ $carbon::parse($notification->created_at)->diffForHumans() }}</td>
    						<td class="table-date">
                                @if($notification->data['link'])
                                <a href="{{ url($notification->data['link']) }}">Click Here</a>
                                @else
                                    <span class="label label-pill label-default">No link</span>
                                @endif
                            </td>
    					</tr>
                        @endforeach
    				</tbody>
    			</table>
                {{ $notifications->links() }}
            </section>
		</div>
	</div>
@endsection
