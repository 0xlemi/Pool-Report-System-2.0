<template>

	<index-table
        :columns="columns"
        :toolbar-switch="{ checked: true, name: 'Active Contract' }"
        click-url="service/"
        table-url="service/table?contract=">
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
    		        field: 'address',
    		        title: 'Address',
    				sortable: true,
    			},
    			{
    		        field: 'serviceDays',
    		        title: 'Service Days',
    				sortable: true,
                },
    			{
    		        field: 'chemicals',
    		        title: 'Chemicals',
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
