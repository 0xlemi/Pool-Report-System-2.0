@extends('layouts.app')

@section('content')
<div class="row settingsVue">

    @include('settings.profile')

    <div class="col-lg-9 col-md-12 col-sm-12">
        <settings
            :profile="{{ json_encode($profile) }}"
            :customization="{{ json_encode($customization) }}"
            :billing="{{ json_encode($billing) }}"
            :permissions="{{ json_encode($permissions) }}">
        </settings>
    </div><!--.col- -->


</div><!--.row-->
@endsection
