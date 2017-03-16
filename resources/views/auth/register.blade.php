@extends('landing.main')
@section('content')
<section id="login" class="login  bg-color">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 text-center subscription">
                <h4 class="m-t-lg m-b-0 text-left center-md">Let's get started</h4>
                <p class="lead text-left m-b-md center-md">Signin up for Pool Report System is free</p>
                <form class="form-horizontal" method="POST" action="{{ url('/register') }}">
                  {!! csrf_field() !!}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="text-edit">Full Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter your Full Name" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="text-edit">Email Address</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter your Email" required>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="text-edit">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter your Password" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('company_name') ? ' has-error' : '' }}">
                        <label for="company_name" class="text-edit">Company Name</label>
                        <input type="text" class="form-control" name="company_name" placeholder="Enter your Company Name" required>
                        @if ($errors->has('company_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('company_name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('timezone') ? ' has-error' : '' }}">
                        <label for="timezone" class="text-edit">Timezone</label>
                        <timezone-dropdown class="form-control" :timezone="hello" :timezone-list="{{ json_encode($timezoneList) }}"></timezone-dropdown>
                        @if ($errors->has('timezone'))
                            <span class="help-block">
                                <strong>{{ $errors->first('timezone') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-blue">SIGN UP</button>
                    </div>

                </form>
                <p class="terms m-t">By clicking Signup you agree to the <a href="{{ url('/terms') }}" class="f-w-700">Terms and Privacy Policy</a>.</p>
                <p class="terms"> Already have a Pool Report System account? <a href="{{ url('/login') }}" class="f-w-700">Sign in</a>.</p>
            </div>
        </div>
    </div>
</section>
@endsection
