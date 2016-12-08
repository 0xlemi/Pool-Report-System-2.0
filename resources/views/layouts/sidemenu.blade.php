<div class="mobile-menu-left-overlay"></div>
<nav class="side-menu">
    <ul class="side-menu-list">

        <li class="orange-red {{ Request::is('dashboard*')? 'opened':'' }}">
            <a href="{{ url('/dashboard') }}">
                <i class="font-icon font-icon-speed"></i>
                <span class="lbl">Dashboard</span>
            </a>
        </li>

        <li class="grey {{ Request::is('todaysroute*')? 'opened':'' }}">
            <a href="{{ url('/todaysroute') }}">
                <i class="glyphicon glyphicon-road"></i>
                <span class="lbl">Today's Route</span>
            </a>
        </li>

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
                <i class="font-icon glyphicon glyphicon-home"></i>
                <span class="lbl">Services</span>
            </a>
        </li>
        @endcan

        @can('list', App\Client::class)
        <li class="blue {{ Request::is('clients*')? 'opened':'' }}">
            <a href="{{ url('/clients') }}">
                <i class="font-icon glyphicon glyphicon-user"></i>
                <span class="lbl">Clients</span>
            </a>
        </li>
        @endcan

        @can('list', App\Supervisor::class)
        <li class="orange-red {{ Request::is('supervisors*')? 'opened':'' }}">
            <a href="{{ url('/supervisors') }}">
                <i class="font-icon glyphicon glyphicon-eye-open"></i>
                <span class="lbl">Supervisors</span>
            </a>
        </li>
        @endcan

        @can('list', App\Technician::class)
        <li class="magenta {{ Request::is('technicians*')? 'opened':'' }}">
            <a href="{{ url('/technicians') }}">
                <i class="font-icon glyphicon glyphicon-wrench"></i>
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

        <!-- <li class="green {{ Request::is('chat*')? 'opened':'' }}">
            <a href="{{ url('/chat') }}">
                <i class="font-icon font-icon-comments"></i>
                <span class="lbl">Chat</span>
            </a>
        </li> -->

        </ul>
    </section>
</nav><!--.side-menu-->
