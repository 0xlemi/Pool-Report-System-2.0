<template>
    <div class="col-md-12">
        <div v-if="hasConnect">

            <div v-if="lastFour">
                <h4 class="semibold">Payment Source</h4>
                <p>
                    <strong>You are ready to pay your pool service online.</strong><br>
                    To pay just go to statement, click on the invoice then inside the invoice click pay.<br>
                    <i>Remember we don't charge your credit card automatically. (for security reasons)</i> <br>
                    You need to click the button pay on the invoice.
                </p>
                <credit-card :last-four="lastFour" route="connect/customer" button-tag="Add Credit Card">
                	<span slot="buttonsBefore" style="float: left;">
            			<button class="btn btn-danger-outline btn-sm" type="button" @click="destroy">
            				<i class="font-icon font-icon-close-2"></i>&nbsp;&nbsp;&nbsp;
                            Remove credit card
                        </button>
            		</span>
        	    </credit-card>
                <br>
                <br>
            </div>
            <div v-else>
                <h4 class="semibold">Pay Your Pool Service Online.</h4>
                <p>
                    Your <strong>credit card is never going to be changed automatically</strong>.<br>
                    We are going to ask you first every time.<br>
                </p>
                <credit-card :last-four="lastFour" route="connect/customer" button-tag="Add Credit Card">
                    <i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;
                    Add Credit Card
                </credit-card>
                <br>
            </div>
        </div>
        <div v-else style="text-align:center">
            <br>
            <h3 class="semibold">Payments are disabled</h3>
            <p>
                <strong>
                    Sorry you cannot pay your pool service through Pool Report System.<br>
                    Because your pool company has not enable payments through the plataform.
                </strong>
            </p>
            <br>
        </div>
    </div>
</template>

<script>
import creditCard from './creditCard.vue';
var Spinner = require("spin");

export default {
    props: ['hasConnect', 'lastFour'],
    components:{
		creditCard
	},
    methods: {
        destroy(){
            let clickEvent = event;
			// save button text for later
            let buttonTag = clickEvent.target.innerHTML;

            // Disable the submit button to prevent repeated clicks:
            clickEvent.target.disabled = true;
            clickEvent.target.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Removing';
            new Spinner({
                left: "90%",
                radius: 5,
                length: 4,
                width: 1,
            }).spin(clickEvent.target);

            this.$http.delete(Laravel.url+'connect/customer').then((response) => {
                swal("Credit Card Removed", "Your credit card was successfully removed.", "success");
                this.$broadcast('closeModal', 'creditCardModal')
                this.revertButton(clickEvent, buttonTag);
                this.lastFour = null;
            }, (response) => {
                swal("Credit card couldn't be removed", "send us a email to support@poolreportsystem.com", "error");
                this.revertButton(clickEvent, buttonTag);
            });

        },
        revertButton(clickEvent, buttonTag){
			// enable, remove spinner and set tab to the one before
			clickEvent.target.disabled = false;
			clickEvent.target.innerHTML = buttonTag;
		}
    }

}
</script>
