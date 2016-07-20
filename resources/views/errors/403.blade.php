@extends('layouts.app')

@section('content')

<div class="page-center">
            <div class="container-fluid">
                <div class="page-error-box">
                    <div class="error-code">403</div>
                    <div class="error-title">You have not permission to view this.</div>
                    <div class="error">{{ $exception->getMessage() }}</div>
                    <br>
                    <a href="{{ url()->previous() }}" class="btn btn-rounded">Go Back</a>
                </div>
            </div>
    </div><!--.page-center-->

@endsection
