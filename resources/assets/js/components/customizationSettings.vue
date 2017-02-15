<template>

    <alert :type="alertType" :message="alertMessage" :active="alertActive"></alert>

    <fieldset class="form-group" :class="{'form-group-error' : (checkValidationError('company_name'))}">
    	<label class="form-label semibold">Company Name</label>
    	<input type="text" class="form-control" v-model="companyName">
	    <small v-if="checkValidationError('company_name')" class="text-muted">{{ validationErrors.company_name[0] }}</small>
    </fieldset>

    <fieldset class="form-group" :class="{'form-group-error' : (checkValidationError('timezone'))}">
    	<label class="form-label semibold">Timezone</label>
        <timezone-dropdown class="bootstrap-select bootstrap-select-arrow" :timezone.sync="timezone" :timezone-list="timezoneList"></timezone-dropdown>
	    <small v-if="checkValidationError('timezone')" class="text-muted">{{ validationErrors.timezone[0] }}</small>
    </fieldset>

    <fieldset class="form-group" :class="{'form-group-error' : (checkValidationError('website'))}">
    	<label class="form-label semibold">Website</label>
    	<div class="input-group">
            <div class="input-group-addon">http://</div>
            <input type="text" class="form-control" v-model="website">
        </div>
	    <small v-if="checkValidationError('website')" class="text-muted">{{ validationErrors.website[0] }}</small>
    </fieldset>

    <fieldset class="form-group" :class="{'form-group-error' : (checkValidationError('facebook'))}">
    	<label class="form-label semibold">Facebook</label>
    	<div class="input-group">
            <div class="input-group-addon">http://www.facebook.com/</div>
            <input type="text" class="form-control" v-model="facebook">
        </div>
	    <small v-if="checkValidationError('facebook')" class="text-muted">{{ validationErrors.facebook[0] }}</small>
    </fieldset>

    <fieldset class="form-group" :class="{'form-group-error' : (checkValidationError('twitter'))}">
    	<label class="form-label semibold">Twitter</label>
    	<div class="input-group">
            <div class="input-group-addon">http://www.twitter.com/</div>
            <input type="text" class="form-control" v-model="twitter">
        </div>
	    <small v-if="checkValidationError('twitter')" class="text-muted">{{ validationErrors.twitter[0] }}</small>
    </fieldset>

    <button  class="btn btn-success" type='button' @click="save">
    	<i class="font-icon font-icon-ok"></i>&nbsp;&nbsp;&nbsp;Save
    </button>

</template>

<script>
import alert from './alert.vue';
import timezoneDropdown from './timezoneDropdown.vue';
var Spinner = require("spin");

export default {
    props: ['companyName', 'timezone', 'website', 'facebook', 'twitter', 'timezoneList' ],
	components:{
		alert,
        timezoneDropdown
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

			this.$http.post(Laravel.url+'settings/customization', {
                company_name: this.companyName,
                timezone: this.timezone,
                language: this.language,
                website: this.website,
                facebook: this.facebook,
                twitter: this.twitter,
            }).then((response) => {
				this.alertMessage = "The customization settings were updated successfully.";
				this.alertActive = true;
				this.alertType = "success";
				this.revertButton(clickEvent, buttonTag);
			}, (response) => {
				if(response.status == 422){
					this.validationErrors = response.data;
				}else{
					this.alertMessage = "The customization settings could not be updated, please try again.";
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
