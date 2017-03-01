<template>

<!-- Button -->
<button type="button" class="btn btn-primary" @click="clickButton">
	<i class="glyphicon glyphicon-hdd"></i>&nbsp;&nbsp;&nbsp;Manage Equipment
</button>

<modal title="Equipment" id="equipmentModal" :modal-class="{'modal-lg' : (focus == 2)}">

    <!-- List -->
	<div class="col-md-12" v-show="isFocus(2)">

		<alert type="danger" :message="alertMessageList" :active="alertActiveList"></alert>

		<bootstrap-table :columns="columns" :data="data" :options="options"></bootstrap-table>

	</div>


    <!-- Show Equipment -->
	<div class="col-md-12" v-show="isFocus(3)">

		<div class="form-group row">
			<label class="col-sm-2 form-control-label">Type</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control" value="{{ type }}">
			</div>
		</div>
        <div class="form-group row">
			<label class="col-sm-2 form-control-label">Brand</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control" value="{{ brand }}">
			</div>
		</div>
        <div class="form-group row">
			<label class="col-sm-2 form-control-label">Model</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control" value="{{ model }}">
			</div>
		</div>
        <div class="form-group row">
			<label class="col-sm-2 form-control-label">Capacity</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control" value="{{ capacity }}">
			</div>
		</div>
		<br>

		<div v-show="photos.length > 0">
			<h5>Photos</h5>
			<photo-list :data="photos" :object-id="id"
						:can-delete="false" :photos-url="'equipment/photos'">
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
	props: {
        serviceId: {
            required: true
        },
    },
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
            kind: null,
            type: null,
            brand: null,
            model: null,
            capacity: null,

            photos: {},

            // alert
			alertMessageList: '',
			alertActiveList: false,

		    data: [],
            columns: [
		    {
		        field: 'id',
				visible: false,
		    },
		    {
		        field: 'kind',
		        title: 'Kind',
				sortable: true,
		    },
			{
		        field: 'type',
		        title: 'Type',
				sortable: true,
			},
			{
		        field: 'brand',
		        title: 'Brand',
				sortable: true,
            },
			{
		        field: 'model',
		        title: 'Model',
				sortable: true,
            },
			{
		        field: 'capacity',
		        title: 'Capacity',
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
	events: {
		rowClicked(id){
			this.id = id;
			this.getValues(id, true);
		},
	},
    methods: {
		clickButton(){
			this.$broadcast('openModal', 'equipmentModal');
			this.getList();
		},
        getList(){
			this.resetAlert();
            this.$http.get(Laravel.url+'service/'+this.serviceId+'/equipment').then((response) => {
				this.data = response.data;
				this.$broadcast('refreshTable');
            }, (response) => {
				this.focus = 2;
				this.alertMessageList = "The information could not be retrieved, please try again."
				this.alertActiveList = true;
            });
        },
		getValues(id){
			this.resetAlert();
			this.$http.get(Laravel.url+'equipment/'+id).then((response) => {
				let data = response.data;
				this.kind = data.kind;
		        this.type = data.type;
		        this.brand = data.brand;
		        this.model = data.model;
		        this.capacity  = data.capacity+' '+data.units;
		        this.photos = data.photos;
				this.focus = 3;
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
