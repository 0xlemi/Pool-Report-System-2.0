<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

	<!-- FAVICON  -->
    <!-- Place your favicon.ico in the img directory -->
    <link rel="shortcut icon" href="{{ url('img/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ url('img/favicon.ico') }}" type="image/x-icon">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Pool Report System') }}</title>

    <!-- Styles -->
    <link href="{{ elixir('css/less.css') }}" rel="stylesheet">
    <link href="{{ elixir('css/main.css') }}" rel="stylesheet">

    <!-- Scripts -->
	<script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'url' => url('/').'/',
			'chat' => $chat,
        ]); ?>
    </script>
</head>
<body class="with-side-menu">
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
