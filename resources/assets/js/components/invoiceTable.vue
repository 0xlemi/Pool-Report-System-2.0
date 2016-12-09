<template>

	<index-table
        :columns="columns"
        :toolbar-switch="{ checked: false, name: 'Closed' }"
        click-url="invoices/"
        table-url="datatables/invoices?closed=">
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
    		        field: 'service',
    		        title: 'Service',
    				sortable: true,
    		    },
    			{
    		        field: 'type',
    		        title: 'Type',
    				sortable: true,
    			},
    			{
    		        field: 'amount',
    		        title: 'Amount',
    				sortable: true,
                },
    			{
    		        field: 'closed',
    		        title: 'Closed',
    				sortable: true,
                }
		    ],
        }
    }
}
</script>
