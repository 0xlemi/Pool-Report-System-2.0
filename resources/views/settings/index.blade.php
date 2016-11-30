@extends('layouts.app')

@section('content')
<div class="row settingsVue">

    @include('settings.profile')

    <div class="col-lg-9 col-md-12 col-sm-12">
        <settings
        :billing="{{ json_encode($billing) }}">
    </settings>
    </div><!--.col- -->


</div><!--.row-->
@endsection
