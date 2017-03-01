<template>

<!-- Button -->
<button type="button" class="btn btn-primary" @click="clickButton">
	<i class="fa fa-suitcase"></i>&nbsp;&nbsp;&nbsp;Manage Works
</button>

<modal title="Works" id="worksModal" :modal-class="{'modal-lg' : (focus == 2)}">

    <!-- List Work  -->
    <div class="col-md-12" v-show="isFocus(2)">

		<alert type="danger" :message="alertMessageList" :active="alertActiveList"></alert>

		<bootstrap-table :columns="columns" :data="data" :options="options"></bootstrap-table>

    </div>

    <!-- Show Work -->
    <div class="col-md-12" v-show="isFocus(3)">

		<div class="form-group row">
			<label class="col-sm-2 form-control-label">Title</label>
			<div class="col-sm-10">
				<input type="text" name="title" readonly class="form-control" v-model="title">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label">Technician</label>
			<div class="col-sm-10">
				<input type="text" name="coste" readonly class="form-control" style="text-indent: 40px;"
					v-model="technician.fullName">
            	<img class="iconOption" :src="technician.icon" alt="Technician Photo">
			</div>
		</div>

        <div class="form-group row">
			<label class="col-sm-2 form-control-label">Quantity</label>
			<div class="col-sm-10">
				<input type="text" name="quantity" readonly class="form-control" v-model="quantity">
			</div>
		</div>

        <div class="form-group row">
			<label class="col-sm-2 form-control-label">Units</label>
			<div class="col-sm-10">
				<input type="text" name="units" readonly class="form-control" v-model="units">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label">Description</label>
			<div class="col-sm-10">
				<textarea rows="4" class="form-control"
						v-model="description" readonly placeholder="Describe the work done">
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


	<button slot="buttonsBefore" v-if="!isFocus(2)" class="btn btn-warning" type="button" @click="goBack">
		<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back
	</button>

</modal>

</template>

<script>
import modal from './modal.vue';
import alert from './alert.vue';
import photoList from './photoList.vue';
import BootstrapTable from './BootstrapTable.vue';

export default {
	props: ['workOrderId'],
	components:{
        modal,
        alert,
        photoList,
        BootstrapTable
    },
    data(){
        return {
            focus: 2, //  2=list, 3=show

            id: 0,
            title : '',
			technician: {},
			quantity: '',
			units: '',
			cost: '',
			description: '',

            photos: {},

            // alert
			alertMessageList: '',
			alertActiveList: false,

		    data: [],
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
		    }
        }
    },
	events: {
		rowClicked(id){
			this.id = id;
			this.getValues(id, true);
		},
	},
    methods: {
		clickButton(){
			this.$broadcast('openModal', 'worksModal');
			this.getList();
		},
        getList(){
			this.resetAlert();
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
		getValues(id){
			this.$http.get(Laravel.url+'/works/'+id).then((response) => {
				let data = response.data;

				this.title = data.title;
				this.quantity = data.quantity;
				this.units = data.units;
				this.cost = data.cost;
				this.description = data.description;
				this.technician = data.technician;

				this.photos = data.photos;

				this.changeFocus(3);
            }, (response) => {
				this.focus = 2;
				this.alertMessageList = "The information could not be retrieved, please try again.";
				this.alertActiveList = true;
            });
		},
        changeFocus(num){
			if(num == 2){
				this.getList();
			}
            this.focus = num;
        },
		goBack(){
			this.changeFocus(2);
		},
		resetAlert(){
			this.alertMessageList = "";
			this.alertActiveList = false;
		},
        isFocus(num){
            return this.focus == num;
        },
    },
    ready() {
        this.getList();
    }
}
</script>
