<template>

	<index-table
        :columns="columns"
        :button="{ icon: 'glyphicon glyphicon-wrench', name: 'New Technician' }"
        :toolbar-switch="{ checked: true, name: 'Active' }"
        click-url="technicians/"
        table-url="datatables/technicians?status=">
    </index-table>

</template>

<script>
import indexTable from './indexTable.vue';

export default {
    components:{
        indexTable
    },
    data() {
        return {
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
    		        field: 'username',
    		        title: 'Username',
    				sortable: true,
    			},
    			{
    		        field: 'cellphone',
    		        title: 'Cellphone',
    				sortable: true,
                },
                {
    		        field: 'supervisor',
    		        title: 'Supervisor',
    				sortable: true,
                }
		    ],
        }
    }
}
</script>
