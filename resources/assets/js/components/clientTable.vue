<template>

	<index-table
        :columns="columns"
        :button="{ icon: 'font-icon font-icon-user', name: 'New Client' }"
        click-url="clients/"
        table-url="datatables/clients">
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
    		        field: 'type',
    		        title: 'Type',
    				sortable: true,
                },
    			{
    		        field: 'cellphone',
    		        title: 'Cellphone',
    				sortable: true,
                },
		    ],
        }
    }
}
</script>
