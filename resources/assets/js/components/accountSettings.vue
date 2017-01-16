<template>

<alert :type="alertType" :message="alertMessage" :active="alertActive"></alert>

<fieldset class="form-group" :class="{'form-group-error' : (checkValidationError('name'))}">
	<label class="form-label semibold">Name</label>
	<input type="text" class="form-control" v-model="name">
	<small v-if="checkValidationError('name')" class="text-muted">{{ validationErrors.name[0] }}</small>
</fieldset>

<fieldset v-if="lastName" class="form-group" :class="{'form-group-error' : (checkValidationError('last_name'))}">
	<label class="form-label semibold">Last name</label>
	<input type="text" class="form-control" v-model="lastName">
	<small v-if="checkValidationError('last_name')" class="text-muted">{{ validationErrors.last_name[0] }}</small>
</fieldset>

<button  class="btn btn-success" type='button' @click="save">
	<i class="font-icon font-icon-ok"></i>&nbsp;&nbsp;&nbsp;Save
</button>

</template>

<script>
import alert from './alert.vue';
var Spinner = require("spin");

export default {
	props: ['name', 'lastName'],
	components:{
		alert
	},
	data(){
		return {
			alertMessage: '',
			alertActive: false,
			alertType: 'danger',
            validationErrors: {},
		}
	},
	methods:{
		save(){
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

			let data = {
				name: this.name,
			};
			if(this.lastName){
				data['last_name'] = this.lastName;
			}

			this.$http.post(Laravel.url+'settings/profile', data).then((response) => {
				this.alertMessage = "The profile settings were updated successfully.";
				this.alertActive = true;
				this.alertType = "success";
				this.revertButton(clickEvent, buttonTag);
			}, (response) => {
				if(response.status == 422){
					this.validationErrors = response.data;
				}else{
					this.alertMessage = "The profile settings could not be updated, please try again.";
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
	},
}
</script>
