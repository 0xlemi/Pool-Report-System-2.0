@extends('layouts.app')
@section('content')

<div class="page-center">
            <div class="container-fluid">
                <div class="page-error-box">
                    <div class="error-code">404</div>
                    <div class="error-title">Sorry, page not found.</div>
                    <div class="error">{{ $exception->getMessage() }}</div>
                    <br>
                    <a href="{{ url()->previous() }}" class="btn btn-rounded">Go Back</a>
                </div>
            </div>
    </div><!--.page-center-->

@endsection
