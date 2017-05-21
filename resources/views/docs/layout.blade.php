<!DOCTYPE html>
<html><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- TITLE OF SITE -->
    <title>Pool Business Management Software | Pool Report System</title>

    <meta name="description" content="Web-based software that helps you automate alot of the management work in your pool service business. ">
    <meta name="keywords" content="pool, service, business, management, web, pool service business,
software, pool service business management software">
    <meta name="author" content="Luis Espinosa de los Monteros">

    <!-- FAVICON  -->
    <!-- Place your favicon.ico in the img directory -->
    <link rel="shortcut icon" href="{{ url('img/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ url('img/favicon.ico') }}" type="image/x-icon">

    <!-- =========================
       STYLESHEETS
    ============================== -->
    <!-- GOOGLE FONTS -->
    <link href="//fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic" rel="stylesheet" type="text/css">
    <link href='//fonts.googleapis.com/css?family=Raleway:100,300,400,500%7CLato:300,400' rel='stylesheet' type='text/css'>

    <!-- CUSTOM STYLESHEET -->
    <link rel="stylesheet" href="{{ url('css/landing/style.css') }}">

    <!-- RESPONSIVE FIXES -->
    <link rel="stylesheet" href="{{ url('css/landing/responsive.css') }}">

    <!-- DOCUMENTATION STYLESHEET -->
    <link href="{{ elixir('css/docs.css') }}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body data-spy="scroll" data-target="#main-navbar">
<div class="main-container" id="page">

 @include('landing.header')

<main class="container">
    <div class="row">


        <!-- Sidebar -->
        <aside class="col-md-3 col-sm-3 sidebar sidebar-icon">

          <ul class="sidenav dropable sticky">
            <li>
              <a href="{{ url('docs/quick') }}"><i class="fa fa-clock-o"></i> Quick Start</a>
            </li>

            <li>
              <a href="{{ url('docs/user') }}"><i class="glyphicon glyphicon-user"></i> Users/Roles</a>
            </li>

            <li>
              <a href="{{ url('docs/company') }}"><i class="fa fa-building"></i> Company</a>
            </li>

            <li>
              <a href="{{ url('docs/service') }}"><i class="fa fa-home"></i> Services</a>
              <ul>
                <li><a href="{{ url('docs/service/contract') }}"><i class="glyphicon glyphicon-file"></i> Contract</a></li>
                <li><a href="{{ url('docs/service/measurment') }}"><i class="fa fa-area-chart"></i> Measurments</a></li>
                <li><a href="{{ url('docs/service/product') }}"><i class="fa fa-flask"></i> Product</a></li>
                <li><a href="{{ url('docs/service/equipment') }}"><i class="glyphicon glyphicon-hdd"></i> Equipment</a></li>
              </ul>
            </li>

            <li>
              <a href="{{ url('docs/report') }}"><i class="glyphicon glyphicon-file"></i> Reports</a>
            </li>

            <li>
              <a href="{{ url('docs/todaysroute') }}"><i class="glyphicon glyphicon-road"></i> Todays Route</a>
            </li>

            <li>
              <a href="{{ url('docs/workorder') }}"><i class="glyphicon glyphicon-briefcase"></i> Work Orders</a>
              <ul>
                <li><a href="{{ url('docs/work') }}"><i class="fa fa-list-alt"></i> Work</a></li>
              </ul>
            </li>

            <li>
              <a href="{{ url('docs/inovice') }}"><i class="glyphicon glyphicon-book"></i> Inovices/Payments</a>
            </li>

            <li>
              <a href="{{ url('docs/chat') }}"><i class="glyphicon glyphicon-comment"></i> Chat</a>
            </li>

            <li>
              <a href="{{ url('docs/setting') }}"><i class="glyphicon glyphicon-cog"></i> Settings</a>
            </li>

          </ul>

        </aside>
        <!-- END Sidebar -->

        <!-- CONTENT -->
        <article class="col-md-9 col-sm-9 main-content" role="main">
            @yield('content')
        </article>

    </div>
</main>

    <!-- Footer -->
    <footer class="site-footer">
      <div class="container">
        <a id="scroll-up" href="#"><i class="fa fa-angle-up"></i></a>

        <div class="row">
          <div class="col-md-6 col-sm-6">
            <p>Pool Report System 2017. All right reserved</p>
          </div>
          <div class="col-md-6 col-sm-6">
            <ul class="footer-menu">
              <li><a href="page_changelog.html">Changelog</a></li>
              <li><a href="mailto:support@poolreportsystem.com">Contact us</a></li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
    <!-- END Footer -->

    <!-- Scripts -->
    <script src="{{ asset('storage/js/theDocs.all.min.js') }}"></script>

  </body>
</html>
