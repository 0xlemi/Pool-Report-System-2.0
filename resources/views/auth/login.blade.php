@extends('landing.main')

@section('content')
<section id="login" class="login  bg-color">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 text-center subscription">
                <h4 class="m-t-lg m-b-md text-left center-md">Welcome Back.</h4>
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                  {!! csrf_field() !!}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="text-edit">Email Address/Username</label>
                        <input type="text" class="form-control" name="email" placeholder="Enter your Email/Username" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="text-edit">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter your Password" value="">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label class="text-edit">
                                <input type="checkbox" name="remember">Remember Me
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-blue">LOGIN</button>
                    </div>

                </form>

                <div class="forgot text-left">
                    <a href="{{ url('/password/reset') }}" class="text-edit">Forgot your password?</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
