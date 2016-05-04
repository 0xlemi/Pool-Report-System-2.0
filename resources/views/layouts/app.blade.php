@include('layouts.head')
<body class="with-side-menu">

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
<script type="text/javascript">
	swal({   title: "Are you sure?",   text: "You will not be able to recover this imaginary file!",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   cancelButtonText: "No, cancel plx!",   closeOnConfirm: false,   closeOnCancel: false }, function(isConfirm){   if (isConfirm) {     swal("Deleted!", "Your imaginary file has been deleted.", "success");   } else {     swal("Cancelled", "Your imaginary file is safe :)", "error");   } });
</script>
</body>
</html>