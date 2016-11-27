@extends('layouts.app')

@section('content')
<div class="row settingsVue">

    @include('settings.profile')

    <div class="col-lg-9 col-md-12 col-sm-12">
            <section class="tabs-section">
                <div class="tabs-section-nav">
                    <div class="tbl">
                        <ul class="nav" role="tablist">

                            <li class="nav-item">
                                <a class="nav-link active" href="#tabs-1-tab-1" role="tab" data-toggle="tab">
                                    <span class="nav-link-in">
                                        <i class="font-icon font-icon-user"></i>&nbsp;
                                        Profile
                                    </span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#tabs-1-tab-2" role="tab" data-toggle="tab">
                                    <span class="nav-link-in">
                                        <i class="font-icon font-icon-build"></i>&nbsp;
                                        Customization
                                    </span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#tabs-1-tab-3" role="tab" data-toggle="tab">
                                    <span class="nav-link-in">
                                        <i class="font-icon font-icon-mail"></i>&nbsp;
                                        Notifications
                                    </span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#tabs-1-tab-4" role="tab" data-toggle="tab">
                                    <span class="nav-link-in">
                                        <i class="glyphicon glyphicon-credit-card"></i>&nbsp;
                                        Billing
                                    </span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#tabs-1-tab-5" role="tab" data-toggle="tab">
                                    <span class="nav-link-in">
                                        <i class="font-icon font-icon-lock"></i>&nbsp;
                                        Permissions
                                    </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div><!--.tabs-section-nav-->

                <div class="tab-content">

                    <!-- Profile     -->
                    <div role="tabpanel" class="tab-pane fade in active" id="tabs-1-tab-1">
                        <br>
                        @include('settings.account')

                        <hr>
                        @include('settings.company')

                        <hr />
                        @include('settings.changeEmail')

                        <hr />
                        @include('settings.changePassword')

                      <br>
                      <br>

                    </div><!--.tab-pane-->

                    <!-- System Settings -->
                    <div role="tabpanel" class="tab-pane fade in active" id="tabs-1-tab-2">

                    </div><!--.tab-pane-->

                    <!-- Notifications -->
                    <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-3">
                        @include('settings.email')
                    </div><!--.tab-pane-->

                    <!-- Billing -->
                    <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-4">
                        @include('settings.billing')
                    </div><!--.tab-pane-->

                    <!-- Permissions -->
                    <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-5">
                        @include('settings.permissions')
                    </div><!--.tab-pane-->

                </div><!--.tab-content-->
            </section><!--.tabs-section-->
    </div><!--.col- -->


</div><!--.row-->
@endsection
