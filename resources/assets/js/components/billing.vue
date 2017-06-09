<template>
    <div class="col-md-12">
        <h4 class="semibold">Subscription</h4>

		<!-- Is on a pro subscription -->
        <div v-if="plan == 'pro'">
            <p>
                Your account is on a <strong>Pro</strong>
                subscription for {{ billableObjects }} users
            </p>
			<br>
			<credit-card :last-four="lastFour">
        	</credit-card>
			<div style="float:right">
	            <button type="button" class="btn btn-danger-outline btn-sm" @click="downgradeSubscription">
	        		<i class="glyphicon glyphicon-arrow-down"></i>&nbsp;&nbsp;&nbsp;
	        	    Downgrade to Free
	        	</button>
	            <small class="text-muted">
	                Downgrading will not delete any data,
	                but your supervisors and technicians<br>
	                are going to be set to inactive.
	            </small>
			</div>
			<br>
			<br>
        </div>

        <!-- Is unsubscribed or in a free subscription -->
        <div v-else>
            <p>
                Your account is on a <strong>free</strong> subscription.<br>
                Using {{ activeObjects }} out of your {{ freeObjects  }} free users.
            </p>
			<br>
			<credit-card :last-four="lastFour">
        	</credit-card>
            <div v-if="subscribed">
				<br>
                <button type="button" class="btn btn-success-outline" @click="upgradeSubscription">
            		<i class="glyphicon glyphicon-arrow-up"></i>&nbsp;&nbsp;&nbsp;
            	    Upgrade to Pro
            	</button>
            </div>
            <small class="text-muted">
                You are not going to be changed if you dont go passed your {{ freeObjects }} free users.
            </small>
        </div>

		<hr>

        <h4 class="semibold">Payments</h4>
        <div class="col-md-12" v-if="connect">
            <p>
                Your account is connected to stripe. This means you can now receive payments from your clients through the system.<br>
                To see your balance or retrieve your money. You will need to login to your stripe account.
            </p>
            <br>
            <div class="col-md-6 col-md-offset-2">
                <h5><strong>Information of your Stripe Connected Account</strong></h5>
                <fieldset class="form-group">
                	<label class="form-label semibold">Business Name</label>
                    <input type="text" class="form-control" readonly v-model="connect.businessName">
                </fieldset>
                <fieldset class="form-group">
                	<label class="form-label semibold">Business Url</label>
                    <input type="text" class="form-control" readonly v-model="connect.businessUrl">
                </fieldset>
                    <fieldset class="form-group">
                	<label class="form-label semibold">Country</label>
                    <input type="text" class="form-control" readonly v-model="connect.country">
                </fieldset>
                    <fieldset class="form-group">
                	<label class="form-label semibold">Default currency</label>
                    <input type="text" class="form-control" readonly v-model="connect.currency">
                </fieldset>
                    <fieldset class="form-group">
                	<label class="form-label semibold">Email</label>
                    <input type="text" class="form-control" readonly v-model="connect.email">
                </fieldset>
                    <fieldset class="form-group">
                	<label class="form-label semibold">Support email</label>
                    <input type="text" class="form-control" readonly v-model="connect.supportEmail">
                </fieldset>
                    <fieldset class="form-group">
                	<label class="form-label semibold">Support Phone</label>
                    <input type="text" class="form-control" readonly v-model="connect.supportPhone">
                </fieldset>
                <p>
                    Note: <strong>You can only view this information</strong>. To change it login to stripe and do it there.
                </p>
                <div style="float:right">
                	<button type="button" style="float:right" class="btn btn-danger-outline btn-sm" @click="removeConnectStripe">
                		<i class="fa fa-cc-stripe"></i>&nbsp;&nbsp;&nbsp;
                	    Disconnect from Stripe
                	</button>
                    <small style="float:right" class="text-muted">
                        Be carefull. If you disconnect your clients will not be able to pay you.
                    </small>
                </div>
            </div>
    		<br>
    		<br>
        </div>

        <div v-else>
    		<p>
    			Here is where you configure your account. To <strong>receive payments from your clients through the platform</strong>.<br>
    			Payments are processed through the <a target="_blank" href="https://stripe.com/">Stripe</a> plataform.<br>
    			If you don't have a stripe account we can help you make one.
    		</p>
    		<br>
    		<button type="button" class="btn btn-primary" @click="addConnectStripe">
        		<i class="fa fa-cc-stripe"></i>&nbsp;&nbsp;&nbsp;
        	    Connect to Stripe
        	</button>
    		<br>
    		<br>
        </div>

    </div>
</template>



<script>
import creditCard from './creditCard.vue';

var Spinner = require("spin");

  export default {
    props: ['subscribed', 'lastFour', 'plan', 'activeObjects', 'billableObjects', 'freeObjects', 'connect'],
	components:{
		creditCard
	},
    methods: {
        removeConnectStripe(){
            let vue = this;
            swal({
                title: "Are you sure?",
                text: "Remember, your clients will not be able to pay you!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, remove it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function(isConfirm){
                    if (isConfirm) {
                        vue.$http.post(Laravel.url+'connect/remove').then((response) => {
							vue.connect = null;
                            swal("Account disconnected", "Your stripe account in not longer linked to Pool Report System.", "success");
                        }, (response) => {
                            swal("Sorry there was a problem!", "We could not disconnect your account,\
                                    please login to your stripe account and do it there.", "error");
                        });
                    } else {
                        swal("Cancelled", "Stripe account was not disconnected.", "error");
                    }
            });
        },
		addConnectStripe(){
		    let clickEvent = event;
            let buttonTag = clickEvent.target.innerHTML;

            // Disable the submit button to prevent repeated clicks:
            clickEvent.target.disabled = true;
            clickEvent.target.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Connecting';
            new Spinner({
                left: "90%",
                radius: 5,
                length: 4,
                width: 1,
            }).spin(clickEvent.target);
			window.location.href = Laravel.url+'connect/login';
		},
        downgradeSubscription(){
                let vue = this;
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
                            vue.$http.post(Laravel.url+'settings/downgradeSubscription').then((response) => {
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

                vue.$http.post(Laravel.url+'settings/upgradeSubscription').then((response) => {
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
