@include('landing.head')
<body data-spy="scroll" data-target="#main-navbar">
  <div class="main-container" id="page">
@include('landing.headerClean')


@yield('content')


</div>
@include('landing.foot')
