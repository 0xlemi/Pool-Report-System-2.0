@extends('layouts.app')

@section('content')
<div class="row">

    <div class="col-lg-3 col-md-6 col-sm-12">
        <section class="box-typical">
            <div class="profile-card">
                <div class="profile-card-photo">
                    <img src="img/photo-220-1.jpg" alt=""/>
                </div>
                <div class="profile-card-name">{{ $user->getFullName() }}</div>
                <div class="profile-card-status">{{ $user->admin()->company_name }}</div>
                <div class="profile-card-location">Business Plan</div>

            </div><!--.profile-card-->

            <div class="profile-statistic tbl">
                <div class="tbl-row">
                    <div class="tbl-cell">
                        <b>{{ $user->admin()->technicians()->get()->count() }}</b>
                        Technicians
                    </div>
                    <div class="tbl-cell">
                        <b>{{ $user->admin()->reports()->get()->count() }}</b>
                        Reports done
                    </div>
                </div>
            </div>
            @if($user->isAdministrator())
                <ul class="profile-links-list">
                    <li class="nowrap">
                        <i class="font-icon font-icon-mail"></i>
                        &nbsp;{{ $user->email }}
                    </li>
                    <li class="nowrap">
                        <i class="font-icon font-icon-earth-bordered"></i>
                        <a href="http://{{ $company_info->website }}">{{ $company_info->website }}</a>
                    </li>
                    <li class="nowrap">
                        <i class="font-icon font-icon-fb-fill"></i>
                        <a href="http://www.facebook.com/{{ $company_info->facebook }}">facebook.com/{{ $company_info->facebook }}</a>
                    </li>
                    <li class="nowrap">
                        <i class="font-icon font-icon-tw-fill"></i>
                        <a href="http://www.twitter.com/{{ $company_info->twitter }}">twitter.com/{{ $company_info->twitter }}</a>
                    </li>
                </ul>
            @endif
        </section><!--.box-typical-->
    </div><!--.col- -->

    <div class="col-lg-9 col-md-12 col-sm-12">

        <section class="box-typical">
            <header class="box-typical-header-sm">Settings</header>
            <br>
            <section class="tabs-section">
                <div class="tabs-section-nav tabs-section-nav-icons">
                    <div class="tbl">
                        <ul class="nav" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#tabs-1-tab-2" role="tab" data-toggle="tab">
                                    <span class="nav-link-in">
                                        <span class="font-icon font-icon-user"></span>
                                        Account
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tabs-1-tab-1" role="tab" data-toggle="tab">
                                    <span class="nav-link-in">
                                        <i class="font-icon font-icon-build"></i>
                                        Company Profile
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tabs-1-tab-4" role="tab" data-toggle="tab">
                                    <span class="nav-link-in">
                                        <i class="font-icon font-icon-mail"></i>
                                        Email
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tabs-1-tab-5" role="tab" data-toggle="tab">
                                    <span class="nav-link-in">
                                        <i class="glyphicon glyphicon-credit-card"></i>
                                        Billing
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tabs-1-tab-6" role="tab" data-toggle="tab">
                                    <span class="nav-link-in">
                                        <i class="font-icon font-icon-lock"></i>
                                        Permissions
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div><!--.tabs-section-nav-->

                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane fade in active" id="tabs-1-tab-2">
                      <br>
                      <form method="POST" action="{{ url('settings/account') }}" enctype="multipart/form-data">
                          {{ csrf_field() }}
                          {{ method_field('PATCH') }}
                          <input type="hidden" name="id" value="{{ $user->userable()->seq_id }}">

                          <div class="form-group row {{($errors->has('name'))? 'form-group-error':''}}">
                              <label class="col-sm-2 form-control-label">Name:</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control maxlength-simple"
                                          name="name" maxlength="25" value="{{ $user->getFullName() }}">
                                  @if ($errors->has('name'))
                                      <small class="text-muted">{{ $errors->first('name') }}</small>
                                  @endif
                              </div>
                          </div>
                          <br>
                          <p style="float: right;">
                              <button  class="btn btn-success"
                              type='submit'>Save changes</button>
                          </p>
                          <br>
                      </form>

                      <hr />
                      {{-- @include('settings.email') --}}

                      <hr />
                      {{-- @include('settings.password') --}}

                      <br>
                      <br>

                    </div><!--.tab-pane-->

                    <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-1">
                        <br>
                        @include('settings.company')
                    </div><!--.tab-pane-->

                    <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-3">

                    </div><!--.tab-pane-->
                    <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-4">

                    </div><!--.tab-pane-->
                    <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-5">

                    </div><!--.tab-pane-->
                    <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-6">
                        @include('settings.permissions')
                    </div><!--.tab-pane-->
                </div><!--.tab-content-->
            </section><!--.tabs-section-->

        </section><!--.box-typical-->
    </div><!--.col- -->


</div><!--.row-->
@endsection
