{{ csrf_field() }}

<header class="box-typical-header-sm">Supervisor Permissions:</header>

<permissions :admin="{{ $admin }}" :permission-type="'sup'" :url="'{{ $url->permissions }}'"></permissions>

<header class="box-typical-header-sm">Technician Permissions:</header>

<permissions :admin="{{ $admin }}" :permission-type="'tech'" :url="'{{ $url->permissions }}'"></permissions>
