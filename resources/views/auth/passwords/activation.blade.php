@extends('landing.main')

@section('content')
<section id="login" class="login  bg-color">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 text-center subscription">
                <h4 class="m-t-lg  text-left center-md">Almost Done.</h4>
                <h5 class=" m-b-md text-left ">You just need to set your new password.</h5>
                <form class="form-horizontal" role="form" method="POST" action="{{ url('activate/password') }}">
                  {!! csrf_field() !!}

                    <input type="hidden" name="token" value="{{ $token->token }}">

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="text-edit">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter your password" value="{{ old('password') }}">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="password_confirmation" class="text-edit">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Enter your password again" value="{{ old('password_confirmation') }}">
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="m-t-md form-group">
                        <button type="submit" class="btn btn-blue">CREATE ACCOUNT</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
@endsection
