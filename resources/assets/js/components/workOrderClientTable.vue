<template>

	<index-table
        :columns="columns"
        :toolbar-switch="{ checked: false, name: 'Finished' }"
        click-url="workorder/"
        table-url="workorder/table?finished=">
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
        }
    }
}
</script>
