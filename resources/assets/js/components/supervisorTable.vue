<template>
	<index-table
        :columns="columns"
        :button="{ icon: 'font-icon font-icon-eye', label: 'New Supervisor' }"
		:toggle="{ checked: true, label: 'Paid'}"
		:highlight-columns="['name', 'email', 'cellphone']"
        data-url="datatables/supervisors"
        actions-url="supervisors">
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
