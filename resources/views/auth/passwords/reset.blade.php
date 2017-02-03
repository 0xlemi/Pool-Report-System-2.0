@extends('landing.main')

<!-- Main Content -->
@section('content')
<section id="login" class="login  bg-color">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 text-center subscription">
                <h4 class="m-t-lg m-b-0 text-left center-md">Password Reset</h4>
                <p class="lead text-left m-b-md center-md"></p>
                <form class="form-horizontal" method="POST" action=" {{ url('/password/reset') }}">
                    {!! csrf_field() !!}

                    <input type="hidden" name="token" value="{{ $token }}">


                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="text-edit">Email Address</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter your Email" value="{{ $email or old('email') }}">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="text-edit">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter your new password">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="password_confirmation" class="text-edit">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm your new password">
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-blue"><i class="fa fa-btn fa-refresh"></i>&nbsp;&nbsp;&nbsp;RESET PASSWORD
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
@endsection
