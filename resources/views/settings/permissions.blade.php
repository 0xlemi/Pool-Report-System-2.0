{{ csrf_field() }}

<header class="box-typical-header-sm">Supervisor Permissions:</header>

<permissions :admin="{{ $admin }}" :permission-type="'sup'" ></permissions>

<header class="box-typical-header-sm">Technician Permissions:</header>

<permissions :admin="{{ $admin }}" :permission-type="'tech'" ></permissions>
