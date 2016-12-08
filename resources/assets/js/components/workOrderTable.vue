<template>

	<bootstrap-table :object-id.sync="id" :columns="columns" :data="data" :options="options">

	    <alert type="danger" :message="alertMessage" :active="alertActive"></alert>

        <button type="button" class="btn btn-primary" @click="goToCreate" >
			<i class="glyphicon glyphicon-briefcase"></i>&nbsp;&nbsp;&nbsp;Add Work Order
		</button>

        <div class="checkbox-toggle" style="display:inline;left:30px;" >
			<input type="checkbox" id="toolbarSwitch" v-model="finished"
					@click="getList(finished)">
			<label for="toolbarSwitch">Finished</label>
		</div>

    </bootstrap-table>

</template>

<script>
import alert from './alert.vue';
import BootstrapTable from './BootstrapTable.vue';

export default {
    components:{
        alert,
        BootstrapTable
    },
    data() {
        return {
            id: 0,
            finished: false,

            // alert
			alertMessage: '',
			alertActive: false,

		    data: [],
            columns: [
		    {
		        field: 'id',
		        title: '#',
				sortable: true,
		    },
		    {
		        field: 'service',
		        title: 'Service',
				sortable: true,
		    },
			{
		        field: 'supervisor',
		        title: 'Supervisor',
				sortable: true,
			},
			{
		        field: 'start',
		        title: 'Start at',
				sortable: true,
            },
			{
		        field: 'end',
		        title: 'End at',
				sortable: true,
            },
			{
		        field: 'price',
		        title: 'Price',
				sortable: true,
				visible: true,
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
				pageSize: 10,
				pageList: [5, 10, 20],
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
		rowClicked(){
			window.location = Laravel.url+'workorders/'+this.id;
		}
	},
    methods: {
        getList(finished){
			this.$broadcast('disableTable');
            this.$http.get(Laravel.url+'datatables/workorders?finished='+(finished ? 0 : 1)).then((response) => {
				this.data = response.data;
				this.validationErrors = {};
				this.$broadcast('refreshTable');
			    this.$broadcast('enableTable');
            }, (response) => {
				this.alertMessage = "The information could not be retrieved, please try again."
				this.alertActive = true;
			    this.$broadcast('enableTable');
            });
        },
        goToCreate(){
			window.location = Laravel.url+'workorders/create';
        },
    },
    ready(){
        this.getList(!this.finished);
        this.getList(!this.finished);
    }
}
</script>
