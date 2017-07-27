<template>
	<index-table
        :columns="columns"
        :button="{ icon: 'font-icon font-icon-home', label: 'New Service' }"
		:toggle="{ checked: true, label: 'Active Contract'}"
		:highlight-columns="['id', 'name', 'address', 'price']"
        data-url="datatables/services"
        actions-url="services">
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
                    // sortField: 'price',
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
