@include('layouts.head')
<body class="with-side-menu">

<meta name="csrf-token" content="{{ csrf_token() }}">

@include('layouts.header')
@include('layouts.sidemenu')

<div class="page-content">
    <div class="container-fluid">
        @yield('content')
    </div><!--.container-fluid-->
</div><!--.page-content-->

<script src="{{ url('js/plugins.js') }}"></script>
<script src="{{ elixir('js/bundle.js') }}"></script>
@include('layouts.footer')
</body>
</html>
