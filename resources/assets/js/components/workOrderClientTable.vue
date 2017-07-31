<template>
	<index-table
        :columns="columns"
		:toggle="{ checked: false, label: 'Finished'}"
		:highlight-columns="['id', 'title', 'service', 'person', 'start', 'end', 'price']"
        data-url="workorder/table"
        actions-url="workorder">
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
                    name: 'title',
                    sortField: 'title',
                },
                {
                    name: 'service',
                    sortField: 'service_name',
                },
				{
                    name: 'person',
                    sortField: 'person_name',
                },
				{
                    name: 'start',
                    sortField: 'start',
                },
				{
                    name: 'end',
                    sortField: 'end',
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
