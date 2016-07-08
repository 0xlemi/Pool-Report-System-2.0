<form method="POST" action="{{ url('settings/company') }}" enctype="multipart/form-data" v-ajax title="Saved" message="Company profile was updated" >
    {{ csrf_field() }}
    {{ method_field('PATCH') }}

<!--
//*********************************************
// Supervisors Permissinos
//*********************************************
-->

    <header class="box-typical-header-sm">Supervisor Permissions:</header>

    <header class="box-typical-header-sm">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reports:
    </header>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_report_index" {{ ($admin->sup_report_index) ? 'checked' : '' }} />
    			<label for="toggle_sup_report_index">View List Reports</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_report_create" {{ ($admin->sup_report_create) ? 'checked' : '' }} />
    			<label for="toggle_sup_report_create">Create New Report</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_report_show" {{ ($admin->sup_report_show) ? 'checked' : '' }} />
    			<label for="toggle_sup_report_show">Show Reports Details</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_report_edit" {{ ($admin->sup_report_edit) ? 'checked' : '' }} />
    			<label for="toggle_sup_report_edit">Edit Reports</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_report_addPhoto" {{ ($admin->sup_report_addPhoto) ? 'checked' : '' }} />
    			<label for="toggle_sup_report_addPhoto">Add Photos from Reports</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_report_removePhoto" {{ ($admin->sup_report_removePhoto) ? 'checked' : '' }} />
    			<label for="toggle_sup_report_removePhoto">Remove Photos from Reports</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_report_destroy" {{ ($admin->sup_report_destroy) ? 'checked' : '' }} />
    			<label for="toggle_sup_report_destroy">Delete Reports</label>
    		</div>
        </div>
    </div>

    <header class="box-typical-header-sm">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Services:
    </header>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_service_index" {{ ($admin->sup_service_index) ? 'checked' : '' }} />
    			<label for="toggle_sup_service_index">View List Services</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_service_create" {{ ($admin->sup_service_create) ? 'checked' : '' }} />
    			<label for="toggle_sup_service_create">Create New Service</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_service_show" {{ ($admin->sup_service_show) ? 'checked' : '' }} />
    			<label for="toggle_sup_service_show">Show Services Details</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_service_edit" {{ ($admin->sup_service_edit) ? 'checked' : '' }} />
    			<label for="toggle_sup_service_edit">Edit Services</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_service_destroy" {{ ($admin->sup_service_destroy) ? 'checked' : '' }} />
    			<label for="toggle_sup_service_destroy">Delete Services</label>
    		</div>
        </div>
    </div>

    <header class="box-typical-header-sm">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clients:
    </header>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_client_index" {{ ($admin->sup_client_index) ? 'checked' : '' }} />
    			<label for="toggle_sup_client_index">View List Clients</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_client_create" {{ ($admin->sup_client_create) ? 'checked' : '' }} />
    			<label for="toggle_sup_client_create">Create New Client</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_client_show" {{ ($admin->sup_client_show) ? 'checked' : '' }} />
    			<label for="toggle_sup_client_show">Show Clients Details</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_client_edit" {{ ($admin->sup_client_edit) ? 'checked' : '' }} />
    			<label for="toggle_sup_client_edit">Edit Clients</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_client_destroy" {{ ($admin->sup_client_destroy) ? 'checked' : '' }} />
    			<label for="toggle_sup_client_destroy">Delete Clients</label>
    		</div>
        </div>
    </div>

    <header class="box-typical-header-sm">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Supervisors:
    </header>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_supervisor_index" {{ ($admin->sup_supervisor_index) ? 'checked' : '' }} />
    			<label for="toggle_sup_supervisor_index">View List Supervisors</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_supervisor_create" {{ ($admin->sup_supervisor_create) ? 'checked' : '' }} />
    			<label for="toggle_sup_supervisor_create">Create New Supervisor</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_supervisor_show" {{ ($admin->sup_supervisor_show) ? 'checked' : '' }} />
    			<label for="toggle_sup_supervisor_show">Show Supervisors Details</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_supervisor_edit" {{ ($admin->sup_supervisor_edit) ? 'checked' : '' }} />
    			<label for="toggle_sup_supervisor_edit">Edit Supervisors</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_supervisor_destroy" {{ ($admin->sup_supervisor_destroy) ? 'checked' : '' }} />
    			<label for="toggle_sup_supervisor_destroy">Delete Supervisors</label>
    		</div>
        </div>
    </div>

    <header class="box-typical-header-sm">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Technicians:
    </header>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_technician_index" {{ ($admin->sup_technician_index) ? 'checked' : '' }} />
    			<label for="toggle_sup_technician_index">View List Technicians</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_technician_create" {{ ($admin->sup_technician_create) ? 'checked' : '' }} />
    			<label for="toggle_sup_technician_create">Create New Technician</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_technician_show" {{ ($admin->sup_technician_show) ? 'checked' : '' }} />
    			<label for="toggle_sup_technician_show">Show Technicians Details</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_technician_edit" {{ ($admin->sup_technician_edit) ? 'checked' : '' }} />
    			<label for="toggle_sup_technician_edit">Edit Technicians</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_sup_technician_destroy" {{ ($admin->sup_technician_destroy) ? 'checked' : '' }} />
    			<label for="toggle_sup_technician_destroy">Delete Technicians</label>
    		</div>
        </div>
    </div>

<!--
//*********************************************
// Technician Permissinos
//*********************************************
-->

    <header class="box-typical-header-sm">Technicians Permissions:</header>

    <header class="box-typical-header-sm">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reports:
    </header>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_report_index" {{ ($admin->tech_report_index) ? 'checked' : '' }} />
    			<label for="toggle_tech_report_index">View List Reports</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_report_create" {{ ($admin->tech_report_create) ? 'checked' : '' }} />
    			<label for="toggle_tech_report_create">Create New Report</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_report_show" {{ ($admin->tech_report_show) ? 'checked' : '' }} />
    			<label for="toggle_tech_report_show">Show Reports Details</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_report_edit" {{ ($admin->tech_report_edit) ? 'checked' : '' }} />
    			<label for="toggle_tech_report_edit">Edit Reports</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_report_addPhoto" {{ ($admin->tech_report_addPhoto) ? 'checked' : '' }} />
    			<label for="toggle_tech_report_addPhoto">Add Photos from Reports</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_report_removePhoto" {{ ($admin->tech_report_removePhoto) ? 'checked' : '' }} />
    			<label for="toggle_tech_report_removePhoto">Remove Photos from Reports</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_report_destroy" {{ ($admin->tech_report_destroy) ? 'checked' : '' }} />
    			<label for="toggle_tech_report_destroy">Delete Reports</label>
    		</div>
        </div>
    </div>

    <header class="box-typical-header-sm">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Services:
    </header>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_service_index" {{ ($admin->tech_service_index) ? 'checked' : '' }} />
    			<label for="toggle_tech_service_index">View List Services</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_service_create" {{ ($admin->tech_service_create) ? 'checked' : '' }} />
    			<label for="toggle_tech_service_create">Create New Service</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_service_show" {{ ($admin->tech_service_show) ? 'checked' : '' }} />
    			<label for="toggle_tech_service_show">Show Services Details</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_service_edit" {{ ($admin->tech_service_edit) ? 'checked' : '' }} />
    			<label for="toggle_tech_service_edit">Edit Services</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_service_destroy" {{ ($admin->tech_service_destroy) ? 'checked' : '' }} />
    			<label for="toggle_tech_service_destroy">Delete Services</label>
    		</div>
        </div>
    </div>

    <header class="box-typical-header-sm">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clients:
    </header>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_client_index" {{ ($admin->tech_client_index) ? 'checked' : '' }} />
    			<label for="toggle_tech_client_index">View List Clients</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_client_create" {{ ($admin->tech_client_create) ? 'checked' : '' }} />
    			<label for="toggle_tech_client_create">Create New Client</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_client_show" {{ ($admin->tech_client_show) ? 'checked' : '' }} />
    			<label for="toggle_tech_client_show">Show Clients Details</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_client_edit" {{ ($admin->tech_client_edit) ? 'checked' : '' }} />
    			<label for="toggle_tech_client_edit">Edit Clients</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_client_destroy" {{ ($admin->tech_client_destroy) ? 'checked' : '' }} />
    			<label for="toggle_tech_client_destroy">Delete Clients</label>
    		</div>
        </div>
    </div>

    <header class="box-typical-header-sm">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Supervisors:
    </header>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_supervisor_index" {{ ($admin->tech_supervisor_index) ? 'checked' : '' }} />
    			<label for="toggle_tech_supervisor_index">View List Supervisors</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_supervisor_create" {{ ($admin->tech_supervisor_create) ? 'checked' : '' }} />
    			<label for="toggle_tech_supervisor_create">Create New Supervisor</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_supervisor_show" {{ ($admin->tech_supervisor_show) ? 'checked' : '' }} />
    			<label for="toggle_tech_supervisor_show">Show Supervisors Details</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_supervisor_edit" {{ ($admin->tech_supervisor_edit) ? 'checked' : '' }} />
    			<label for="toggle_tech_supervisor_edit">Edit Supervisors</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_supervisor_destroy" {{ ($admin->tech_supervisor_destroy) ? 'checked' : '' }} />
    			<label for="toggle_tech_supervisor_destroy">Delete Supervisors</label>
    		</div>
        </div>
    </div>

    <header class="box-typical-header-sm">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Technicians:
    </header>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_technician_index" {{ ($admin->tech_technician_index) ? 'checked' : '' }} />
    			<label for="toggle_tech_technician_index">View List Technicians</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_technician_create" {{ ($admin->tech_technician_create) ? 'checked' : '' }} />
    			<label for="toggle_tech_technician_create">Create New Technician</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_technician_show" {{ ($admin->tech_technician_show) ? 'checked' : '' }} />
    			<label for="toggle_tech_technician_show">Show Technicians Details</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_technician_edit" {{ ($admin->tech_technician_edit) ? 'checked' : '' }} />
    			<label for="toggle_tech_technician_edit">Edit Technicians</label>
    		</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="toggle_tech_technician_destroy" {{ ($admin->tech_technician_destroy) ? 'checked' : '' }} />
    			<label for="toggle_tech_technician_destroy">Delete Technicians</label>
    		</div>
        </div>
    </div>

</form>
