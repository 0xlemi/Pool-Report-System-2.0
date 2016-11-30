<template>

<button type="button" class="btn" :class="button.class" data-toggle="modal" data-target="#{{'permissionsModal'+permissionType}}">
		<i :class="button.icon"></i>&nbsp;&nbsp;&nbsp;
        {{ button.tag }}
</button>

<!-- Modal for Permissions -->
<div class="modal fade" id="{{'permissionsModal'+permissionType}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i :class="button.icon"></i>&nbsp;&nbsp;{{ button.tag }}</h4>
      </div>
      <div class="modal-body">
			<div class="row">
                <div class="col-md-12">
                    <section class="tabs-section">
                    	<div class="tabs-section-nav tabs-section-nav-inline">
                    		<ul class="nav" role="tablist">
                    			<li class="nav-item">
                    				<a class="nav-link active" href="#tabs-{{ tabsNumber }}-tab-1" role="tab" data-toggle="tab">
                    					Reports
                    				</a>
                    			</li>
                    			<li class="nav-item">
                    				<a class="nav-link" href="#tabs-{{ tabsNumber }}-tab-2" role="tab" data-toggle="tab">
                    					Work Orders
                    				</a>
                    			</li>
                    			<li class="nav-item">
                    				<a class="nav-link" href="#tabs-{{ tabsNumber }}-tab-3" role="tab" data-toggle="tab">
                    					Services
                    				</a>
                    			</li>
                    			<li class="nav-item">
                    				<a class="nav-link" href="#tabs-{{ tabsNumber }}-tab-4" role="tab" data-toggle="tab">
                    					Clients
                    				</a>
                    			</li>
                    			<li class="nav-item">
                    				<a class="nav-link" href="#tabs-{{ tabsNumber }}-tab-5" role="tab" data-toggle="tab">
                    					Supervisors
                    				</a>
                    			</li>
                    			<li class="nav-item">
                    				<a class="nav-link" href="#tabs-{{ tabsNumber }}-tab-6" role="tab" data-toggle="tab">
                    					Technicians
                    				</a>
                    			</li>
                    		</ul>
                    	</div><!--.tabs-section-nav-->

                    	<div class="tab-content">

                    		<div role="tabpanel" class="tab-pane fade in active" id="tabs-{{ tabsNumber }}-tab-1">
                                <br>
                                <checkbox-list :data="permission_reports"></checkbox-list>
                            </div>

                    		<div role="tabpanel" class="tab-pane fade" id="tabs-{{ tabsNumber }}-tab-2">
                                <br>
                                workOrder permissions
                            </div>

                    		<div role="tabpanel" class="tab-pane fade" id="tabs-{{ tabsNumber }}-tab-3">
                                <br>
                                <checkbox-list :data="permission_services"></checkbox-list>
                            </div>

                    		<div role="tabpanel" class="tab-pane fade" id="tabs-{{ tabsNumber }}-tab-4">
                                <br>
                                <checkbox-list :data="permission_clients"></checkbox-list>
                            </div>

                    		<div role="tabpanel" class="tab-pane fade" id="tabs-{{ tabsNumber }}-tab-5">
                                <br>
                                <checkbox-list :data="permission_supervisors"></checkbox-list>
                            </div>

                    		<div role="tabpanel" class="tab-pane fade" id="tabs-{{ tabsNumber }}-tab-6">
                                <br>
                                <checkbox-list :data="permission_technicians"></checkbox-list>
                            </div>
                    	</div><!--.tab-content-->
                    </section><!--.tabs-section-->
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
import checkboxList from './checkboxList.vue';

  export default {
    props: ['admin', 'button', 'permissionType', 'tabsNumber'],
    components: {
        checkboxList
    },
    data () {
      return {
        permission_reports: [
          {id: this.permissionType+"_report_index", name: "View List Reports", checked: this.admin[this.permissionType+'_report_index'] },
          {id: this.permissionType+"_report_create", name: "Create New Report", checked: this.admin[this.permissionType+'_report_create']},
          {id: this.permissionType+"_report_show", name: "Show Report Details", checked: this.admin[this.permissionType+'_report_show']},
          {id: this.permissionType+"_report_edit", name: "Edit Reports", checked: this.admin[this.permissionType+'_report_edit']},
          {id: this.permissionType+"_report_addPhoto", name: "Add Photos from Reports", checked: this.admin[this.permissionType+'_report_addPhoto']},
          {id: this.permissionType+"_report_removePhoto", name: "Remove Photos from Reports", checked: this.admin[this.permissionType+'_report_removePhoto']},
          {id: this.permissionType+"_report_destroy", name: "Delete Report", checked: this.admin[this.permissionType+'_report_destroy']}
      ],permission_services: [
          {id: this.permissionType+"_service_index", name: "View List Services", checked: this.admin[this.permissionType+'_service_index'] },
          {id: this.permissionType+"_service_create", name: "Create New Service", checked: this.admin[this.permissionType+'_service_create']},
          {id: this.permissionType+"_service_show", name: "Show Service Details", checked: this.admin[this.permissionType+'_service_show']},
          {id: this.permissionType+"_service_edit", name: "Edit Services", checked: this.admin[this.permissionType+'_service_edit']},
          {id: this.permissionType+"_service_destroy", name: "Delete Service", checked: this.admin[this.permissionType+'_service_destroy']}
      ],permission_clients: [
          {id: this.permissionType+"_client_index", name: "View List Clients", checked: this.admin[this.permissionType+'_client_index'] },
          {id: this.permissionType+"_client_create", name: "Create New Client", checked: this.admin[this.permissionType+'_client_create']},
          {id: this.permissionType+"_client_show", name: "Show Client Details", checked: this.admin[this.permissionType+'_client_show']},
          {id: this.permissionType+"_client_edit", name: "Edit Clients", checked: this.admin[this.permissionType+'_client_edit']},
          {id: this.permissionType+"_client_destroy", name: "Delete Client", checked: this.admin[this.permissionType+'_client_destroy']}
      ],permission_supervisors: [
          {id: this.permissionType+"_supervisor_index", name: "View List Supervisors", checked: this.admin[this.permissionType+'_supervisor_index'] },
          {id: this.permissionType+"_supervisor_create", name: "Create New Supervisor", checked: this.admin[this.permissionType+'_supervisor_create']},
          {id: this.permissionType+"_supervisor_show", name: "Show Supervisor Details", checked: this.admin[this.permissionType+'_supervisor_show']},
          {id: this.permissionType+"_supervisor_edit", name: "Edit Supervisors", checked: this.admin[this.permissionType+'_supervisor_edit']},
          {id: this.permissionType+"_supervisor_destroy", name: "Delete Supervisor", checked: this.admin[this.permissionType+'_supervisor_destroy']}
      ],permission_technicians: [
          {id: this.permissionType+"_technician_index", name: "View List Technicians", checked: this.admin[this.permissionType+'_technician_index'] },
          {id: this.permissionType+"_technician_create", name: "Create New Technician", checked: this.admin[this.permissionType+'_technician_create']},
          {id: this.permissionType+"_technician_show", name: "Show Technician Details", checked: this.admin[this.permissionType+'_technician_show']},
          {id: this.permissionType+"_technician_edit", name: "Edit Technicians", checked: this.admin[this.permissionType+'_technician_edit']},
          {id: this.permissionType+"_technician_destroy", name: "Delete Technician", checked: this.admin[this.permissionType+'_technician_destroy']}
        ],
      }
    }
  }
</script>

<style scoped>
  h1 {
    color: red;
  }
</style>
