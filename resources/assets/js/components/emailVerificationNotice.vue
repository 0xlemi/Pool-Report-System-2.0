<template>
<div class="col-md-12">
	<alert :type="alertType" :message="alertMessage" :active="alertActive"></alert>
</div>
<div class="col-sm-10 col-sm-offset-2">
	<h3 style="display: inline;"><span class="label label-default">Unverified Account</span></h3>
	<small class="text-muted">This {{ name }} has not verified his account, by clicking on the email we sent him.
		<br>He will not recive emails or notifications until he verifies his account.
		<br>You can resend the verification email if they lost it.
		<br><strong>But don't do it too much, thats considered spam.</strong>
	</small>
	<br>
	<button @click="send" type="button" class="btn btn-sm btn-primary">Resend Acivation Email</button>
</div>
</template>

<script>
import alert from './alert.vue';
var Spinner = require("spin");

export default {
    components:{
        alert
    },
    props: ['name', 'seqId'],
    data(){
        return {
            'alertMessage': '',
            'alertActive': false,
            'alertType': 'danger',
        }
    },
    methods:{
        send(){
            let clickEvent = event;
			// save button text for later
            let buttonTag = clickEvent.target.innerHTML;

            // Disable the submit button to prevent repeated clicks:
            clickEvent.target.disabled = true;
            clickEvent.target.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sending';
            new Spinner({
                left: "90%",
                radius: 5,
                length: 4,
                width: 1,
            }).spin(clickEvent.target);

            this.alertActive = false;
            this.$http.post(Laravel.url+'activate/resend', {
				seq_id: this.seqId
			})
            .then(response => {
                this.alertMessage = 'The verification email was resent';
                this.alertType = 'success';
                this.alertActive = true;
				this.revertButton(clickEvent, buttonTag);
            }, response => {
				if(response.status == 409){
					this.alertMessage = response.data;
	                this.alertType = 'warning';
	                this.alertActive = true;
				}else if(response.status == 400){
					this.alertMessage = response.data;
	                this.alertType = 'danger';
	                this.alertActive = true;
				}else{
	                this.alertMessage = 'There was a error, we could not send the email. Send us a email at support@poolreportsystem.com';
	                this.alertType = 'danger';
	                this.alertActive = true;
				}
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
