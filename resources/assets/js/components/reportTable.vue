<template>

	<bootstrap-table :columns="columns" :data="data" :options="tableOptions">
	    <alert type="danger" :message="alertMessage" :active="alertActive"></alert>

        <button type="button" class="btn btn-primary" @click="goToCreate" >
			<i class="font-icon font-icon-page"></i>&nbsp;&nbsp;&nbsp;New Report
		</button>
		<missing-services>
		</missing-services>
    </bootstrap-table>

</template>

<script>
import alert from './alert.vue';
import BootstrapTable from './BootstrapTable.vue';
import missingServices from './missingServices.vue';

export default {
    props: [],
    components:{
        alert,
        missingServices,
        BootstrapTable
    },
    data() {
        return {
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
    		        field: 'on_time',
    		        title: 'On Time',
    				sortable: true,
    			},
    			{
    		        field: 'technician',
    		        title: 'Technician',
    				sortable: true,
                }
		    ],
		    tableOptions: {
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
		rowClicked(id){
			window.location = Laravel.url+'reports/'+id;
		},
        datePickerClicked(date){
            this.getList(date);
            this.$broadcast('datePickerClicked', date);
        }
	},
    methods: {
        getList(date){
            this.$dispatch('disableDatePicker', true);
	        let listUrl = Laravel.url+'datatables/reports';
            if(date){
	            listUrl = Laravel.url+'datatables/reports?date='+date;
            }
			this.$broadcast('disableTable');
            this.$http.get(listUrl).then((response) => {
				this.data = response.data;
				this.validationErrors = {};
				this.$broadcast('refreshTable');
                this.$dispatch('disableDatePicker', false);
            }, (response) => {
				this.alertMessage = "The information could not be retrieved, please try again."
				this.alertActive = true;
			    this.$broadcast('enableTable');
                this.$dispatch('disableDatePicker', false);
            });
        },
        goToCreate(){
			window.location = Laravel.url+'reports/create';
        },
    },
    ready(){
        this.getList();
        this.getList();
    }
}
</script>
