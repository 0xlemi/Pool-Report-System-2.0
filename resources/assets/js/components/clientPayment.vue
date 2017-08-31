<template>

	<button type="button" class="btn btn-success" @click="clickButton">
		<i class="fa fa-money"></i>&nbsp;&nbsp;&nbsp;Manage Payments
	</button>

	<modal :title="title" id="paymentsModal">

        <!-- Index Payment -->
        <div class="col-md-12" v-show="isFocus(2)">

			<alert type="danger" :message="alertMessageList" :active="alertActiveList"></alert>

			<bootstrap-table :columns="columns" :data="data" :options="options"></bootstrap-table>

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

		<button slot="buttons" type="button" class="btn btn-warning" v-if="isFocus(3)" @click="changeFocus(2)">
			<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back
		</button>
	</modal>

</template>

<script>

var alert = require('./alert.vue');
var Spinner = require("spin");
var BootstrapTable = require('./BootstrapTable.vue');
import dropdown from './dropdown.vue';
import modal from './modal.vue';

  export default {
    props: ['invoiceId'],
	components: {
		alert,
		BootstrapTable,
		dropdown,
		modal
	},
    data () {
        return {
            focus: 2, // 2=index, 3=show
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
			this.$http.get(Laravel.url+'invoices/'+this.invoiceId+'/payments').then((response) => {
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
			this.$http.get(Laravel.url+'payments/'+this.paymentId).then((response) => {
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
		clickButton(){
			this.getList();
			this.$broadcast('openModal', 'paymentsModal');
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
			if(alert == 'list'){
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
