<template>
	<index-table
        :columns="columns"
        :button="{ icon: 'glyphicon glyphicon-wrench', label: 'New Technician' }"
		:toggle="{ checked: true, label: 'Paid'}"
		:highlight-columns="['name', 'email', 'cellphone']"
        data-url="datatables/technicians"
        actions-url="technicians">
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
                    name: 'email',
                    sortField: 'email',
                },
				{
                    name: 'cellphone',
                    sortField: 'cellphone',
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
