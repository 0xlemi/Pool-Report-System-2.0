@if(session()->has('error') || session()->has('info'))
<div class="row">
    <div class="col-md-4 col-md-offset-4 m-t-md">
        @if(session()->has('error'))
        <div class="alert alert-danger alert-border-left alert-close alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
			{!! session()->get('error') !!}
		</div>
        @endif
        @if(session()->has('info'))
        <div class="alert alert-info alert-border-left alert-close alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
			{!! session()->get('info') !!}
		</div>
        @endif
    </div>
</div>
@endif
@if (session('status'))
<div class="row">
    <div class="col-md-4 col-md-offset-4 m-t-md">
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    </div>
</div>
@endif
