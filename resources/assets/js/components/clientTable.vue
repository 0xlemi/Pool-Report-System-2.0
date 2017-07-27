<template>
	<index-table
        :columns="columns"
        :button="{ icon: 'glyphicon glyphicon-user', label: 'New Client' }"
		:highlight-columns="['id', 'name', 'email', 'cellphone']"
        data-url="datatables/clients"
        actions-url="clients">
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
                    name: 'type',
                    sortField: 'type',
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
