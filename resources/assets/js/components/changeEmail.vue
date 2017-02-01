<template>

<!-- Button to activate the modal -->
<div class="col-sm-10">
	<button type="button" class="btn btn-primary"
			data-toggle="modal" data-target="#changeEmailModal">
		<i class="fa fa-envelope"></i>&nbsp;&nbsp;&nbsp;Change Email
	</button>
</div>

<!-- Modal for Change Email Settings -->
<div class="modal fade" id="changeEmailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Change Email</h4>
      </div>
      <div class="modal-body">
			<div class="row">
                <div class="col-md-12">

					<alert :type="alertType" :message="alertMessage" :active="alertActive"></alert>

					<fieldset class="form-group" :class="{'form-group-error' : (checkValidationError('password'))}">
						<input type="password" class="form-control" v-model="password" placeholder="Your current password">
						<small v-if="checkValidationError('password')" class="text-muted">{{ validationErrors.password[0] }}</small>
					</fieldset>

                    <fieldset class="form-group" :class="{'form-group-error' : (checkValidationError('email'))}">
						<input type="text" class="form-control" v-model="email" placeholder="Your new email">
						<small v-if="checkValidationError('email')" class="text-muted">{{ validationErrors.email[0] }}</small>
					</fieldset>

                </div>
			</div>
      </div>
      <div class="modal-footer">
        <button @click="change" type="button" class="btn btn-success">
			<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Change
		</button>
      </div>
    </div>
  </div>
</div>

</template>

<script>
import alert from './alert.vue';
var Spinner = require("spin");

export default {
	components: { alert },
	data(){
		return {
			email: '',
			password: '',
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

			this.$http.post(Laravel.url+'settings/changeEmail', {
				email: this.email,
				password: this.password
			}).then((response) => {
				this.revertButton(clickEvent, buttonTag);
				swal({
					title: 'Changed',
					text: response.data,
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
			this.password = '';
			this.email = '';
			this.resetAlert();
			$('#changeEmailModal').modal('hide');
		},
	}

}
</script>
