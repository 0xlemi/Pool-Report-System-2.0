<div class="row">

<br>

    @if($admin->subscribed('main'))
    	<div class="col-md-12">
            <h4 class="semibold">Payment method</h4>
            <button type="button" class="btn btn-primary" data-toggle="modal"
    			data-target="#creditCardModal">
    			<i class="glyphicon glyphicon-credit-card"></i>&nbsp;&nbsp;&nbsp;
    			{{ ($admin->card_last_four) ? 'Update Credit Card' : 'Add Credit Card' }}
    		</button>
            <hr>
    	</div>
    @endif

    <div class="col-md-12">
        <h4 class="semibold">Subscription</h4>
        @if($admin->subscribedToPlan('pro', 'main'))
            <p>
                Your account is on a <strong>Pro</strong>
                subscription for {{ $admin->billableObjects() }} users
            </p>
            <br>
            <button type="button" class="btn btn-danger" @click="downgradeSubscription">
        		<i class="glyphicon glyphicon-arrow-down"></i>&nbsp;&nbsp;&nbsp;
        	    Downgrade to Free
        	</button>
            <small class="text-muted">
                Downgrading will not delete any data,
                but your supervisors and technicians<br>
                are going to be set to inactive.
            </small>
        @else
            <p>
                Your account is on a <strong>free</strong> subscription.<br>
                Using {{ $admin->objectActiveCount() }} out of your {{ $admin->free_objects }} free users.
            </p>
            <br>
            @if($admin->subscribedToPlan('free', 'main'))
                <button type="button" class="btn btn-success" @click="upgradeSubscription">
            		<i class="glyphicon glyphicon-arrow-up"></i>&nbsp;&nbsp;&nbsp;
            	    Upgrade to Pro
            	</button>
            @else
                <button type="button" class="btn btn-success" data-toggle="modal"
			            data-target="#creditCardModal">
            		<i class="glyphicon glyphicon-arrow-up"></i>&nbsp;&nbsp;&nbsp;
            	    Upgrade to Pro
            	</button>
            @endif
            <small class="text-muted">
                You are not going to be changed if you dont go passed your {{ $admin->free_objects }} free users.
            </small>
        @endif
        <hr>
    </div>


</div>
@include('settings._creditCardModal')
