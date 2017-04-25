<template>

	<bootstrap-table :columns="columns" :data="data" :options="tableOptions">
	    <alert type="danger" :message="alertMessage" :active="alertActive"></alert>
    </bootstrap-table>

</template>

<script>
import alert from './alert.vue';
import BootstrapTable from './BootstrapTable.vue';

export default {
    props: ['tableUrl'],
    components:{
        alert,
        BootstrapTable
    },
    data() {
        return {
            // alert
			alertMessage: '',
			alertActive: false,

		    data: [],
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
		    },
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
    		        field: 'email',
    		        title: 'Email',
    				sortable: true,
    			},
    			{
    		        field: 'role',
    		        title: 'Role',
    				sortable: true,
                },
    			{
    		        field: 'type',
    		        title: 'Type',
    				sortable: true,
                },
                {
    		        field: 'language',
    		        title: 'Language',
    				sortable: true,
                },
		    ],
        }
    },
    events: {
		rowClicked(id){
            this.$dispatch('newChat', id);
			this.$broadcast('refreshTable');
		}
	},
    methods: {
        getList(finished){
			let listUrl = Laravel.url+'datatables/urc';
			this.$broadcast('disableTable');
            this.$http.get(listUrl).then((response) => {
				this.data = response.data;
				this.validationErrors = {};
				this.$broadcast('refreshTable');
            }, (response) => {
				this.alertMessage = "The information could not be retrieved, please try again."
				this.alertActive = true;
			    this.$broadcast('enableTable');
            });
        }
    },
    ready(){
        this.getList();
    }
}
</script>
