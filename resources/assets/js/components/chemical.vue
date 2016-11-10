<template>

    <!-- Modal for Chemical preview -->
	<div class="modal fade" id="chemicalModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Chemicals</h4>
	      </div>
	      <div class="modal-body">
				<div class="row">

                    <!-- Create new Chemical -->
                    <div class="col-md-12" v-show="isFocus(1)">

                    </div>

                    <!-- Index Chemical -->
					{{ 'selected: '+ chemicalId }}
                    <div class="col-md-12" v-show="isFocus(2)">
						<bootstrap-table :chemical-id.sync="chemicalId" :columns="columns" :data="data" :options="options"></bootstrap-table>
                    </div>

                    <!-- Edit Chemical -->
                    <div class="col-md-12" v-show="isFocus(3)">

                    </div>

				</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal" v-if="!isFocus(3)">Close</button>

			<button type="button" class="btn btn-warning" v-if="isFocus(3) || isFocus(1)" @click="changeFocus(2)">
				<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back
			</button>

            <button type="button" class="btn btn-primary" v-if="isFocus(1)" @click="create">
				Create
			</button>

            <button type="button" class="btn btn-success" v-if="isFocus(3)" @click="update">
				<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Update
			</button>

	      </div>
	    </div>
	  </div>
	</div>


</template>

<script>

var alert = require('./alert.vue');
var Spinner = require("spin");
var BootstrapTable = require('./BootstrapTable.vue');

  export default {
    props: ['serviceId', 'chemicalUrl'],
	components: {
		alert,
		BootstrapTable
	},
    data () {
        return {
            focus: 2, // 1=create, 2=index, 3=edit
            chemicalId: 0,
            validationErrors: {},

            name: '',
            amount: '',
            units: '',
			columns: [
		      {
		        title: 'Item ID',
		        field: 'id',
				sortable: true,
		      },
		      {
		        field: 'name',
		        title: 'Item Name',
				sortable: true,
		      },
			  {
		        field: 'amount',
		        title: 'Item Amount',
				sortable: true,
		      }
		    ],
		    data: [
		      {
		        "id": 0,
		        "name": "Item 0",
		        "price": "$0"
		      },
		      {
		        "id": 1,
		        "name": "Item 1",
		        "price": "$1"
		      },
		      {
		        "id": 2,
		        "name": "Item 2",
		        "price": "$2"
		      },
		      {
		        "id": 3,
		        "name": "Item 3",
		        "price": "$3"
		      },
		      {
		        "id": 4,
		        "name": "Item 4",
		        "price": "$4"
		      },
		      {
		        "id": 5,
		        "name": "Item 5",
		        "price": "$5"
		      },
		      {
		        "id": 6,
		        "name": "Item 6",
		        "price": "$6"
		      },
		      {
		        "id": 7,
		        "name": "Item 7",
		        "price": "$7"
		      },
		      {
		        "id": 8,
		        "name": "Item 8",
		        "price": "$8"
		      },
		      {
		        "id": 9,
		        "name": "Item 9",
		        "price": "$9"
		      }
		    ],
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
				pageSize: 5,
				pageList: [5, 10],
				search: true,
				showExport: true,
				exportTypes: ['excel', 'pdf'],
				minimumCountColumns: 2,
				showFooter: false,

				uniqueId: 'id',
				idField: 'id',
				// singleSelect: true,
				// clickToSelect: true,

				toolbarButton: true,
				toolbarButtonText: 'Add Chemical',
		    }
        }
    },
    computed: {
        Url: function(){
            return this.chemicalUrl+this.serviceId;
        },
    },
	watch: {
		chemicalId: function (val) {
			this.getValues(val);
	    },
	},
	events: {
		toolbarButtonClicked(){
			this.clean();
			this.changeFocus(1);
		}
	},
    methods: {
        getList(){
			// console.log(document.getElementById('toolbar'));
        },
		getValues(chemicalId){

		},
		create(){

		},
        update(){

        },
        checkValidationError($fildName){
            return $fildName in this.validationErrors;
        },
        isFocus(num){
            return this.focus == num;
        },
        changeFocus(num){
            this.focus = num;
        },
		clean(){
			this.validationErrors = {};

			this.name = '';
            this.amount = '';
            this.units = '';
		},
		revertButton(clickEvent, buttonTag){
			// enable, remove spinner and set tab to the one before
			clickEvent.target.disabled = false;
			clickEvent.target.innerHTML = buttonTag;
		}
    },
    ready(){
        this.getList();
    }
  }
</script>
