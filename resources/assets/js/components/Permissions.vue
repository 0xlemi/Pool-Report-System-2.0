<template>

  <checkbox-list :header="'Reports'" :data="permission_reports"></checkbox-list>
  <checkbox-list :header="'Services'" :data="permission_services"></checkbox-list>
  <checkbox-list :header="'Clients'" :data="permission_clients"></checkbox-list>
  <checkbox-list :header="'Supervisors'" :data="permission_supervisors"></checkbox-list>
  <checkbox-list :header="'Technicians'" :data="permission_technicians"></checkbox-list>

</template>

<script>
  export default {
    props: ['admin', 'permissionType'],
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
