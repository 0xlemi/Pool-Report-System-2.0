<template>
	<div class="col-md-12" v-if="subscribed">
        <h4 class="semibold">Payment method</h4>
        <button type="button" class="btn btn-primary" data-toggle="modal"
			data-target="#creditCardModal">
			<i class="glyphicon glyphicon-credit-card"></i>&nbsp;&nbsp;&nbsp;
			Update Credit Card
		</button>
        <hr>
	</div>

    <div class="col-md-12">
        <h4 class="semibold">Subscription</h4>
        <div v-if="plan == 'pro'">
            <p>
                Your account is on a <strong>Pro</strong>
                subscription for {{ billableObjects }} users
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
        </div>

        <!-- Is unsubscribed or in a free subscription -->
        <div v-else>
            <p>
                Your account is on a <strong>free</strong> subscription.<br>
                Using {{ activeObjects }} out of your {{ freeObjects  }} free users.
            </p>
            <br>
            <div v-if="subscribed">
                <button type="button" class="btn btn-success" @click="upgradeSubscription">
            		<i class="glyphicon glyphicon-arrow-up"></i>&nbsp;&nbsp;&nbsp;
            	    Upgrade to Pro
            	</button>
            </div>
            <div v-else>
                <button type="button" class="btn btn-success" data-toggle="modal"
			            data-target="#creditCardModal">
            		<i class="glyphicon glyphicon-arrow-up"></i>&nbsp;&nbsp;&nbsp;
            	    Upgrade to Pro
            	</button>
            </div>
            <small class="text-muted">
                You are not going to be changed if you dont go passed your {{ freeObjects }} free users.
            </small>
        </div>
    </div>
</template>



<script>

var Spinner = require("spin");

  export default {
    props: ['subscribed', 'plan', 'activeObjects', 'billableObjects', 'freeObjects'],
    data () {
        return {

        }
    },
    methods: {
        downgradeSubscription(){
                let vue = this;
                // I need to check the that downgradeSubscriptionUrl is defined
                let downgradeSubscriptionUrl = back.downgradeSubscriptionUrl;
                swal({
                    title: "Are you sure?",
                    text: "Your technicians and supervisors will become inactive!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, downgrade!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                }, function(isConfirm){
                        if (isConfirm) {
                            vue.$http.post(downgradeSubscriptionUrl).then((response) => {
                                vue.plan = 'free';
								vue.activeObjects = 0;
                                swal("Downgraded to free", "You account is set to free.", "success");
                            }, (response) => {
                                console.log(response);
                                swal("Sorry there was a problem!", "We could not downgrade your subscription,\
                                        send us an email to support@poolreportsystem.com", "error");
                            });
                        } else {
                            swal("Cancelled", "Your subscription was not changed.", "error");
                        }
                });
            },
            upgradeSubscription(){
                let vue = this;
                let clickEvent = event;
                // I need to check the that upgradeSubscriptionUrl is defined
                let upgradeSubscriptionUrl = back.upgradeSubscriptionUrl;
                let buttonTag = clickEvent.target.innerHTML;

                // Disable the submit button to prevent repeated clicks:
                clickEvent.target.disabled = true;
                clickEvent.target.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Upgrading';
                new Spinner({
                    left: "90%",
                    radius: 5,
                    length: 4,
                    width: 1,
                }).spin(clickEvent.target);

                vue.$http.post(upgradeSubscriptionUrl).then((response) => {
                    clickEvent.target.disabled = false;
                    this.plan = 'pro';
                    swal("Upgrated to Pro", "You account is set to pro.", "success");
                    // change button to downgrade
                }, (response) => {
                    console.log(response);
                    // enable, remove spinner and set tab to the one before
                    clickEvent.target.disabled = false;

                    swal("Sorry there was a problem!", "We could not upgrade your subscription,\
                            send us an email to support@poolreportsystem.com", "error");
                });
            },
    }
  }
</script>
