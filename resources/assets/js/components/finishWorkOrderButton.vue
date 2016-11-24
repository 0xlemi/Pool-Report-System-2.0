<template>
<button class="btn btn-success" data-toggle="modal"
		data-target="#finishModal">
	<i class="font-icon font-icon-ok"></i>
	&nbsp;&nbsp;Finish Work Order
</button>

<!-- Modal for email preview -->
<div class="modal fade" id="finishModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Finish Work Order</h4>
      </div>
      <div class="modal-body">
		<div class="row">
		<div class="col-md-12">

			<alert type="danger" :message="alertMessage" :active="alertActive"></alert>

			<div class="col-md-12">
				<photo-list :data="photos" :object-id="workOrderId"
								:can-delete="true" :photos-url="'workorders/photos/after'">
				</photo-list>
			</div>
			<div class="col-md-12">
                <dropzone :url="dropzoneUrl"><dropzone>
			</div>

			<hr>

			<div class="form-group row" :class="{'form-group-error' : (checkValidationError('end'))}">
				<label class="col-sm-2 form-control-label">Finished at</label>
				<div class="col-sm-10">
					<vue-datetime-picker class="" name="date" :model.sync="date"
										type="datetime" language="en" date-format="LLL">
			    	</vue-datetime-picker>
					<small v-if="checkValidationError('end')" class="text-muted" style="color:red;">{{ validationErrors.end[0] }}</small>
				</div>
			</div>

		</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button class="btn btn-success" type="button" @click="finish">
			<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Mark as Finished</button>
      </div>
    </div>
  </div>
</div>

</template>

<script>
import photoList from './photoList.vue';
import dropzone from './dropzone.vue';
import alert from'./alert.vue';

var Spinner = require("spin");
var VueDatetimePicker = require('vue-datetime-picker/src/vue-datetime-picker.js');

export default {
	props: [ 'workOrderId' ],
	components: {
		photoList,
		dropzone,
		alert,
		VueDatetimePicker
	},
	data(){
		return {
			photos: {},
			date: null,

			validationErrors: {},
			alertMessage: '',
			alertActive: false,
			token: Laravel.csrfToken,
		}
	},
	computed: {
		dropzoneUrl(){
			return 'workorders/photos/after/'+this.workOrderId;
		}
	},
	events: {
		photoUploaded(){
			this.refreshPhotos();
		}
	},
	methods: {
		refreshPhotos(){
            this.$http.get(Laravel.url+'workorders/photos/after/'+this.workOrderId).then((response) => {
                this.photos = response.data;
            });
        },
        finish(){
			let clickEvent = event;
			// save button text for later
            let buttonTag = clickEvent.target.innerHTML;

			this.resetAlert();
            // Disable the submit button to prevent repeated clicks:
            clickEvent.target.disabled = true;
            clickEvent.target.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Finishing';
            new Spinner({
                left: "90%",
                radius: 5,
                length: 4,
                width: 1,
            }).spin(clickEvent.target);

			this.$http.post(Laravel.url+'workorders/finish/'+this.workOrderId, {
	            'end': this.date,
			}).then((response) => {
				let data = response.data;
				window.location = back.workOrderUrl;
                // send success alert
                swal({
                    title: data.title,
                    text: data.message,
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
			}, (response) => {
				if(response.status == 422){
					this.validationErrors = response.data;
				}else{
					this.alertMessage = "The Work Order could not be finished, please try again.";
					this.alertActive = true;
				}
				this.revertButton(clickEvent, buttonTag);
			});
        },
		checkValidationError($fildName){
	        return $fildName in this.validationErrors;
	    },
		resetAlert(){
			this.alertMessage = ""
			this.alertActive = false;
		},
		revertButton(clickEvent, buttonTag){
			// enable, remove spinner and set tab to the one before
			clickEvent.target.disabled = false;
			clickEvent.target.innerHTML = buttonTag;
		}
	},
	ready(){
    	this.refreshPhotos();
	}

}
</script>
