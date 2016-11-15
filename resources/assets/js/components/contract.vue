<template>

	<!-- Button to activate the modal -->
	<div class="form-group row">
		<label class="col-sm-2 form-control-label">Contract</label>
		<div class="col-sm-10">
			<button type="button" class="btn btn-secondary"
					data-toggle="modal" data-target="#contractModal">
				<i class="font-icon font-icon-page"></i>&nbsp;&nbsp;&nbsp;{{ buttonTag }} Contract
			</button>
		</div>
	</div>

    <!-- Modal for ServiceContract preview -->
	<div class="modal fade" id="contractModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Contract</h4>
	      </div>
	      <div class="modal-body">
				<div class="row">
                    <!-- Create new Contract -->
                    <div class="col-md-12" v-show="isFocus(1)">

						<alert type="danger" :message="alertMessageCreate" :active="alertActiveCreate"></alert>

						<!-- <div class="form-group row">
							<label class="col-sm-2 form-control-label">Start at:</label>
							<div class="col-sm-10">
								<div class='input-group date' id="genericDatepicker">
									<input type='text' name='start' class="form-control" id="genericDatepickerInput"/>

									<span class="input-group-addon">
										<i class="font-icon font-icon-calend"></i>
									</span>
								</div>
							</div>
						</div> -->

						<div class="form-group row">
								<label class="col-sm-2 form-control-label">Service Days:</label>
								<div class="col-sm-10">
									<div class="btn-group btn-group-sm" >

										<button type="button" :class="buttonClass(monday)"
												class="btn" @click="monday = !monday" >Mon
										</button>
										<button type="button" :class="buttonClass(tuesday)"
												class="btn" @click="tuesday = !tuesday" >Tue
										</button>
										<button type="button" :class="buttonClass(wednesday)"
												class="btn" @click="wednesday = !wednesday" >Wed
										</button>
										<button type="button" :class="buttonClass(thursday)"
												class="btn" @click="thursday = !thursday" >Thu
										</button>
										<button type="button" :class="buttonClass(friday)"
												class="btn" @click="friday = !friday" >Fri
										</button>
										<button type="button" :class="buttonClass(saturday)"
												class="btn" @click="saturday = !saturday" >Sat
										</button>
										<button type="button" :class="buttonClass(sunday)"
												class="btn" @click="sunday = !sunday" >Sun
										</button>

									</div>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Time interval:</label>
								<div class="col-sm-10">
									<div class="input-group">
										<div class="input-group-addon">From:</div>
											<div class="input-group clockpicker" data-autoclose="true" :class="{'form-group-error' : (checkValidationError('start_time'))}">
												<input type="text" class="form-control" v-model="startTime">
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-time"></span>
												</span>
											</div>
										<div class="input-group-addon">To:</div>
										<div class="input-group clockpicker" data-autoclose="true" :class="{'form-group-error' : (checkValidationError('end_time'))}">
											<input type="text" class="form-control" v-model="endTime">
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-time"></span>
											</span>
										</div>
									</div>
									<small v-if="checkValidationError('start_time')" class="text-muted" style="color:red;">{{ validationErrors.start_time[0] }}</small>
									<small v-if="checkValidationError('end_time')" class="text-muted" style="color:red;">{{ validationErrors.end_time[0] }}</small>
								</div>
							</div>

							<div class="form-group row" :class="{'form-group-error' : (checkValidationError('amount') || checkValidationError('currency'))}">
								<label class="col-sm-2 form-control-label">Price:</label>
								<div class="col-sm-10">
									<div class="input-group">
										<div class="input-group-addon">$</div>
										<input type="text" class="form-control"
												placeholder="Amount" v-model="price">
										<div class="input-group-addon">
											<select v-model="currency">
												<option v-for="item in currencies" value="{{item}}">{{item}}</option>
											</select>
										</div>
									</div>
									<small v-if="checkValidationError('amount')" class="text-muted">{{ validationErrors.amount[0] }}</small>
									<small v-if="checkValidationError('currency')" class="text-muted">{{ validationErrors.currency[0] }}</small>
								</div>
							</div>
                    </div>

                    <!-- Show Contract -->
                    <div class="col-md-12" v-show="isFocus(2)">

						<alert type="danger" :message="alertMessageShow" :active="alertActiveShow"></alert>

						<div v-if="!active" class="alert alert-warning alert-fill alert-close alert-dismissible fade in" role="alert">
							This contract is deactivated
						</div>

                        <div class="form-group row">
                    		<label class="col-sm-2 form-control-label">Service days</label>
                    		<div class="col-sm-10">
                                <span class="label label-pill label-default">{{ serviceDaysString }}</span>
                    		</div>
                    	</div>
                    	<div class="form-group row">
                    		<label class="col-sm-2 form-control-label">Time interval</label>
                    		<div class="col-sm-10">
                    			<div class="input-group">
                    				<div class="input-group-addon">From:</div>
                    				<input type="text" class="form-control"
                    						name="start_time" value="{{ startTimeShow }}" readonly>
                    				<div class="input-group-addon">To:</div>
                    				<input type="text" class="form-control"
                    						name="end_time" value="{{ endTimeShow }}" readonly>
                    			</div>
                    		</div>
                    	</div>
                    	<div class="form-group row">
                    		<label class="col-sm-2 form-control-label">Price</label>
                    		<div class="col-sm-10">
                    			<input type="text" readonly class="form-control" id="inputPassword" value="{{ priceShow }}">
                    		</div>
                    	</div>

                    </div>

                    <!-- Edit Contract -->
                    <div class="col-md-12" v-show="isFocus(3)">

						<alert type="danger" :message="alertMessageEdit" :active="alertActiveEdit"></alert>

                            <div class="form-group row">
								<label class="col-sm-2 form-control-label">Service Days:</label>
								<div class="col-sm-10">
									<div class="btn-group btn-group-sm" >

										<button type="button" :class="buttonClass(monday)"
												class="btn" @click="monday = !monday" >Mon
										</button>
										<button type="button" :class="buttonClass(tuesday)"
												class="btn" @click="tuesday = !tuesday" >Tue
										</button>
										<button type="button" :class="buttonClass(wednesday)"
												class="btn" @click="wednesday = !wednesday" >Wed
										</button>
										<button type="button" :class="buttonClass(thursday)"
												class="btn" @click="thursday = !thursday" >Thu
										</button>
										<button type="button" :class="buttonClass(friday)"
												class="btn" @click="friday = !friday" >Fri
										</button>
										<button type="button" :class="buttonClass(saturday)"
												class="btn" @click="saturday = !saturday" >Sat
										</button>
										<button type="button" :class="buttonClass(sunday)"
												class="btn" @click="sunday = !sunday" >Sun
										</button>

									</div>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Time interval:</label>
								<div class="col-sm-10">
									<div class="input-group">
										<div class="input-group-addon">From:</div>
											<div class="input-group clockpicker" data-autoclose="true" :class="{'form-group-error' : (checkValidationError('start_time'))}">
												<input type="text" class="form-control" v-model="startTime">
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-time"></span>
												</span>
											</div>
										<div class="input-group-addon">To:</div>
										<div class="input-group clockpicker" data-autoclose="true" :class="{'form-group-error' : (checkValidationError('end_time'))}">
											<input type="text" class="form-control" v-model="endTime">
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-time"></span>
											</span>
										</div>
									</div>
									<small v-if="checkValidationError('start_time')" class="text-muted" style="color:red;">{{ validationErrors.start_time[0] }}</small>
									<small v-if="checkValidationError('end_time')" class="text-muted" style="color:red;">{{ validationErrors.end_time[0] }}</small>
								</div>
							</div>

							<div class="form-group row" :class="{'form-group-error' : (checkValidationError('amount') || checkValidationError('currency'))}">
								<label class="col-sm-2 form-control-label">Price:</label>
								<div class="col-sm-10">
									<div class="input-group">
										<div class="input-group-addon">$</div>
										<input type="text" class="form-control"
												placeholder="Amount" v-model="price">
										<div class="input-group-addon">
											<select v-model="currency">
												<option v-for="item in currencies" value="{{item}}">{{item}}</option>
											</select>
										</div>
									</div>
									<small v-if="checkValidationError('amount')" class="text-muted">{{ validationErrors.amount[0] }}</small>
									<small v-if="checkValidationError('currency')" class="text-muted">{{ validationErrors.currency[0] }}</small>
								</div>
							</div>
                    </div>
				</div>
	      </div>
	      <div class="modal-footer">
			<p style="float: left;" v-if="isFocus(2)">
	            <button type="button" class="btn" :class="activationButton.class" @click="toggleActivation">
					{{ activationButton.tag }}
				</button>
			</p>
			<button type="button" class="btn btn-danger" v-if="isFocus(2) && !active" @click="destroy">
				<i class="font-icon font-icon-close-2"></i>&nbsp;&nbsp;&nbsp;Destroy
			</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal" v-if="!isFocus(3)">Close</button>

            <button type="button" class="btn btn-primary" v-if="isFocus(1)" @click="create">
				Create
			</button>

	        <button type="button" class="btn btn-primary" v-if="isFocus(2) && active" @click="changeFocus(3)">
				<i class="font-icon font-icon-pencil"></i>&nbsp;&nbsp;&nbsp;Edit
			</button>

            <button type="button" class="btn btn-warning" v-if="isFocus(3)" @click="changeFocus(2)">
				<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back
			</button>
            <button type="button" class="btn btn-success" v-if="isFocus(3)" @click="update">
				<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Update
			</button>

	      </div>
	    </div>
	  </div>
	</div>


</template>

<script>

var alert = require('./alert.vue');
var Spinner = require("spin");

  export default {
    props: ['serviceId', 'serviceContractUrl', 'currencies'],
	components: {
		alert
	},
    data () {
        return {
            focus: 1, // 1=create, 2=show, 3=edit
			contractExists: false,
            validationErrors: {},
			// days
            monday: false,
            tuesday: false,
            wednesday: false,
            thursday: false,
            friday: false,
            saturday: false,
            sunday: false,
            serviceDaysString: '',
			// alert
			alertMessageCreate: '',
			alertMessageShow: '',
			alertMessageEdit: '',
			alertActiveCreate: false,
			alertActiveShow: false,
			alertActiveEdit: false,

			active: true,
            startTime: '',
            endTime: '',
            price: '',
            currency: '',
			startTimeShow: '',
            endTimeShow: '',
            priceShow: '',
        }
    },
    computed: {
        Url: function(){
            return this.serviceContractUrl+this.serviceId;
        },
		activationButton: function(){
			if(this.active){
				return {
					tag: 'Deactivate Contract',
					class: 'btn-warning'
				};
			}
			return {
					tag: 'Activate Contract',
					class: 'btn-success'
				};
		},
        buttonTag: function(){
			return (this.contractExists) ? "Manage" : "Create";
        }
    },
    methods: {
        getValues(){
            this.$http.get(this.Url).then((response) => {
                let data = response.data;
				this.contractExists = data.contractExists;
                this.focus = (data.contractExists) ? 2 : 1;
				this.validationErrors = {};
                if(data.contractExists){

					this.active = data.active;

                    this.monday = data.serviceDaysArray['monday'];
                    this.tuesday = data.serviceDaysArray['tuesday'];
                    this.wednesday = data.serviceDaysArray['wednesday'];
                    this.thursday = data.serviceDaysArray['thursday'];
                    this.friday = data.serviceDaysArray['friday'];
                    this.saturday = data.serviceDaysArray['saturday'];
                    this.sunday = data.serviceDaysArray['sunday'];
                    this.serviceDaysString = data.serviceDaysString;

                    this.startTime = data.startTime;
                    this.endTime = data.endTime;
					this.startTimeShow = data.startTime;
                    this.endTimeShow = data.endTime;

                    this.price = data.object.amount;
                    this.currency = data.object.currency;
					this.priceShow = data.object.amount+' '+data.object.currency;

                }

            }, (response) => {
				this.focus = 2;
				this.alertMessageShow = "The information could not be retrieved, please try again.";
				this.alertActiveShow = true;
            });
        },
		create(){

			let clickEvent = event;
			// save button text for later
            let buttonTag = clickEvent.target.innerHTML;

			this.resetAlert('create');
            // Disable the submit button to prevent repeated clicks:
            clickEvent.target.disabled = true;
            clickEvent.target.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creating';
            new Spinner({
                left: "90%",
                radius: 5,
                length: 4,
                width: 1,
            }).spin(clickEvent.target);

			this.$http.post(this.Url, {
                serviceDays: {
                    monday: this.monday,
                    tuesday: this.tuesday,
                    wednesday: this.wednesday,
                    thursday: this.thursday,
                    friday: this.friday,
                    saturday: this.saturday,
                    sunday: this.sunday,
                },
                start_time: this.startTime,
                end_time: this.endTime,
                amount: this.price,
                currency: this.currency,
            }).then((response) => {
                this.focus = 2;
				// refresh the information
				this.getValues();
            }, (response) => {
				if(response.status == 422){
					this.validationErrors = response.data;
					this.revertButton(clickEvent, buttonTag);
				}else{
					this.alertMessageCreate = "The Service Contract could not be created, please try again.";
					this.alertActiveCreate = true;
					this.revertButton(clickEvent, buttonTag);
				}
            });
		},
        update(){

            let clickEvent = event;
			// save button text for later
            let buttonTag = clickEvent.target.innerHTML;

			this.resetAlert('edit');
            // Disable the submit button to prevent repeated clicks:
            clickEvent.target.disabled = true;
            clickEvent.target.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saving';
            new Spinner({
                left: "90%",
                radius: 5,
                length: 4,
                width: 1,
            }).spin(clickEvent.target);

            this.$http.patch(this.Url, {
                serviceDays: {
                    monday: this.monday,
                    tuesday: this.tuesday,
                    wednesday: this.wednesday,
                    thursday: this.thursday,
                    friday: this.friday,
                    saturday: this.saturday,
                    sunday: this.sunday,
                },
                start_time: this.startTime,
                end_time: this.endTime,
                amount: this.price,
                currency: this.currency,
            }).then((response) => {
				this.focus = 2;
				// refresh the information
				this.getValues();
            }, (response) => {
				if(response.status == 422){
					this.validationErrors = response.data;
					this.revertButton(clickEvent, buttonTag);
				}else{
					this.alertMessageEdit = "The Service Contract could not be updated, please try again.";
					this.alertActiveEdit = true;
					this.revertButton(clickEvent, buttonTag);
				}
            });

        },
		toggleActivation(){

			let clickEvent = event;
			// save button text for later
            let buttonTag = clickEvent.target.innerHTML;

			this.resetAlert('show');
            // Disable the submit button to prevent repeated clicks:
            clickEvent.target.disabled = true;
            clickEvent.target.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Loading';
            new Spinner({
                left: "90%",
                radius: 5,
                length: 4,
                width: 1,
            }).spin(clickEvent.target);

            this.$http.post(this.Url+'/active').then((response) => {
				this.active = response.data.active;
				this.revertButton(clickEvent, this.activationButton.tag);
            }, (response) => {
				this.alertMessageShow = "The activation could not be changed, please try again.";
				this.alertActiveShow = true;
				this.revertButton(clickEvent, buttonTag);
            });

		},
		destroy(){
			let vue = this;
			let clickEvent = event;
			swal({
                title: "Are you sure?",
                text: "All invoces associated with this contract will be destroyed too!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete invoices too!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if(isConfirm){
                    vue.destroyRequest(clickEvent);
                }
            });
		},
        destroyRequest(clickEvent){

			// save button text for later
            let buttonTag = clickEvent.target.innerHTML;

			this.resetAlert('show');
            // Disable the submit button to prevent repeated clicks:
            clickEvent.target.disabled = true;
            clickEvent.target.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Loading';
            new Spinner({
                left: "90%",
                radius: 5,
                length: 4,
                width: 1,
            }).spin(clickEvent.target);

            this.$http.delete(this.Url).then((response) => {
				// clear values
				this.clean();
				this.focus = 1;
            }, (response) => {
				this.alertMessageShow = "The Service Contract could not be destroyed, please try again.";
				this.alertActiveShow = true;
				this.revertButton(clickEvent, buttonTag);
            });

        },
        checkValidationError($fildName){
            return $fildName in this.validationErrors;
        },
		buttonClass(day){
			return (day) ? 'btn-secondary':'btn-default';
		},
        isFocus(num){
            return this.focus == num;
        },
        changeFocus(num){
            this.focus = num;
        },
		resetAlert(alert){
			if(alert == 'create'){
				this.alertMessageCreate = ""
				this.alertActiveCreate = false;
			}else if(alert == 'show'){
				this.alertMessageShow = ""
				this.alertActiveShow = false;
			}else if(alert == 'edit'){
				this.alertMessageEdit = ""
				this.alertActiveEdit = false;
			}
		},
		clean(){
			this.contractExists = false;
			this.validationErrors = {};

            this.monday = false;
            this.tuesday = false;
            this.wednesday = false;
            this.thursday = false;
            this.friday = false;
            this.saturday = false;
            this.sunday = false;
            this.serviceDaysString = '';

			this.active = true;
            this.startTime = '';
            this.endTime = '';
            this.price = '';
            this.currency = '';
			this.startTimeShow = '';
            this.endTimeShow = '';
            this.priceShow = '';
		},
		revertButton(clickEvent, buttonTag){
			// enable, remove spinner and set tab to the one before
			clickEvent.target.disabled = false;
			clickEvent.target.innerHTML = buttonTag;
		}
    },
    ready(){
        this.getValues();
    }
  }
</script>
