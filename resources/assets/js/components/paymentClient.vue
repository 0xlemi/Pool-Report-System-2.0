<template>
    <div class="col-md-12">
        <div v-if="hasConnect">
            <h4 class="semibold">Payments</h4>
        	<credit-card :last-four="">
        	</credit-card>
            <div v-if="hasCard">
                <div style="float:right">
    	            <button type="button" class="btn btn-danger-outline btn-sm" @click="removeCard">
    	        		<i class="glyphicon glyphicon-arrow-down"></i>&nbsp;&nbsp;&nbsp;
    	        	    Remove credit card
    	        	</button>
    	            <small class="text-muted">
    	                are going to be set to inactive.
    	            </small>
    			</div>
            </div>
            <div v-else>
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

}
</script>
