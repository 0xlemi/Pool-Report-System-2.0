<template>

	<div class="form-group row">
		<label class="col-sm-2 form-control-label">Payments</label>
		<div class="col-sm-10">
			<button type="button" class="btn btn-success" @click="getList"
					data-toggle="modal" data-target="#paymentsModal">
				<i class="fa fa-money"></i>&nbsp;&nbsp;&nbsp;Manage Payments
			</button>
		</div>
	</div>

    <!-- Modal for Payment preview -->
	<div class="modal fade" id="paymentsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">{{ title }}</h4>
	      </div>
	      <div class="modal-body">
				<div class="row">

                    <!-- Create new Payment -->
                    <div class="col-md-12" v-show="isFocus(1)">

						<alert type="danger" :message="alertMessageCreate" :active="alertActiveCreate"></alert>

                        <div class="form-group row" :class="{'form-group-error' : (checkValidationError('amount'))}">
							<label class="col-sm-2 form-control-label">Amount</label>
							<div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">$</div>
    								<input type="number" class="form-control" v-model="amount">
    								<div class="input-group-addon">{{ currency }}</div>
                                </div>
								<small v-if="checkValidationError('amount')" class="text-muted">{{ validationErrors.amount[0] }}</small>
							</div>
						</div>

					    <div class="form-group row" :class="{'form-group-error' : (checkValidationError('method'))}">
							<label class="col-sm-2 form-control-label">Methods</label>
							<div class="col-sm-10">
								<dropdown :key.sync="selectedMethod"
										:options="paymentMethods"
										:name="'method'">
								</dropdown>
								<small v-if="checkValidationError('method')" class="text-muted">{{ validationErrors.method[0] }}</small>
							</div>
						</div>

                    </div>

                    <!-- Index Payment -->
                    <div class="col-md-12" v-show="isFocus(2)">

						<alert type="danger" :message="alertMessageList" :active="alertActiveList"></alert>

						<bootstrap-table :columns="columns" :data="data" :options="options">
							<button type="button" class="btn btn-primary" @click="goToCreate" >
								<i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;&nbsp;Add Payment
							</button>
						</bootstrap-table>

                    </div>

                    <!-- Show Payment -->
                    <div class="col-md-12" v-show="isFocus(3)">

						<alert type="danger" :message="alertMessageShow" :active="alertActiveShow"></alert>

						<div class="form-group row">
							<div class="col-md-10 col-md-offset-2">
								<h3 style="display: inline;">
									<span v-if="verified" class="label label-success">Verified</span>
									<span v-else class="label label-default">Not Verified</span>
								</h3>
								<small v-if="verified" class="text-muted">Payment was done through Pool Report System.</small>
								<small v-else class="text-muted">Payment was added manually.</small>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-2 form-control-label">Paid at</label>
							<div class="col-md-10">
								<input type="text" readonly class="form-control" value="{{ paid }}">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Amount</label>
							<div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">$</div>
    								<input type="number" readonly class="form-control" v-model="amount">
    								<div class="input-group-addon">{{ currency }}</div>
                                </div>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Method</label>
							<div class="col-sm-10">
    							<input type="text" readonly class="form-control" v-model="method">
							</div>
						</div>

                    </div>

				</div>
	      </div>
	      <div class="modal-footer">
			<p style="float: left;" v-if="isFocus(3)">
				<button type="button" class="btn btn-danger" @click="destroy">
					<i class="font-icon font-icon-close-2"></i>&nbsp;&nbsp;&nbsp;Destroy
				</button>
			</p>

	        <button type="button" class="btn btn-default" data-dismiss="modal" v-if="!isFocus(3)">Close</button>

			<button type="button" class="btn btn-warning" v-if="isFocus(3) || isFocus(1)" @click="changeFocus(2)">
				<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back
			</button>

            <button type="button" class="btn btn-primary" v-if="isFocus(1)" @click="create">
				Create
			</button>

	      </div>
	    </div>
	  </div>
	</div>


</template>

<script>

var alert = require('./alert.vue');
var Spinner = require("spin");
var BootstrapTable = require('./BootstrapTable.vue');
import dropdown from './dropdown.vue';

  export default {
    props: ['invoiceId', 'baseUrl', 'paymentMethods'],
	components: {
		alert,
		BootstrapTable,
		dropdown
	},
    data () {
        return {
            focus: 2, // 1=create, 2=index, 3=show
            paymentId: 0,
            validationErrors: {},

			// alert
			alertMessageCreate: '',
			alertMessageList: '',
			alertMessageShow: '',
			alertActiveCreate: false,
			alertActiveList: false,
			alertActiveShow: false,

            selectedMethod: 'cash',

            method: '',
            verified: false,
            amount: '',
			paid: '',
            currency: '',
			columns: [
		      {
		        field: 'id',
		        title: '#',
				sortable: true,
		      },
		      {
		        field: 'paid',
		        title: 'Paid At',
				sortable: true,
		      },
			  {
		        field: 'amount',
		        title: 'Amount',
				sortable: true,
			  }
		    ],
		    data: [],
		    options: {
				iconsPrefix: 'font-icon',
		        toggle:'table',
		        sidePagination:'client',
		        pagination:'true',
				classes: 'table',
				icons: {
					paginationSwitchDown:'font-icon-arrow-square-down',
					paginationSwitchUp: 'font-icon-arrow-square-down up',
					refresh: 'font-icon-refresh',
					toggle: 'font-icon-list-square',
					columns: 'font-icon-list-rotate',
					export: 'font-icon-download'
				},
				paginationPreText: '<i class="font-icon font-icon-arrow-left"></i>',
				paginationNextText: '<i class="font-icon font-icon-arrow-right"></i>',
				pageSize: 5,
				pageList: [5, 10],
				search: true,
				showExport: true,
				exportTypes: ['excel', 'pdf'],
				minimumCountColumns: 2,
				showFooter: false,

				uniqueId: 'id',
				idField: 'id',

				toolbarButton: true,
				toolbarButtonText: 'Add Payment',
		    }
        }
    },
    computed: {
        invoiceUrl: function(){
            return this.baseUrl+'/invoices/'+this.invoiceId+'/payments'
        },
		paymentUrl: function(){
            return this.baseUrl+'/payments/'+this.paymentId;
		},
		title: function(){
            switch (this.focus){
                case 1:
                return 'New Payment';
                break;
                case 2:
                return 'Payments List';
                break;
                case 3:
                return 'View Payment #'+this.paymentId;
                break;
                default:
                return 'Payments';
            }
        }
    },
	events: {
		rowClicked(id){
			this.paymentId = id;
			this.getValues(id);
		}
	},
    methods: {
        getList(){
			this.resetAlert('list');
			this.$http.get(this.invoiceUrl).then((response) => {
				let data = response.data;

                this.data = data.list;
                this.currency = data.currency;
				this.validationErrors = {};
				this.$broadcast('refreshTable');
            }, (response) => {
				this.focus = 2;
				this.alertMessageList = "The information could not be retrieved, please try again."
				this.alertActiveList = true;
            });
        },
		getValues(paymentId){
			this.resetAlert('list');
			this.$http.get(this.paymentUrl).then((response) => {
				let data = response.data;
				this.amount = data.amount;
				this.paid = data.paid;
				this.method = data.method
				this.verified = data.verified
				this.changeFocus(3);
            }, (response) => {
				this.focus = 2;
				this.alertMessageList = "The information could not be retrieved, please try again.";
				this.alertActiveList = true;
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

			this.$http.post(this.invoiceUrl, {
                amount: this.amount,
                method: this.selectedMethod,
            }).then((response) => {
                this.changeFocus(2);
				this.getList();
            }, (response) => {
				if(response.status == 422){
					this.validationErrors = response.data;
					this.revertButton(clickEvent, buttonTag);
				}else{
					this.alertMessageCreate = "The payment could not be added, please try again."
					this.alertActiveCreate = true;
					this.revertButton(clickEvent, buttonTag);
				}
            });
		},
		destroy(){
			let vue = this;
			let clickEvent = event;
			swal({
                title: "Are you sure?",
                text: "Payment is going to permanently deleted!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
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

            this.$http.delete(this.paymentUrl).then((response) => {
				// clear values
				this.changeFocus(2);
            }, (response) => {
				this.alertMessageShow = "The payment could not be destroyed, please try again."
				this.alertActiveShow = true;
				this.revertButton(clickEvent, buttonTag);
            });
		},
		goToCreate(){
			this.clean();
			this.changeFocus(1);
		},
        checkValidationError($fildName){
            return $fildName in this.validationErrors;
        },
        isFocus(num){
            return this.focus == num;
        },
        changeFocus(num){
			if(num == 2){
				this.getList();
			}
            this.focus = num;
        },
		clean(){
			this.validationErrors = {};

			this.paid = '';
            this.amount = '';
            this.paymentId = 0;
		},
		resetAlert(alert){
			if(alert == 'create'){
				this.alertMessageCreate = ""
				this.alertActiveCreate = false;
			}else if(alert == 'list'){
				this.alertMessageList = ""
				this.alertActiveList = false;
			}else if(alert == 'show'){
				this.alertMessageShow = ""
				this.alertActiveShow = false;
			}
		},
		revertButton(clickEvent, buttonTag){
			// enable, remove spinner and set tab to the one before
			clickEvent.target.disabled = false;
			clickEvent.target.innerHTML = buttonTag;
		}
    },
    ready(){
		this.getList();
    }
  }
</script>
