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

<script type="text/javascript" src='https://maps.google.com/maps/api/js?key=AIzaSyDAPatUXIeXhv0rhd4XkAzoU73akZVy-Sw&libraries=places'></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
  Stripe.setPublishableKey('{{config('services.stripe.key')}}');
</script>
<script src="{{ url('js/plugins.js') }}"></script>
<script src="{{ elixir('js/bundle.js') }}"></script>
@include('layouts.footer')
</body>
</html>
