<template>

	<div class="form-group row">
		<label class="col-sm-2 form-control-label">Works</label>
		<div class="col-sm-10">
			<button type="button" class="btn btn-primary" @click="getList"
					data-toggle="modal" data-target="#workModal">
				<i class="fa fa-suitcase"></i>&nbsp;&nbsp;&nbsp;Manage Works
			</button>
		</div>
	</div>

    <!-- Modal for Work preview -->
	<div class="modal fade" id="workModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" :class="{'modal-lg' : (focus == 2)}" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">{{ modalTitle }}</h4>
	      </div>
	      <div class="modal-body">
				<div class="row">

                    <!-- Create new Work -->
                    <div class="col-md-12" v-show="isFocus(1)">

						<alert type="danger" :message="alertMessageCreate" :active="alertActiveCreate"></alert>

						<div class="form-group row" :class="{'form-group-error' : (checkValidationError('title'))}">
							<label class="col-sm-2 form-control-label">Title</label>
							<div class="col-sm-10">
								<input type="text" name="title" class="form-control" v-model="titleName">
								<small v-if="checkValidationError('title')" class="text-muted">{{ validationErrors.title[0] }}</small>
							</div>
						</div>

                        <div class="form-group row" :class="{'form-group-error' : (checkValidationError('technician_id'))}">
							<label class="col-sm-2 form-control-label">Technician</label>
							<div class="col-sm-10">
								<dropdown :key.sync="technician.id"
										:options="technicians"
										:name="'technician'">
								</dropdown>
								<small v-if="checkValidationError('technician_id')" class="text-muted">{{ validationErrors.technician_id[0] }}</small>
							</div>
						</div>

                        <div class="form-group row" :class="{'form-group-error' : (checkValidationError('quantity'))}">
							<label class="col-sm-2 form-control-label">Quantity</label>
							<div class="col-sm-10">
								<input type="text" name="quantity" class="form-control" v-model="quantity">
								<small v-if="checkValidationError('quantity')" class="text-muted">{{ validationErrors.quantity[0] }}</small>
							</div>
						</div>

                        <div class="form-group row" :class="{'form-group-error' : (checkValidationError('units'))}">
							<label class="col-sm-2 form-control-label">Units</label>
							<div class="col-sm-10">
								<input type="text" name="units" class="form-control" v-model="units">
								<small v-if="checkValidationError('units')" class="text-muted">{{ validationErrors.units[0] }}</small>
							</div>
						</div>

                        <div class="form-group row" :class="{'form-group-error' : (checkValidationError('cost'))}">
							<label class="col-sm-2 form-control-label">Cost</label>
							<div class="col-sm-10">
								<div class="input-group">
									<div class="input-group-addon">$</div>
									<input type="text" name="coste" class="form-control" v-model="cost">
									<div class="input-group-addon">{{ currency }}</div>
								</div>
								<small v-if="checkValidationError('cost')" class="text-muted">{{ validationErrors.cost[0] }}</small>
							</div>

						</div>

						<div class="form-group row" :class="{'form-group-error' : (checkValidationError('description'))}">
							<label class="col-sm-2 form-control-label">Description</label>
							<div class="col-sm-10">
								<textarea rows="4" class="form-control"
										v-model="description" placeholder="Describe the work done">
								</textarea>
								<small v-if="checkValidationError('description')" class="text-muted">{{ validationErrors.description[0] }}</small>
							</div>
						</div>

                    </div>

                    <!-- Index Work -->
                    <div class="col-md-12" v-show="isFocus(2)">

						<alert type="danger" :message="alertMessageList" :active="alertActiveList"></alert>

						<bootstrap-table :object-id.sync="id" :columns="columns" :data="data" :options="options"></bootstrap-table>

                    </div>

                    <!-- Show Work -->
                    <div class="col-md-12" v-show="isFocus(3)">

						<alert type="danger" :message="alertMessageShow" :active="alertActiveShow"></alert>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Title</label>
							<div class="col-sm-10">
								<input type="text" name="title" readonly class="form-control" value="{{showTitleName}}">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Technician</label>
							<div class="col-sm-10">
								<input type="text" name="coste" readonly class="form-control" style="text-indent: 40px;"
									:value="showTechnician.fullName">
                            	<img class="iconOption" :src="showTechnician.icon" alt="Technician Photo">
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Quantity</label>
							<div class="col-sm-10">
								<input type="text" name="quantity" readonly class="form-control" value="{{showQuantity}}">
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Units</label>
							<div class="col-sm-10">
								<input type="text" name="units" readonly class="form-control" value="{{showUnits}}">
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Cost</label>
							<div class="col-sm-10">
								<input type="text" name="coste" readonly class="form-control" value="{{showCost+' '+currency}}">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Description</label>
							<div class="col-sm-10">
								<textarea rows="4" class="form-control"
										v-model="showDescription" readonly placeholder="Describe the work done">
								</textarea>
							</div>
						</div>

						<div v-show="photos.length > 0">
							<h5>Photos</h5>
							<photo-list :data="photos" :object-id="id"
										:can-delete="false" :photos-url="'works/photos'">
							</photo-list>
						</div>

                    </div>

					<!-- Edit Work -->
                    <div class="col-md-12" v-show="isFocus(4)">

						<alert type="danger" :message="alertMessageEdit" :active="alertActiveEdit"></alert>

						<div class="form-group row" :class="{'form-group-error' : (checkValidationError('title'))}">
							<label class="col-sm-2 form-control-label">Title</label>
							<div class="col-sm-10">
								<input type="text" name="title" class="form-control" v-model="titleName">
								<small v-if="checkValidationError('title')" class="text-muted">{{ validationErrors.title[0] }}</small>
							</div>
						</div>

                        <div class="form-group row" :class="{'form-group-error' : (checkValidationError('technician_id'))}">
							<label class="col-sm-2 form-control-label">Technician</label>
							<div class="col-sm-10">
								<dropdown :key.sync="technician.id"
										:options="technicians"
										:name="'technician'">
								</dropdown>
								<small v-if="checkValidationError('technician_id')" class="text-muted">{{ validationErrors.technician_id[0] }}</small>
							</div>
						</div>

                        <div class="form-group row" :class="{'form-group-error' : (checkValidationError('quantity'))}">
							<label class="col-sm-2 form-control-label">Quantity</label>
							<div class="col-sm-10">
								<input type="text" name="quantity" class="form-control" v-model="quantity">
								<small v-if="checkValidationError('quantity')" class="text-muted">{{ validationErrors.quantity[0] }}</small>
							</div>
						</div>

                        <div class="form-group row" :class="{'form-group-error' : (checkValidationError('units'))}">
							<label class="col-sm-2 form-control-label">Units</label>
							<div class="col-sm-10">
								<input type="text" name="units" class="form-control" v-model="units">
								<small v-if="checkValidationError('units')" class="text-muted">{{ validationErrors.units[0] }}</small>
							</div>
						</div>

                        <div class="form-group row" :class="{'form-group-error' : (checkValidationError('cost'))}">
							<label class="col-sm-2 form-control-label">Cost</label>
							<div class="col-sm-10">
								<div class="input-group">
									<div class="input-group-addon">$</div>
									<input type="text" name="coste" class="form-control" v-model="cost">
									<div class="input-group-addon">{{ currency }}</div>
								</div>
								<small v-if="checkValidationError('cost')" class="text-muted">{{ validationErrors.cost[0] }}</small>
							</div>

						</div>

						<div class="form-group row" :class="{'form-group-error' : (checkValidationError('description'))}">
							<label class="col-sm-2 form-control-label">Description</label>
							<div class="col-sm-10">
								<textarea rows="4" class="form-control"
										v-model="description" placeholder="Describe the work done">
								</textarea>
								<small v-if="checkValidationError('description')" class="text-muted">{{ validationErrors.description[0] }}</small>
							</div>
						</div>

						<div v-show="photos.length > 0">
							<hr>
							<div class="col-md-12">
								<photo-list :data="photos" :object-id="id"
											:can-delete="true" :photos-url="'works/photos'">
								</photo-list>
							</div>
						</div>
						<div class="col-md-12">
		            		<dropzone :url="dropzoneUrl"><dropzone>
						</div>

                    </div>

				</div>
	      </div>
	      <div class="modal-footer">
			<span style="float: left;" v-if="isFocus(3)">
				<button type="button" class="btn btn-danger" @click="destroy">
					<i class="font-icon font-icon-close-2"></i>&nbsp;&nbsp;&nbsp;Destroy
				</button>
			</span>

	        <button type="button" class="btn btn-default" data-dismiss="modal" v-if="!isFocus(4)">Close</button>

			<button type="button" class="btn btn-warning" v-if="!isFocus(2)" @click="goBack">
				<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back
			</button>

            <button type="button" class="btn btn-primary" v-if="isFocus(1)" @click="create">
				Create
			</button>

			<button type="button" class="btn btn-primary" v-if="isFocus(3)" @click="changeFocus(4)">
				<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Edit
			</button>

            <button type="button" class="btn btn-success" v-if="isFocus(4)" @click="update">
				<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Update
			</button>

	      </div>
	    </div>
	  </div>
	</div>


</template>

<script>
import alert from './alert.vue';
import photoList from './photoList.vue';
import dropzone from './dropzone.vue';
import dropdown from './dropdown.vue';
import BootstrapTable from './BootstrapTable.vue';

var Spinner = require("spin");

  export default {
    props: ['workOrderId', 'technicians'],
	components: {
		alert,
		photoList,
		dropzone,
		dropdown,
		BootstrapTable
	},
    data () {
        return {
            focus: 2, // 1=create, 2=index, 3=show, 4=edit
            id: 0,
            validationErrors: {},
			currency: '',

			// alert
			alertMessageCreate: '',
			alertMessageList: '',
			alertMessageShow: '',
			alertMessageEdit: '',
			alertActiveCreate: false,
			alertActiveList: false,
			alertActiveShow: false,
			alertActiveEdit: false,

			titleName : '',
			technician: {},
			quantity: '',
			units: '',
			cost: '',
			description: '',

			showTitleName : '',
			showTechnician: {},
			showQuantity: '',
			showUnits: '',
			showCost: '',
			showDescription: '',

            photos: {},

			columns: [
		      {
		        title: 'ID',
		        field: 'id',
				sortable: true,
				visible: false,
		      },
		      {
		        field: 'title',
		        title: 'Title',
				sortable: true,
		      },
			  {
		        field: 'quantity',
		        title: 'Quantity',
				sortable: true,
			  },
			  {
		        field: 'cost',
		        title: 'Cost',
				sortable: true,
			  },
			  {
		        field: 'technician',
		        title: 'Technician',
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
				toolbarButtonText: 'Add Work',
		    }
        }
    },
    computed: {
		modalTitle: function(){
            switch (this.focus){
                case 1:
                	return 'New Work';
                	break;
                case 2:
                	return 'Works List';
                	break;
                case 3:
	                return 'View Work';
	                break;
                case 4:
	                return 'Edit Work';
	                break;
                default:
                	return 'Works';
            }
        },
		dropzoneUrl(){
			return 'works/photos/'+this.id;
		}
    },
	events: {
		toolbarButtonClicked(){
			this.clean();
			this.changeFocus(1);
		},
		rowClicked(){
			this.getValues(this.id, true);
		},
		photoUploaded(){
			this.getValues(this.id);
		}
	},
    methods: {
        getList(){
			this.resetAlert('list');
			this.$http.get(Laravel.url+'/service/'+this.workOrderId+'/works').then((response) => {
				let data = response.data;
				this.data = data.list;
				this.currency = data.currency;
				this.validationErrors = {};
				this.$broadcast('refreshTable');
            }, (response) => {
				this.focus = 2;
				this.alertMessageList = "The information could not be retrieved, please try again.";
				this.alertActiveList = true;
            });
        },
		getValues(id, changeFocus = false){
			this.$http.get(Laravel.url+'/works/'+id).then((response) => {
				let data = response.data;
				this.titleName = data.title;
				this.quantity = data.quantity;
				this.units = data.units;
				this.cost = data.cost;
				this.description = data.description;
				this.technician = data.technician;

				this.showTitleName = data.title;
				this.showQuantity = data.quantity;
				this.showUnits = data.units;
				this.showCost = data.cost;
				this.showDescription = data.description;
				this.showTechnician = data.technician;

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

			this.$http.post(Laravel.url+'/service/'+this.workOrderId+'/works', {
				title : this.titleName,
				technician_id: this.technician.id,
				quantity: this.quantity,
				units: this.units,
				cost: this.cost,
				description: this.description,
            }).then((response) => {
                this.changeFocus(2);
				this.getList();
            }, (response) => {
				if(response.status == 422){
					this.validationErrors = response.data;
					this.revertButton(clickEvent, buttonTag);
				}else{
					this.alertMessageCreate = "The work could not be created, please try again.";
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

            this.$http.patch(Laravel.url+'/works/'+this.id, {
        		title : this.titleName,
				technician_id: this.technician.id,
				quantity: this.quantity,
				units: this.units,
				cost: this.cost,
				description: this.description,
            }).then((response) => {
				// refresh the information
				this.getValues(this.id, true);
            }, (response) => {
				if(response.status == 422){
					this.validationErrors = response.data;
					this.revertButton(clickEvent, buttonTag);
				}else{
					this.alertMessageEdit = "The work could not be updated, please try again.";
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
                text: "Work is going to permanently deleted!",
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

            this.$http.delete(Laravel.url+'/works/'+this.id).then((response) => {
				// clear values
				this.changeFocus(2);
            }, (response) => {
				this.alertMessageShow = "The work could not be destroyed, please try again.";
				this.alertActiveShow = true;
				this.revertButton(clickEvent, buttonTag);
            });
		},
        checkValidationError($fildName){
            return $fildName in this.validationErrors;
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
                default:
                	return 'Works';
            }
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

			this.titleName = '';
			this.technician = {};
			this.quantity = '';
			this.units = '';
			this.cost = '';
			this.description = '';
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
