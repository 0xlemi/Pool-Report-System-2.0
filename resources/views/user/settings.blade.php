@extends('layouts.app')

@section('content')
<div class="row">

    <div class="col-lg-3 col-md-6 col-sm-12">
        <section class="box-typical">
            <div class="profile-card">
                <div class="profile-card-photo">
                    <img src="img/photo-220-1.jpg" alt=""/>
                </div>
                <div class="profile-card-name">{{ $user->name }}</div>
                <div class="profile-card-status">{{ $user->company_name }}</div>
                <div class="profile-card-location">Business Plan</div>
                
            </div><!--.profile-card-->

            <div class="profile-statistic tbl">
                <div class="tbl-row">
                    <div class="tbl-cell">
                        <b>{{ $user->technicians->count() }}</b>
                        Technicians
                    </div>
                    <div class="tbl-cell">
                        <b>{{ $user->reports->count() }}</b>
                        Reports done
                    </div>
                </div>
            </div>

            <ul class="profile-links-list">
                <li class="nowrap">
                    <i class="font-icon font-icon-earth-bordered"></i>
                    <a href="http://{{ $user->website }}">{{ $user->website }}</a>
                </li>
                @if($user->facebook)
                    <li class="nowrap">
                        <i class="font-icon font-icon-fb-fill"></i>
                        <a href="http://www.facebook.com/{{ $user->facebook }}">facebook.com/{{ $user->facebook }}</a>
                    </li>
                @endif
                @if($user->twitter)
                    <li class="nowrap">
                        <i class="font-icon font-icon-tw-fill"></i>
                        <a href="http://www.twitter.com/{{ $user->twitter }}">twitter.com/{{ $user->twitter }}</a>
                    </li>
                @endif
            </ul>
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
                                <a class="nav-link active" href="#tabs-1-tab-1" role="tab" data-toggle="tab">
                                    <span class="nav-link-in">
                                        <i class="font-icon font-icon-build"></i>
                                        Company Profile
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tabs-1-tab-2" role="tab" data-toggle="tab">
                                    <span class="nav-link-in">
                                        <span class="font-icon font-icon-user"></span>
                                        Account
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
                    <div role="tabpanel" class="tab-pane fade in active" id="tabs-1-tab-1">
                        <br>
                        <form method="POST" action="{{ url('settings/company') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <input type="hidden" name="id" value="{{ $user->id }}">


                            <div class="form-group row {{($errors->has('name'))? 'form-group-error':''}}">
                                <label class="col-sm-2 form-control-label">Company Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control maxlength-simple"
                                            name="name" maxlength="25" value="{{ $user->name }}">
                                    @if ($errors->has('name'))
                                        <small class="text-muted">{{ $errors->first('name') }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{($errors->has('website'))? 'form-group-error':''}}">
                                <label class="col-sm-2 form-control-label">Website:</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <div class="input-group-addon">http://</div>
                                        <input type="text" class="form-control maxlength-simple"
                                                name="website" maxlength="60" value="{{ $user->website }}">
                                    </div>
                                    @if ($errors->has('website'))
                                        <small class="text-muted">{{ $errors->first('website') }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{($errors->has('facebook'))? 'form-group-error':''}}">
                                <label class="col-sm-2 form-control-label">Facebook:</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <div class="input-group-addon">http://www.facebook.com/</div>
                                        <input type="text" class="form-control maxlength-simple"
                                                name="facebook" maxlength="40" value="{{ $user->facebook }}">
                                    </div>
                                    @if ($errors->has('facebook'))
                                        <small class="text-muted">{{ $errors->first('facebook') }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{($errors->has('twitter'))? 'form-group-error':''}}">
                                <label class="col-sm-2 form-control-label">Twitter:</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <div class="input-group-addon">http://www.twitter.com/</div>
                                        <input type="text" class="form-control maxlength-simple"
                                                name="twitter" maxlength="40" value="{{ $user->twitter }}">
                                    </div>
                                    @if ($errors->has('twitter'))
                                        <small class="text-muted">{{ $errors->first('twitter') }}</small>
                                    @endif
                                </div>
                            </div>

                            <br>
                            <p style="float: right;">
                                <button  class="btn btn-success"
                                type='submit'>
                                <i class="font-icon font-icon-ok"></i>&nbsp;&nbsp;&nbsp;Save</button>
                            </p>
                            <br>
                            <br>
                        </form>
                    </div><!--.tab-pane-->
                    <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-2">
                        <br>
                        <form method="POST" action="{{ url('settings/account') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <input type="hidden" name="id" value="{{ $user->id }}">


                            <div class="form-group row {{($errors->has('name'))? 'form-group-error':''}}">
                                <label class="col-sm-2 form-control-label">Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control maxlength-simple"
                                            name="name" maxlength="25" value="{{ $user->name }}">
                                    @if ($errors->has('name'))
                                        <small class="text-muted">{{ $errors->first('name') }}</small>
                                    @endif
                                </div>
                            </div>

                            <hr>

                            <h4>Change Email</h4>
                            <br>

                            <div class="form-group row {{($errors->has('old_password'))? 'form-group-error':''}}">
                                <label class="col-sm-2 form-control-label">Old password:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control maxlength-simple"
                                            name="old_password" maxlength="25" value="">
                                    @if ($errors->has('old_password'))
                                        <small class="text-muted">{{ $errors->first('old_password') }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{($errors->has('email'))? 'form-group-error':''}}">
                                <label class="col-sm-2 form-control-label">Email:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control maxlength-simple"
                                            name="email" maxlength="25" value="{{ $user->email }}">
                                    @if ($errors->has('email'))
                                        <small class="text-muted">{{ $errors->first('email') }}</small>
                                    @endif
                                </div>
                            </div>

                            <hr>

                            <h4>Change Password</h4>
                            <br>

                            <div class="form-group row {{($errors->has('old_password'))? 'form-group-error':''}}">
                                <label class="col-sm-2 form-control-label">Old password:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control maxlength-simple"
                                            name="old_password" maxlength="25" value="">
                                    @if ($errors->has('old_password'))
                                        <small class="text-muted">{{ $errors->first('old_password') }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{($errors->has('new_password'))? 'form-group-error':''}}">
                                <label class="col-sm-2 form-control-label">New password:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control maxlength-simple"
                                            name="new_password" maxlength="25" value="">
                                    @if ($errors->has('new_password'))
                                        <small class="text-muted">{{ $errors->first('new_password') }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{($errors->has('confirm_password'))? 'form-group-error':''}}">
                                <label class="col-sm-2 form-control-label">Confirm password:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control maxlength-simple"
                                            name="confirm_password" maxlength="25" value="">
                                    @if ($errors->has('confirm_password'))
                                        <small class="text-muted">{{ $errors->first('confirm_password') }}</small>
                                    @endif
                                </div>
                            </div>

                            <br>
                            <p style="float: right;">
                                <button  class="btn btn-success"
                                type='submit'>
                                <i class="font-icon font-icon-ok"></i>&nbsp;&nbsp;&nbsp;Change password</button>
                            </p>
                            <br>
                            <br>
                        </form>
                    </div><!--.tab-pane-->
                    <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-3">
                        
                    </div><!--.tab-pane-->
                    <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-4">

                    </div><!--.tab-pane-->
                    <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-5">
                        
                    </div><!--.tab-pane-->
                    <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-6">
                        
                    </div><!--.tab-pane-->
                </div><!--.tab-content-->
            </section><!--.tabs-section-->
            
        </section><!--.box-typical-->
    </div><!--.col- -->

    
</div><!--.row-->
@endsection