<template>
	<index-table
        :columns="columns"
		:toggle="{ checked: true, label: 'Active Contract'}"
		:highlight-columns="['id', 'name', 'address']"
        data-url="service/table"
        actions-url="service">
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
                    name: 'name',
                    sortField: 'name',
                },
				{
                    name: 'address',
                    sortField: 'address_line',
                },
				{
                    name: 'service_days',
                    title: 'Service Days',
                },
				{
                    name: 'price',
                    sortField: 'price',
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
