@extends('landing.main')
@section('content')
 <section id="cta1-1" class="p-y-md bg-edit">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                    <div class="text-center">
                        <h1>404</h1>
                        <h3>Page Not Found.</h3>
                        <br><br><br>
                        <a href="{{ url()->previous() }}" class="btn btn-shadow btn-green text-uppercase">Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
