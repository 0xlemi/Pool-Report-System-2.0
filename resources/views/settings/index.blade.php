@extends('layouts.app')

@section('content')
<div class="row settingsVue">

    <div class="col-lg-3 col-md-6 col-sm-12">
        <profile
            name="{{ ($profile) ? $profile->name : '' }}"
            company-name="{{ ($customization) ? $customization->name : '' }}"
            email="{{ ($profile) ?  $profile->email : '' }}"
            website="{{ ($customization) ? $customization->website : '' }}"
            facebook="{{ ($customization) ? $customization->facebook : '' }}"
            twitter="{{ ($customization) ? $customization->twitter : '' }}">
        </profile>
    </div><!--.col- -->

    <div class="col-lg-9 col-md-12 col-sm-12">
        <settings
            :profile="{{ json_encode($profile) }}"
            :customization="{{ json_encode($customization) }}"
            :notifications="{{ json_encode($notifications) }}"
            :billing="{{ json_encode($billing) }}"
            :payment="{{ json_encode($payment) }}"
            :permissions="{{ json_encode($permissions) }}">
        </settings>
    </div><!--.col- -->


</div><!--.row-->
@endsection
