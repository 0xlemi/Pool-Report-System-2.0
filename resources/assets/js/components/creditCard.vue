<template>

    <button type="button" class="btn btn-inline" :class="button.class" @click="$broadcast('openModal', 'creditCardModal')">
			<i class="glyphicon glyphicon-credit-card"></i>&nbsp;&nbsp;&nbsp;
            {{ button.tag }}
	</button>

    <modal id="creditCardModal" title="Credit Card">
        <span slot="buttonsBefore">
            <slot name="buttonsBefore"></slot>
        </span>
        <span slot="buttons">
            <!-- Is Type button so is not going to submit -->
            <button v-if="lastFour" type="button" class="btn btn-primary" @click="submitCreditCard">
                Update Credit Card
            </button>
            <button v-else type="button" class="btn btn-success" @click="submitCreditCard">
                <slot>
                    <i class="glyphicon glyphicon-arrow-up"></i>&nbsp;&nbsp;&nbsp;
                	Upgrade to Pro
                </slot>
            </button>
        </span>
        <div class="col-md-12">
            <form action="{{ url }}" method="POST" id="payment-form">
                <input type="hidden" name="_token" value="{{ token }}">

                <alert :type="'danger'" :message.sync="alertMessage" :active.sync="alertOpen"></alert>

                <fieldset class="form-group">
            		<label class="form-label semibold">Card Number</label>
                    <div class="row">
                        <div class="col-md-6">
            		        <input type="text" size="20" data-stripe="number" class="form-control"
                                    placeholder="xxxx xxxx xxxx {{ (lastFour) ? lastFour: 'xxxx' }}">
                        </div>
                    </div>
            	</fieldset>

                <fieldset class="form-group">
            		<label class="form-label semibold">Expiration Date</label>
                    <div class="row">
                        <div class="col-md-3">
                        	<select class="form-control" data-stripe="exp_month">
                                <option value='01'>01 Janaury</option>
                                <option value='02'>02 February</option>
                                <option value='03'>03 March</option>
                                <option value='04'>04 April</option>
                                <option value='05'>05 May</option>
                                <option value='06'>06 June</option>
                                <option value='07'>07 July</option>
                                <option value='08'>08 August</option>
                                <option value='09'>09 September</option>
                                <option value='10'>10 October</option>
                                <option value='11'>11 November</option>
                                <option value='12'>12 December</option>
                        	</select>
                        </div>
                        <div class="col-md-3">
                        	<select class="form-control" data-stripe="exp_year">
                                <option v-for="n in 20" value='{{ date.getFullYear()+n }}'>{{ date.getFullYear()+n }}</option>
                        	</select>
                        </div>
                    </div>
            	</fieldset>

                <fieldset class="form-group">
            		<label class="form-label semibold">CVC Number</label>
                    <div class="row">
                        <div class="col-md-3">
                    	    <input type="text" size="4" data-stripe="cvc" class="form-control" placeholder="CVC">
                        </div>
                    </div>
            		<small class="text-muted">The number on the back of the card.</small>
            	</fieldset>
            </form>
        </div>
    </modal>
</template>

<script>
import alert from './alert.vue';
import modal from './modal.vue';

let Spinner = require("spin");

export default {
    props: ['lastFour', 'route', 'buttonTag'],
    components: {
        alert,
        modal
    },
    data(){
        return {
            date: new Date(),
            token: Laravel.csrfToken,
            url: Laravel.url+this.route,

            alertMessage: '',
            alertOpen: false,
        }
    },
    computed: {
        button(){
            if(this.lastFour){
                return {
                    tag: 'Update Credit Card',
                    class: 'primary',
                }
            }
            let tag = 'Upgrade to Pro';
            if(this.buttonTag){
                tag = this.buttonTag;
            }

            return {
                tag: tag,
                class: 'success',
            }
        }
    },
    methods:{
        submitCreditCard(){
            let $form = $('#payment-form');
            let clickEvent = event;
            let buttonTag = clickEvent.target.innerHTML;

            // Disable the submit button to prevent repeated clicks:
            clickEvent.target.disabled = true;
            clickEvent.target.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Checking Credit Card';

            new Spinner({
                left: "90%",
                radius: 5,
                length: 4,
                width: 1,
            }).spin(clickEvent.target);

            // Request a token from Stripe:
            Stripe.card.createToken($form, (status, response) => {
                if (response.error) { // Problem!

                    // Show the errors on the form:
                    this.alertMessage = response.error.message;
                    this.alertOpen = true;
                    clickEvent.target.disabled = false; // Re-enable submission
                    clickEvent.target.innerHTML = buttonTag;

                } else { // Token was created!

                    // Get the token ID:
                    var token = response.id;

                    // Insert the token ID into the form so it gets submitted to the server:
                    $form.append($('<input type="hidden" name="stripeToken">').val(token));

                    // Submit the form:
                    $form.get(0).submit();
                }
            });
        },
    },
}
</script>
