<template>

<!-- Button -->
<button type="button" class="btn btn-info" @click="getList"
        data-toggle="modal" data-target="#globalProductModal">
	<i class="fa fa-flask"></i>&nbsp;&nbsp;&nbsp;Manage Global Products</button>


<!-- Modal for globalproducts managment -->
<div class="modal fade" id="globalProductModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" :class="{'modal-lg' : (focus == 2)}" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{ modalTitle }}</h4>
      </div>
      <div class="modal-body">
			<div class="row">


                <!-- Create Global Product -->
				<div class="col-md-12" v-show="isFocus(1)">

					<alert type="danger" :message="alertMessageCreate" :active="alertActiveCreate"></alert>

                    <div class="form-group row" :class="{'form-group-error' : (checkValidationError('name'))}">
						<label class="col-sm-2 form-control-label">Name</label>
						<div class="col-sm-10">
							<input type="text" name="name" class="form-control"
									placeholder="Example: Chlorine, Salt, PH Adjuster, etc..." v-model="name">
							<small v-if="checkValidationError('name')" class="text-muted">{{ validationErrors.name[0] }}</small>
						</div>
					</div>

                    <div class="form-group row" :class="{'form-group-error' : (checkValidationError('brand'))}">
						<label class="col-sm-2 form-control-label">Brand</label>
						<div class="col-sm-10">
							<input type="text" name="brand" class="form-control" v-model="brand">
							<small v-if="checkValidationError('brand')" class="text-muted">{{ validationErrors.brand[0] }}</small>
						</div>
					</div>

                   <div class="form-group row" :class="{'form-group-error' : (checkValidationError('type'))}">
						<label class="col-sm-2 form-control-label">Type</label>
						<div class="col-sm-10">
							<input type="text" name="type" class="form-control"
							placeholder="Example: Industrial, Concentrated, etc..." v-model="type">
							<small v-if="checkValidationError('type')" class="text-muted">{{ validationErrors.type[0] }}</small>
						</div>
					</div>

                    <div class="form-group row" :class="{'form-group-error' : (checkValidationError('unit_price') || checkValidationError('unit_currency'))}">
						<label class="col-sm-2 form-control-label">Price</label>
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
							<small v-if="checkValidationError('unit_price')" class="text-muted">{{ validationErrors.unit_price[0] }}</small>
							<small v-if="checkValidationError('unit_currency')" class="text-muted">{{ validationErrors.unit_currency[0] }}</small>
						</div>
					</div>

                    <div class="form-group row" :class="{'form-group-error' : (checkValidationError('units'))}">
						<label class="col-sm-2 form-control-label">Units</label>
						<div class="col-sm-10">
							<input type="text" name="units" class="form-control"
									placeholder="Example: pounds, tablets, etc..." v-model="units">
							<small v-if="checkValidationError('units')" class="text-muted">{{ validationErrors.units[0] }}</small>
						</div>
					</div>

                </div>


                <!-- List -->
				<div class="col-md-12" v-show="isFocus(2)">

					<alert type="danger" :message="alertMessageList" :active="alertActiveList"></alert>

					<bootstrap-table :columns="columns" :data="data" :options="options">
						<button type="button" class="btn btn-primary" @click="goToCreate" >
							<i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;&nbsp;Add Global Product
						</button>
					</bootstrap-table>

				</div>


                <!-- Show Global Product -->
				<div class="col-md-12" v-show="isFocus(3)">

					<alert type="danger" :message="alertMessageShow" :active="alertActiveShow"></alert>

					<div class="form-group row">
						<label class="col-sm-2 form-control-label">Type</label>
						<div class="col-sm-10">
							<input type="text" readonly class="form-control" v-model="showType">
						</div>
					</div>
                    <div class="form-group row">
						<label class="col-sm-2 form-control-label">Brand</label>
						<div class="col-sm-10">
							<input type="text" readonly class="form-control" v-model="showBrand">
						</div>
					</div>
                    <div class="form-group row">
						<label class="col-sm-2 form-control-label">Type</label>
						<div class="col-sm-10">
							<input type="text" readonly class="form-control" v-model="showType">
						</div>
					</div>
                    <div class="form-group row">
						<label class="col-sm-2 form-control-label">Price</label>
						<div class="col-sm-10">
							<input type="text" readonly class="form-control" v-model="showPrice">
						</div>
					</div>
					<br>

					<div v-show="photos.length > 0">
						<h5>Photos</h5>
						<photo-list :data="photos" :object-id="id"
									:can-delete="false" :photos-url="'globalproducts/photos'">
						</photo-list>
					</div>
				</div>


				<!-- Edit Global Product -->
                <div class="col-md-12" v-show="isFocus(4)">

					<alert type="danger" :message="alertMessageEdit" :active="alertActiveEdit"></alert>

                    <div class="form-group row" :class="{'form-group-error' : (checkValidationError('name'))}">
						<label class="col-sm-2 form-control-label">Name</label>
						<div class="col-sm-10">
							<input type="text" name="name" class="form-control" v-model="name">
							<small v-if="checkValidationError('name')" class="text-muted">{{ validationErrors.name[0] }}</small>
						</div>
					</div>

                   <div class="form-group row" :class="{'form-group-error' : (checkValidationError('type'))}">
						<label class="col-sm-2 form-control-label">Type</label>
						<div class="col-sm-10">
							<input type="text" name="type" class="form-control" v-model="type">
							<small v-if="checkValidationError('type')" class="text-muted">{{ validationErrors.type[0] }}</small>
						</div>
					</div>

                    <div class="form-group row" :class="{'form-group-error' : (checkValidationError('brand'))}">
						<label class="col-sm-2 form-control-label">Brand</label>
						<div class="col-sm-10">
							<input type="text" name="brand" class="form-control" v-model="brand">
							<small v-if="checkValidationError('brand')" class="text-muted">{{ validationErrors.brand[0] }}</small>
						</div>
					</div>

                    <div class="form-group row" :class="{'form-group-error' : (checkValidationError('unit_price') || checkValidationError('unit_currency'))}">
							<label class="col-sm-2 form-control-label">Price</label>
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
                                    <div class="input-group-addon">
                                        per {{ units }}
									</div>
								</div>
								<small v-if="checkValidationError('unit_price')" class="text-muted">{{ validationErrors.unit_price[0] }}</small>
								<small v-if="checkValidationError('unit_currency')" class="text-muted">{{ validationErrors.unit_currency[0] }}</small>
							</div>
						</div>

                    <div class="form-group row" :class="{'form-group-error' : (checkValidationError('units'))}">
						<label class="col-sm-2 form-control-label">Units</label>
						<div class="col-sm-10">
							<input type="text" name="units" class="form-control" v-model="units">
							<small v-if="checkValidationError('units')" class="text-muted">{{ validationErrors.units[0] }}</small>
						</div>
					</div>

					<div v-show="photos.length > 0">
						<hr>
						<div class="col-md-12">
							<photo-list :data="photos" :object-id="id"
										:can-delete="true" :photos-url="'globalproducts/photos'">
							</photo-list>
						</div>
					</div>
					<div class="col-md-12">
	            		<dropzone :url="dropzoneUrl"></dropzone>
					</div>

                </div><!-- End Edit Global Product -->

			</div>
        </div>
      <div class="modal-footer">
		<span style="float: left;" v-if="isFocus(3)">
			<button class="btn btn-danger" type="button" @click="destroy">
				<i class="font-icon font-icon-close-2"></i>&nbsp;&nbsp;&nbsp;Delete</button>
		</span>

        <button v-if="!isFocus(4)" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button v-if="!isFocus(2)" class="btn btn-warning" type="button" @click="goBack">
			<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back</button>
        <button v-if="isFocus(1)" class="btn btn-success" type="button" @click="create">
			<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Add Global Product</button>
		<button v-if="isFocus(3)" type="button" class="btn btn-primary" @click="changeFocus(4)">
			<i class="font-icon font-icon-pencil"></i>&nbsp;&nbsp;&nbsp;Edit</button>
        <button v-if="isFocus(4)" class="btn btn-success" type="button" @click="update">
			<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Update</button>
      </div>
    </div>
  </div>
</div>


</template>

<script>
import alert from './alert.vue';
import photoList from './photoList.vue';
import dropzone from './dropzone.vue';
import BootstrapTable from './BootstrapTable.vue';

var Spinner = require("spin");

export default {
    props: ['currencies'],
    components:{
        alert,
        photoList,
        dropzone,
        BootstrapTable
    },
    data() {
        return {
            focus: 2, // 1=create, 2=list, 3=show, 4=edit
            validationErrors: {},

            id: 0,
            name: null,
            type: null,
            brand: null,
            units: null,
            price: null,
            currency: null,

			showName: null,
            showType: null,
            showBrand: null,
            showPrice: null,
            showPrice: null,

            photos: {},

            // alert
			alertMessageCreate: '',
			alertMessageList: '',
			alertMessageShow: '',
			alertMessageEdit: '',
			alertActiveCreate: false,
			alertActiveList: false,
			alertActiveShow: false,
			alertActiveEdit: false,

		    data: [],
            columns: [
		    {
		        field: 'id',
		        title: '#',
				sortable: true,
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
		        field: 'type',
		        title: 'Type',
				sortable: true,
			},
			{
		        field: 'price',
		        title: 'Price',
				sortable: true,
		    }
		    ],
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
		    }
        }
    },
    computed: {
        modalTitle(){
            switch (this.focus){
                case 1:
                    return 'Add Global Product';
                    break;
                case 2:
                    return 'Global Product List';
                    break;
                case 3:
                    return this.name;
                    break;
                case 4:
                    return 'Edit Global Product';
                    break;
                default:
                    return 'Global Product';
            }
        },
		dropzoneUrl(){
			return 'globalproducts/photos/'+this.id;
		}
    },
    events: {
		rowClicked(id){
			this.id = id;
			this.getValues(id, true);
		},
		photoUploaded(){
			this.getValues(this.id);
		}
	},
    methods: {
        getList(){
            this.$http.get(Laravel.url+'globalproducts').then((response) => {
				this.data = response.data.data;
				this.validationErrors = {};
				this.$broadcast('refreshTable');
            }, (response) => {
				this.focus = 2;
				this.alertMessageList = "The information could not be retrieved, please try again."
				this.alertActiveList = true;
            });
        },
        getValues(id, changeFocus = false){
			this.$http.get(Laravel.url+'globalproducts/'+id).then((response) => {
				let data = response.data.data;

				this.name = data.name;
		        this.type = data.type;
		        this.brand = data.brand;
		        this.price = data.unit_price;
		        this.currency = data.unit_currency;
		        this.units = data.units;

				this.showName = data.name;
		        this.showType = data.type;
		        this.showBrand = data.brand;
		        this.showPrice = data.price;

		        this.photos = data.photos;

				if(changeFocus){
					this.changeFocus(3);
				}
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

			this.$http.post(Laravel.url+'globalproducts', {
				name: this.name,
		        brand: this.brand,
		        type: this.type,
		        units: this.units,
                unit_price: this.price,
                unit_currency: this.currency,
            }).then((response) => {
                this.changeFocus(2);
				this.getList();
            }, (response) => {
				if(response.status == 422){
					this.validationErrors = response.data;
					this.revertButton(clickEvent, buttonTag);
				}else{
					this.alertMessageCreate = "The globalproduct could not be created, please try again.";
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

            this.$http.patch(Laravel.url+'globalproducts/'+this.id, {
				name: this.name,
		        brand: this.brand,
		        type: this.type,
		        units: this.units,
                unit_price: this.price,
                unit_currency: this.currency,
            }).then((response) => {
				// refresh the information
				this.getValues(this.id, true);
            }, (response) => {
				if(response.status == 422){
					this.validationErrors = response.data;
					this.revertButton(clickEvent, buttonTag);
				}else{
					this.alertMessageEdit = "The globalproducts could not be updated, please try again.";
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
                text: "Global Product is going to permanently deleted!",
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

            this.$http.delete(Laravel.url+'globalproducts/'+this.id).then((response) => {
				this.clean();
				this.changeFocus(2);
            }, (response) => {
				this.alertMessageShow = "The globalproduct could not be destroyed, please try again.";
				this.alertActiveShow = true;
				this.revertButton(clickEvent, buttonTag);
            });
		},
		goToCreate(){
			this.clean();
			this.changeFocus(1);
		},
        clean(){
            this.name = '';
            this.type = '';
            this.brand = '';
            this.price = '';
            this.currency = '';
            this.units = '';

			this.showName = '';
            this.showType = '';
            this.showBrand = '';
            this.showModel = '';
            this.showPrice = '';

			this.photos = {};

            this.validationErrors = {};
        },
        changeFocus(num){
			if(num == 2){
				this.getList();
			}
            this.focus = num;
        },
		goBack(){
			switch (this.focus){
                case 1:
					this.changeFocus(2);
                	break;
                case 3:
					this.changeFocus(2);
	                break;
                case 4:
					this.changeFocus(3);
	                break;
            }
		},
		resetAlert(alert){
			if(alert == 'create'){
				this.alertMessageCreate = "";
				this.alertActiveCreate = false;
			}else if(alert == 'list'){
				this.alertMessageList = "";
				this.alertActiveList = false;
			}else if(alert == 'show'){
				this.alertMessageShow = "";
				this.alertActiveShow = false;
			}else if(alert == 'edit'){
				this.alertMessageEdit = "";
				this.alertActiveEdit = false;
			}
		},
        isFocus(num){
            return this.focus == num;
        },
        checkValidationError($fildName){
            return $fildName in this.validationErrors;
        },
		revertButton(clickEvent, buttonTag){
			// enable, remove spinner and set tab to the one before
			clickEvent.target.disabled = false;
			clickEvent.target.innerHTML = buttonTag;
		}
    },
    ready() {
        this.getList();
    }
}
</script>
