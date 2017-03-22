<template>

<!-- Button to activate the modal -->
<div class="col-sm-10">
	<button type="button" class="btn btn-warning"
			data-toggle="modal" data-target="#changePasswordModal">
		<i class="fa fa-key"></i>&nbsp;&nbsp;&nbsp;Change Password
	</button>
</div>

<modal title="Change Password" id="changePasswordModal" modal-class="modal-sm">
    <div class="col-md-12">
		<alert :type="alertType" :message="alertMessage" :active="alertActive"></alert>

        <fieldset class="form-group" :class="{'form-group-error' : (checkValidationError('password'))}">
			<input type="text" v-model="password" class="form-control" placeholder="Your new password">
			<small v-if="checkValidationError('password')" class="text-muted">{{ validationErrors.password[0] }}</small>
		</fieldset>

        <fieldset class="form-group" :class="{'form-group-error' : (checkValidationError('password_confirmation'))}">
			<input type="text" v-model="password_confirmation" class="form-control" placeholder="Confirm the new password">
			<small v-if="checkValidationError('password_confirmation')" class="text-muted">{{ validationErrors.password_confirmation[0] }}</small>
		</fieldset>
    </div>

    <button slot="buttons" @click="change" type="button" class="btn btn-success">
		<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Change
	</button>
</modal>

</template>

<script>
import alert from './alert.vue';
import modal from './modal.vue';
var Spinner = require("spin");

export default {
    props: ['id'],
	components: {
        alert,
        modal
    },
	data(){
		return {
			password: '',
			password_confirmation: '',
			alertMessage: '',
			alertActive: false,
			alertType: 'danger',
            validationErrors: {},
		}
	},
	methods:{
		change(){
			let clickEvent = event;
			// save button text for later
            let buttonTag = clickEvent.target.innerHTML;

			this.resetAlert();
            // Disable the submit button to prevent repeated clicks:
            clickEvent.target.disabled = true;
            clickEvent.target.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saving';
            new Spinner({
                left: "90%",
                radius: 5,
                length: 4,
                width: 1,
            }).spin(clickEvent.target);

			// clear the validation errors
			this.validationErrors = {};

			this.$http.post(Laravel.url+'technicians/password/'+this.id, {
				password: this.password,
				password_confirmation: this.password_confirmation,
			}).then((response) => {
				this.revertButton(clickEvent, buttonTag);
				swal({
					title: 'Changed',
					text: response.data.message,
					type: 'success',
					timer: 2000,
					showConfirmButton: false
                });
				this.clean();
			}, (response) => {
				if(response.status == 422){
					this.validationErrors = response.data;
				}else{
					this.alertMessage = response.data;
					this.alertActive = true;
					this.alertType = "danger";
				}
				this.revertButton(clickEvent, buttonTag);
			});
		},
		revertButton(clickEvent, buttonTag){
			// enable, remove spinner and set tab to the one before
			clickEvent.target.disabled = false;
			clickEvent.target.innerHTML = buttonTag;
		},
		resetAlert(){
			this.alertMessage = "";
			this.alertActive = false;
			this.alertType = "danger";
		},
		checkValidationError(fildName){
            return fildName in this.validationErrors;
        },
		clean(){
			this.password= '';
			this.password_confirmation= '';
			this.resetAlert();
			$('#changePasswordModal').modal('hide');
		},
	}
}
</script>
