<template>

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
                        create
                    </div>

                    <!-- Show Contract -->
                    <div class="col-md-12" v-show="isFocus(2)">
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
                    						name="start_time" value="{{ startTime }}" readonly>
                    				<div class="input-group-addon">To:</div>
                    				<input type="text" class="form-control"
                    						name="end_time" value="{{ endTime }}" readonly>
                    			</div>
                    		</div>
                    	</div>
                    	<div class="form-group row">
                    		<label class="col-sm-2 form-control-label">Price</label>
                    		<div class="col-sm-10">
                    			<input type="text" readonly class="form-control" id="inputPassword" value="{{ priceWithCurrency }}">
                    		</div>
                    	</div>

                    </div>

                    <!-- Edit Contract -->
                    <div class="col-md-12" v-show="isFocus(3)">

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
											<div class="input-group clockpicker" data-autoclose="true">
												<input type="text" class="form-control" v-model="startTime">
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-time"></span>
												</span>
											</div>
										<div class="input-group-addon">To:</div>
										<div class="input-group clockpicker" data-autoclose="true">
											<input type="text" class="form-control" v-model="endTime">
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-time"></span>
											</span>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group row">
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
								</div>
							</div>
                    </div>
				</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal" v-if="!isFocus(3)">Close</button>

            <button type="button" class="btn btn-primary" data-dismiss="modal" v-if="isFocus(1)">
				Create
			</button>

			<p style="float: left;">
	            <button type="button" class="btn btn-warning" data-dismiss="modal" v-if="isFocus(2)" @click="deactivateContract()">
					Deactivate Contract
				</button>
			</p>
	        <button type="button" class="btn btn-primary" data-dismiss="modal" v-if="isFocus(2)" @click="changeFocus(3)">
				<i class="font-icon font-icon-pencil"></i>&nbsp;&nbsp;&nbsp;Edit
			</button>


            <button type="button" class="btn btn-warning" data-dismiss="modal" v-if="isFocus(3)" @click="changeFocus(2)">
				<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back
			</button>
            <button type="button" class="btn btn-success" data-dismiss="modal" v-if="isFocus(3)" @click="update()">
				<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Update
			</button>

	      </div>
	    </div>
	  </div>
	</div>


</template>

<script>

  export default {
    props: ['serviceId', 'serviceContractUrl', 'currencies'],
    data () {
        return {
            focus: 1, // 1=create, 2=show, 3=edit
            monday: false,
            tuesday: false,
            wednesday: false,
            thursday: false,
            friday: false,
            saturday: false,
            sunday: false,
            serviceDaysString: '',
            startTime: '',
            endTime: '',
            price: '',
            currency: '',
        }
    },
    computed: {
        priceWithCurrency: function(){
            return this.price+' '+this.currency;
        },
        Url: function(){
            return this.serviceContractUrl+this.serviceId;
        },
    },
    methods: {
        getValues(){
            let vue = this;
            this.$http.get(this.Url).then((response) => {
                let data = response.data;
                vue.focus = (data.contractExists) ? 2 : 1;
                if(data.contractExists){

                    vue.monday = data.serviceDaysArray['monday'];
                    vue.tuesday = data.serviceDaysArray['tuesday'];
                    vue.wednesday = data.serviceDaysArray['wednesday'];
                    vue.thursday = data.serviceDaysArray['thursday'];
                    vue.friday = data.serviceDaysArray['friday'];
                    vue.saturday = data.serviceDaysArray['saturday'];
                    vue.sunday = data.serviceDaysArray['sunday'];
                    vue.serviceDaysString = data.serviceDaysString;

                    vue.startTime = data.startTime;
                    vue.endTime = data.endTime;

                    vue.price = data.object.amount;
                    vue.currency = data.object.currency;
                }

            }, (response) => {
                console.log('error with contract');
            });
        },
        update(){
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
                price: this.price,
                currency: this.currency,
            }).then((response) => {

            }, (response) => {
                console.log('error with contract');
            });
        },
		deactivateContract(){

		},
        destroyContract(){

        },
		buttonClass(day){
			return (day) ? 'btn-secondary':'btn-default';
		},
        isFocus(num){
            return this.focus == num;
        },
        changeFocus(num){
            this.focus = num;
        }
    },
    ready(){
        this.getValues();
    }
  }
</script>
