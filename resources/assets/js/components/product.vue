<template>

<!-- Button -->
<div class="form-group row">
	<label class="col-sm-2 form-control-label">Products</label>
	<div class="col-sm-10">
		<button type="button" class="btn btn-info" @click="getList"
				data-toggle="modal" data-target="#productModal">
			<i class="fa fa-flask"></i>&nbsp;&nbsp;&nbsp;Manage Products
		</button>
	</div>
</div>

<!-- Modal for Product managment -->
<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" :class="{'modal-lg' : (focus == 2)}" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{ title }}</h4>
      </div>
      <div class="modal-body">
			<div class="row">

                <!-- Create new Product -->
                <div class="col-md-12" v-show="isFocus(1)">

					<alert type="danger" :message="alertMessageCreate" :active="alertActiveCreate"></alert>

					<div class="form-group row" :class="{'form-group-error' : (checkValidationError('global_product'))}">
						<label class="col-sm-2 form-control-label">Global Product</label>
						<div class="col-sm-10">
							<dropdown :key="0"
								:options="globalProducts"
								:name="'globalProduct'">
							</dropdown>
							<small v-if="checkValidationError('global_product')" class="text-muted">{{ validationErrors.global_product[0] }}</small>
						</div>
					</div>

                    <div class="form-group row">
						<label class="col-sm-2 form-control-label">Amount</label>
						<div class="col-sm-10">
    						<input type="text" class="form-control" v-model="amount" placeholder="Amount">
                        </div>
					</div>

                </div>

                <!-- Index Product -->
                <div class="col-md-12" v-show="isFocus(2)">

					<alert type="danger" :message="alertMessageList" :active="alertActiveList"></alert>

					<bootstrap-table :columns="columns" :data="data" :options="options">
						<button type="button" class="btn btn-primary" @click="goToCreate" >
							<i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;&nbsp;Add Product
						</button>
					</bootstrap-table>

                </div>

                <!-- Edit Product -->
                <div class="col-md-12" v-show="isFocus(3)">

					<alert type="danger" :message="alertMessageEdit" :active="alertActiveEdit"></alert>

					<div class="form-group row">
						<label class="col-sm-2 form-control-label">Name</label>
						<div class="col-sm-10">
							<input type="text" name="name" class="form-control" readonly v-model="name">
						</div>
					</div>

                    <div class="form-group row">
						<label class="col-sm-2 form-control-label">Brand</label>
						<div class="col-sm-10">
							<input type="text" name="name" class="form-control" readonly v-model="brand">
						</div>
					</div>

                    <div class="form-group row">
						<label class="col-sm-2 form-control-label">Type</label>
						<div class="col-sm-10">
							<input type="text" name="name" class="form-control" readonly v-model="type">
						</div>
					</div>

                    <div class="form-group row">
						<label class="col-sm-2 form-control-label">Amount</label>
						<div class="col-sm-10">
                            <div class="input-group">
    							<input type="text" class="form-control" v-model="amount" placeholder="Amount">
    							<div class="input-group-addon">{{ units }}</div>
    						</div>
                        </div>
					</div>

                    <div class="form-group row">
						<label class="col-sm-2 form-control-label">Unit Price</label>
						<div class="col-sm-10">
							<input type="text" name="name" class="form-control" readonly v-model="unitPrice">
						</div>
					</div>

                    <div class="form-group row">
						<label class="col-sm-2 form-control-label">Monthly Price</label>
						<div class="col-sm-10">
							<input type="text" name="name" class="form-control" readonly v-model="monthlyPrice">
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

        <button type="button" class="btn btn-success" v-if="isFocus(3)" @click="update">
			<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Update
		</button>

      </div>
    </div>
  </div>
</div>
</template>

<script>

var dropdown = require('./dropdown.vue');
var alert = require('./alert.vue');
var Spinner = require("spin");
var BootstrapTable = require('./BootstrapTable.vue');

  export default {
    props: ['serviceId', 'globalProducts'],
	components: {
		dropdown,
		alert,
		BootstrapTable
	},
    data () {
        return {
            focus: 2, // 1=create, 2=index, 3=edit
            productId: 0,
            validationErrors: {},

			// alert
			alertMessageCreate: '',
			alertMessageList: '',
			alertMessageEdit: '',
			alertActiveCreate: false,
			alertActiveList: false,
			alertActiveEdit: false,

			globalProductId: 0,
            name: '',
            brand: '',
            type: '',
            amount: 0,
            units: '',
            unitPrice: '',
            monthlyPrice: '',
			columns: [
    		    {
    		        title: 'Item ID',
    		        field: 'id',
    				sortable: true,
    				visible: false,
    		    },
    		    {
    		        field: 'name',
    		        title: 'Name',
    				sortable: true,
                },
                {
    		       field: 'brand',
    		        title: 'Brand',
    				sortable: true,
                },
                {
    		        field: 'monthly_amount',
    		        title: 'Monthly Amount',
    				sortable: true,
                },
                {
    		        field: 'monthly_price',
    		        title: 'Monthly Price',
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
				// singleSelect: true,
				// clickToSelect: true,

				toolbarButton: true,
				toolbarButtonText: 'Add Product',
		    }
        }
    },
    computed: {
		title(){
            switch (this.focus){
                case 1:
                return 'New Product';
                break;
                case 2:
                return 'Products List';
                break;
                case 3:
                return 'Edit Product';
                break;
                default:
                return 'Products';
            }
        }
    },
	events: {
		rowClicked(id){
			this.productId= id;
			this.getValues(id);
		},
		dropdownChanged(key){
			this.globalProductId= key;
		}
	},
    methods: {
        getList(){
			this.resetAlert('list');

			let url = Laravel.url+'service/'+this.serviceId+'/products';
			this.$http.get(url).then((response) => {
				this.data = response.data.data;
				this.validationErrors = {};
				this.$broadcast('refreshTable');
            }, (response) => {
				this.focus = 2;
				this.alertMessageList = "The information could not be retrieved, please try again."
				this.alertActiveList = true;
            });
        },
		getValues(productId){
			let url = Laravel.url+'products/'+productId;
			this.$http.get(url).then((response) => {
				let data = response.data.data;
                this.name = data.name;
                this.brand = data.brand;
                this.type = data.type;
                this.amount = data.amount;
                this.units = data.units;
                this.unitPrice = data.unit_price;
                this.monthlyPrice = data.monthly_price;
				this.focus = 3;
            }, (response) => {
				this.focus = 2;
				this.alertMessageList = "The information could not be retrieved, please try again."
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

			let url = Laravel.url+'service/'+this.serviceId+'/products';
			this.$http.post(url, {
				global_product: this.globalProductId,
                amount: this.amount,
            }).then((response) => {
                this.changeFocus(2);
				this.getList();
            }, (response) => {
				if(response.status == 422){
					this.validationErrors = response.data;
					this.revertButton(clickEvent, buttonTag);
				}else{
					this.alertMessageCreate = "The product could not be created, please try again."
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

			let url = Laravel.url+'products/'+this.productId;
            this.$http.patch(url, {
                amount: this.amount,
            }).then((response) => {
				// refresh the information
                this.changeFocus(2);
            }, (response) => {
				if(response.status == 422){
					this.validationErrors = response.data;
					this.revertButton(clickEvent, buttonTag);
				}else{
					this.alertMessageEdit = "The product could not be updated, please try again."
					this.alertActiveEdit = true;
					this.revertButton(clickEvent, buttonTag);
				}
            });
        },
		destroy(){
			let vue = this;
			let clickEvent = event;
			swal({
                title: "Are you sure?",
                text: "Product is going to permanently deleted!",
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

			this.resetAlert('list');
            // Disable the submit button to prevent repeated clicks:
            clickEvent.target.disabled = true;
            clickEvent.target.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Loading';
            new Spinner({
                left: "90%",
                radius: 5,
                length: 4,
                width: 1,
            }).spin(clickEvent.target);

			let url = Laravel.url+'products/'+this.productId;
            this.$http.delete(url).then((response) => {
				// clear values
				this.changeFocus(2);
            }, (response) => {
				this.alertMessageEdit = "The product could not be destroyed, please try again."
				this.alertActiveEdit = true;
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

			this.name = '';
            this.amount = '';
            this.units = '';
		},
		resetAlert(alert){
			if(alert == 'create'){
				this.alertMessageCreate = ""
				this.alertActiveCreate = false;
			}else if(alert == 'list'){
				this.alertMessageList = ""
				this.alertActiveList = false;
			}else if(alert == 'edit'){
				this.alertMessageEdit = ""
				this.alertActiveEdit = false;
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
