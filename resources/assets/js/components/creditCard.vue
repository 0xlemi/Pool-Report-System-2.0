<template>

    <button type="button" class="btn" :class="button.class" data-toggle="modal" data-target="#creditCardModal">
			<i class="glyphicon glyphicon-credit-card"></i>&nbsp;&nbsp;&nbsp;
            {{ button.tag }}
	</button>

    <!-- Modal for Credit Card form -->
    <div class="modal fade" id="creditCardModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Credit Card</h4>
          </div>
          <div class="modal-body">
    			<div class="row">
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
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            <button v-if="lastFour" type="button" class="btn btn-primary" @click="submitCreditCard">
                Update Credit Card
            </button>
            <button v-else type="button" class="btn btn-success" @click="submitCreditCard">
                <i class="glyphicon glyphicon-arrow-up"></i>&nbsp;&nbsp;&nbsp;
            	Upgrade to Pro
            </button>


          </div>
        </div>
      </div>
    </div>
</template>

<script>
import alert from './alert.vue';

let Spinner = require("spin");

export default {
    props: ['lastFour'],
    components: {
        alert
    },
    data(){
        return {
            date: new Date(),
            token: Laravel.csrfToken,
            url: Laravel.url+'settings/subscribe',

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
            return {
                tag: 'Upgrade to Pro',
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
