<template>
	<div class="form-group row" style="margin-bottom:30px">
		<label class="col-sm-2 form-control-label">{{ title }}</label>
		<div class="col-sm-10">
		    <div style="margin-bottom:10px">
    			<div class="input-group">
    				<div class="input-group-addon">Real</div>
    				<input type="text" readonly class="form-control" :value="realValue">
    				<span class="input-group-btn">
    					<button class="btn btn-success bootstrap-touchspin-up" @click="openModal" type="button">Request Change</button>
    				</span>
    			</div>
			    <small v-if="text" class="text-muted">{{ text }}</small>
            </div>
			<div class="input-group">
				<div class="input-group-addon">Reference</div>
				<input type="text" readonly class="form-control" :value="referenceValue">
			</div>
		</div>
	</div>


    <modal :id="modalId" :title="modalTitle" class="">
        <div class="col-md-12">
            <alert :type="alertType" :message="alertMessage" :active="alertActive"></alert>

            <fieldset class="form-group" :class="{'form-group-error' : (checkValidationError('real_value'))}">
    			<input type="text" v-model="newValue" class="form-control" placeholder="New {{ title }}">
    			<small v-if="checkValidationError('real_value')" class="text-muted">{{ validationErrors.real_value[0] }}</small>
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
    props: [ 'realValue' , 'referenceValue', 'name', 'text', 'urcId' ],
    components: {
        modal,
        alert
    },
    data() {
        return {
            newValue: '',
            alertMessage: '',
			alertActive: false,
			alertType: 'danger',
            validationErrors: {},
        }
    },
    computed: {
        title(){
            let name = this.name;
            let title = name.split('_').join(' ');
            // Title case
            return title.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
        },
        modalId(){
            return 'modal'+this.name
        },
        modalTitle(){
            return 'Request Change of '+this.title
        }
    },
    methods: {
        change(){
			let clickEvent = event;
			// save button text for later
            let buttonTag = clickEvent.target.innerHTML;

			this.resetAlert();
            // Disable the submit button to prevent repeated clicks:
            clickEvent.target.disabled = true;
            clickEvent.target.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Requesting';
            new Spinner({
                left: "90%",
                radius: 5,
                length: 4,
                width: 1,
            }).spin(clickEvent.target);

			// clear the validation errors
			this.validationErrors = {};

			this.$http.post(Laravel.url+'urc/'+this.urcId+'/requestChange', {
				[this.name+'_extra']: this.newValue,
			}).then((response) => {
				this.revertButton(clickEvent, buttonTag);
				swal({
					title: 'Request Sent',
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
					this.alertMessage = "There was a error sending change request, send us a email at support@poolreportsystem.com";
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
			this.newValue= '';
			this.resetAlert();
			$('#'+this.modalId).modal('hide');
		},
        openModal(){
            this.$broadcast('openModal', this.modalId);
        }
    }

}
</script>
