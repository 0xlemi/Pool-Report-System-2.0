<template>

	<index-table
        :columns="columns"
        :button="{ icon: 'font-icon font-icon-home', name: 'New Service' }"
        :toolbar-switch="{ checked: true, name: 'Active Contract' }"
        click-url="services/"
        table-url="datatables/services?status=">
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
    		        field: 'measurements',
    		        title: 'Measurements',
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
