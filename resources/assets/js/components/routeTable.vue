<template>
    <div>
    	<bootstrap-table :object-id.sync="serviceId" :button-value.sync="buttonValue"
                            :columns="columns" :data="data" :options="options">
        </bootstrap-table>
    </div>
</template>

<script>

var alert = require('./alert.vue');
var BootstrapTable = require('./BootstrapTable.vue');

  export default {
    props: ['url', 'clickUrl'],
    components: {
        alert,
        BootstrapTable
    },
    data () {
        return {
            serviceId: 0,
            buttonValue: 0,

            columns: [
                {
                    title: '#',
                    field: 'id',
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
                    field: 'type',
                    title: 'type',
                    sortable: true,
                },
                {
                    field: 'endTime',
                    title: 'Do before',
                    sortable: true,
                },
                {
                    field: 'price',
                    title: 'Price',
                    sortable: true,
                }
		    ],
		    data: [],
		    options: {
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

                toolbarGroupButtons: (back.buttons) ? back.buttons : {},
		    }
        }
    },
    watch: {
        buttonValue: function(val){
            this.getList(val);
        },
        serviceId: function(val){
            window.location = this.clickUrl+this.serviceId;
        }
    },
    methods: {
        getList(val){
			this.resetAlert();
			this.$broadcast('disableTable');

			this.$http.get(this.url, {
                daysFromToday: val
            }).then((response) => {
				let data = response.data;
				this.data = data.list;
				this.validationErrors = {};
				this.$broadcast('refreshTable');
			    this.$broadcast('enableTable');
            }, (response) => {
				this.alertMessageList = "The information could not be retrieved, please try again.";
				this.alertActiveList = true;
			    this.$broadcast('enableTable');
            });
        },
        resetAlert(){
			this.alertMessageList = ""
			this.alertActiveList = false;
		}

    },
    ready(){
		this.getList(this.buttonValue);
		this.getList(this.buttonValue);
    }
  }
</script>
