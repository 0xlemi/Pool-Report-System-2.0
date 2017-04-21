<div class="mobile-menu-left-overlay"></div>
<nav class="side-menu {{ (auth()->user()->selectedUser->isRole('client')) ? 'side-menu-compact' : '' }}">
    <ul class="side-menu-list">

        <li class="orange-red {{ Request::is('dashboard*')? 'opened':'' }}">
            <a href="{{ url('/dashboard') }}">
                <i class="font-icon font-icon-speed"></i>
                <span class="lbl">Dashboard</span>
            </a>
        </li>

        @role('client')
        <li class="brown {{ Request::is('report*')? 'opened':'' }}">
            <a href="{{ url('/report') }}">
                <i class="font-icon font-icon-notebook"></i>
                <span class="lbl">Reports</span>
            </a>
        </li>

        <li class="aquamarine {{ Request::is('workorder*')? 'opened':'' }}">
            <a href="{{ url('/workorder') }}">
                <i class="glyphicon glyphicon-briefcase"></i>
                <span class="lbl">Work Orders</span>
            </a>
        </li>

        <li class="red {{ Request::is('service*')? 'opened':'' }}">
            <a href="{{ url('/service') }}">
                <i class="glyphicon glyphicon-home"></i>
                <span class="lbl">Services</span>
            </a>
        </li>

        <li class="green {{ Request::is('statement*')? 'opened':'' }}">
            <a href="{{ url('/statement') }}">
                <i class="fa fa-dollar"></i>
                <span class="lbl">Statement</span>
            </a>
        </li>
        @endrole

        @role('admin', 'sup', 'tech')

            @can('list', App\Service::class)
            <li class="grey {{ Request::is('todaysroute*')? 'opened':'' }}">
                <a href="{{ url('/todaysroute') }}">
                    <i class="glyphicon glyphicon-road"></i>
                    <span class="lbl">Today's Route</span>
                </a>
            </li>
            @endcan

            @can('list', App\Report::class)
                <li class="brown {{ Request::is('reports*')? 'opened':'' }}">
                    <a href="{{ url('/reports') }}">
                        <i class="font-icon font-icon-notebook"></i>
                        <span class="lbl">Reports</span>
                    </a>
                </li>
            @endcan

            @can('list', App\WorkOrder::class)
            <li class="aquamarine {{ Request::is('workorders*')? 'opened':'' }}">
                <a href="{{ url('/workorders') }}">
                    <i class="glyphicon glyphicon-briefcase"></i>
                    <span class="lbl">Work Orders</span>
                </a>
            </li>
            @endcan

            @can('list', App\Service::class)
            <li class="red {{ Request::is('services*')? 'opened':'' }}">
                <a href="{{ url('/services') }}">
                    <i class="glyphicon glyphicon-home"></i>
                    <span class="lbl">Services</span>
                </a>
            </li>
            @endcan

            @can('list', [App\UserRoleCompany::class, 'client'])
            <li class="blue {{ Request::is('clients*')? 'opened':'' }}">
                <a href="{{ url('/clients') }}">
                    <i class="glyphicon glyphicon-user"></i>
                    <span class="lbl">Clients</span>
                </a>
            </li>
            @endcan

            @can('list', [App\UserRoleCompany::class, 'sup'])
            <li class="orange-red {{ Request::is('supervisors*')? 'opened':'' }}">
                <a href="{{ url('/supervisors') }}">
                    <i class="glyphicon glyphicon-eye-open"></i>
                    <span class="lbl">Supervisors</span>
                </a>
            </li>
            @endcan

            @can('list', [App\UserRoleCompany::class, 'tech'])
            <li class="magenta {{ Request::is('technicians*')? 'opened':'' }}">
                <a href="{{ url('/technicians') }}">
                    <i class="glyphicon glyphicon-wrench"></i>
                    <span class="lbl">Technicians</span>
                </a>
            </li>
            @endcan

            @can('list', App\Invoice::class)
            <li class="gold {{ Request::is('invoices*')? 'opened':'' }}">
                <a href="{{ url('/invoices') }}">
                    <i class="glyphicon glyphicon-book"></i>
                    <span class="lbl">Invoices</span>
                </a>
            </li>
            @endcan

        @endrole

        <li class="green {{ Request::is('chat*')? 'opened':'' }}">
            <a href="{{ url('/chat') }}">
                <i class="font-icon font-icon-comments"></i>
                <span class="lbl">Chat</span>
            </a>
        </li>

        </ul>
    </section>
</nav><!--.side-menu-->
