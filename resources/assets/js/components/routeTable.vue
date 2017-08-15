<template>
    <div>
    	<bootstrap-table :columns="columns" :data="data" :options="options">
            <div>
                <span v-for="button in buttons">
                    <button type="button" class="btn" :class="(buttonValue == button.value ) ? button.classSelected : button.class"
                            @click="changeButtonValue(button.value)">
            			{{ button.text }}
            		</button>
                </span>
            </div>
        </bootstrap-table>
    </div>
</template>

<script>

var alert = require('./alert.vue');
var BootstrapTable = require('./BootstrapTable.vue');

  export default {
    props: ['buttons'],
    components: {
        alert,
        BootstrapTable
    },
    data () {
        return {
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
                    field: 'measurements',
                    title: 'Measurements',
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
		    }
        }
    },
    events:{
		rowClicked(id){
            window.location = Laravel.url+'todaysroute/report/'+id;
        }
    },
    methods: {
        getList(val){
			this.resetAlert();
			this.$broadcast('disableTable');
			this.$http.get(Laravel.url+'datatables/todaysroute', {
                params: {
                    daysFromToday: val
                }
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
        changeButtonValue(val){
            this.buttonValue = val;
            this.getList(val);
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
