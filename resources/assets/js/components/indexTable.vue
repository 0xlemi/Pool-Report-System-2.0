<template>

	<bootstrap-table :columns="columns" :data="data" :options="tableOptions">

	    <alert type="danger" :message="alertMessage" :active="alertActive"></alert>

        <button v-if="button" type="button" class="btn btn-primary" @click="goToCreate" >
			<i :class="button.icon"></i>&nbsp;&nbsp;&nbsp;{{ button.name }}
		</button>

        <div v-if="toolbarSwitch" class="checkbox-toggle" style="display:inline;left:30px;" >
			<input type="checkbox" id="toolbarSwitch" v-model="toolbarSwitch.checked"
					@click="getList(!toolbarSwitch.checked)">
			<label for="toolbarSwitch">{{ toolbarSwitch.name }}</label>
		</div>

    </bootstrap-table>

</template>

<script>
import alert from './alert.vue';
import BootstrapTable from './BootstrapTable.vue';

export default {
    props: [ 'columns', 'button', 'toolbarSwitch', 'clickUrl', 'tableUrl'],
    components:{
        alert,
        BootstrapTable
    },
    data() {
        return {
            // alert
			alertMessage: '',
			alertActive: false,

		    data: [],
		    tableOptions: {
				iconsPrefix: 'font-icon',
		        toggle:'table',
		        sidePagination:'client',
		        pagination:'true',
				classes: 'table',
				icons: {
					paginationSwitchDown:'font-icon-arrow-square-down',
					paginationSwitchUp: 'font-icon-arrow-square-down up',
					refresh: 'font-icon-refresh',
					toggle: 'font-icon-list-square',
					columns: 'font-icon-list-rotate',
					export: 'font-icon-download'
				},
				paginationPreText: '<i class="font-icon font-icon-arrow-left"></i>',
				paginationNextText: '<i class="font-icon font-icon-arrow-right"></i>',
				pageSize: 10,
				pageList: [5, 10, 20],
				search: true,
				showExport: true,
				exportTypes: ['excel', 'pdf'],
				minimumCountColumns: 2,
				showFooter: false,

				uniqueId: 'id',
				idField: 'id',
		    }
        }
    },
    events: {
		rowClicked(id){
			window.location = Laravel.url+this.clickUrl+id;
		}
	},
    methods: {
        getList(finished){
			let listUrl = Laravel.url+this.tableUrl;
			if(this.toolbarSwitch){
				listUrl = Laravel.url+this.tableUrl+(finished ? 1 : 0);
			}
			this.$broadcast('disableTable');
            this.$http.get(listUrl).then((response) => {
				this.data = response.data;
				this.validationErrors = {};
				this.$broadcast('refreshTable');
            }, (response) => {
				this.alertMessage = "The information could not be retrieved, please try again."
				this.alertActive = true;
			    this.$broadcast('enableTable');
            });
        },
        goToCreate(){
			window.location = Laravel.url+this.clickUrl+'create';
        },
    },
    ready(){
		if(this.toolbarSwitch){
	        this.getList(this.toolbarSwitch.checked);
	        this.getList(this.toolbarSwitch.checked);
		}else{
	        this.getList();
	        this.getList();
		}
    }
}
</script>
