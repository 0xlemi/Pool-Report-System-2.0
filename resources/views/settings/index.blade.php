@extends('layouts.app')

@section('content')
<div class="row settingsVue">

    <div class="col-lg-3 col-md-6 col-sm-12">
        <profile
            name="{{ $profile->name }}"
            company-name="{{ $customization->companyName }}"
            email="{{ $profile->email }}"
            website="{{ $customization->website }}"
            facebook="{{ $customization->facebook }}"
            twitter="{{ $customization->twitter }}">
        </profile>
    </div><!--.col- -->

    <div class="col-lg-9 col-md-12 col-sm-12">
        <settings
            :profile="{{ json_encode($profile) }}"
            :customization="{{ json_encode($customization) }}"
            :notifications="{{ json_encode($notifications) }}"
            :billing="{{ json_encode($billing) }}"
            :permissions="{{ json_encode($permissions) }}">
        </settings>
    </div><!--.col- -->


</div><!--.row-->
@endsection
