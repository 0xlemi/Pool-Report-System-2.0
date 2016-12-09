<template>

	<index-table
        :columns="columns"
        :button="{ icon: 'font-icon font-icon-eye', name: 'New Supervisor' }"
        :toolbar-switch="{ checked: true, name: 'Status' }"
        click-url="supervisors/"
        table-url="datatables/supervisors?status=">
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
    		        field: 'email',
    		        title: 'Email',
    				sortable: true,
    			},
    			{
    		        field: 'cellphone',
    		        title: 'Cellphone',
    				sortable: true,
                }
		    ],
        }
    }
}
</script>
