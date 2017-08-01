<template>
	<index-table
        :columns="columns"
		:toggle="{ checked: false, label: 'Closed'}"
		:highlight-columns="['id', 'amount', 'closed']"
        data-url="invoice/table"
        actions-url="invoice">
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
                    name: 'id',
                    sortField: 'seq_id',
                    title: '#'
                },
                {
                    name: 'service',
                    // sortField: 'service',
                },
				{
                    name: 'type',
                    sortField: 'invoiceable_type',
                },
				{
                    name: 'amount',
                    sortField: 'amount',
                },
				{
                    name: 'closed',
                    sortField: 'closed',
                },
				{
			        name: '__actions',
			        title: '',
			        titleClass: 'text-center',
			        dataClass: 'text-center',
			    }
			],
        }
    }
}
</script>
