<template>

    <button class="btn btn-warning" data-toggle="modal" data-target="#missingServicesModal"
			:class="button.class" :disabled="( numServicesMissing < 1 )">
		<i class="glyphicon glyphicon-home"></i>&nbsp;&nbsp;
		{{ button.tag }}
	</button>

    <!-- Modal for Missing Services preview -->
	<div class="modal fade" id="missingServicesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
		    <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Missing Services</h4>
			</div>
			<div id="toolbar">
				<div class="progress-steps-caption">{{ numServicesDone }}/{{ numServicesDone+numServicesMissing }}&nbsp; Services Completed</div>
			</div>
	    	<div class="modal-body">
				<div class="row">
					<div class="col-md-12">

                        <alert type="danger" :message="alertMessage" :active="alertActive"></alert>

					    <bootstrap-table :object-id.sync="serviceId" :columns="columns" :data="data" :options="options"></bootstrap-table>

					</div>
				</div>
	    	</div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>

</template>

<script>
import alert from './alert.vue';
import BootstrapTable from './BootstrapTable.vue';

export default {
    components: {
        alert,
        BootstrapTable
    },
    data(){
        return {
            serviceId: 2,
            numServicesDone: 0,
            numServicesMissing: 0,

            alertMessage: "",
            alertActive: false,

            data: [],
            columns: [
    		    {
    		        field: 'id',
    		        title: '#',
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
    		        field: 'price',
    		        title: 'Price',
    				sortable: true,
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

				toolbarButton: false,
		    }
        }
    },
    computed:{
        button() {
            if(this.numServicesMissing < 1){
                return {
                    tag: 'All Services Done',
                    class: 'btn-success'
                };
            }
            return {
                    tag: 'Missing Services: '+this.numServicesMissing,
                    class: 'btn-warning'
                };
        }
    },
    events: {
        datePickerClicked(date){
            this.getList(date);
        }
    },
    methods: {
        getList(date){
            this.$http.get(Laravel.url+'missingservices', {
                date: date
            }).then((response) => {
				let data = response.data;

                this.data = data.services;
                this.numServicesMissing = data.numServicesMissing;
                this.numServicesDone = data.numServicesDone;
				this.validationErrors = {};
				this.$broadcast('refreshTable');
            }, (response) => {
				this.focus = 2;
				this.alertMessage = "The information could not be retrieved, please try again.";
				this.alertActive = true;
            });
        },
        resetAlert(){
            this.alertMessage = "";
			this.alertActive = false;
        },
    },
    ready(){
        this.getList();
        this.getList();
    }
}
</script>
