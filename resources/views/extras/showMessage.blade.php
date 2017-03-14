@extends('landing.mainClean')
<style>
img.displayed {
    display: block;
    margin-left: auto;
    margin-right: auto }
</style>

@section('content')
<section  class="p-y-lg faqs schedule">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h2 class="text-center m-b-md">{{ $title }}</h2>
                <br>
                <br>
                @if($isSuccess)
                <img class="displayed" src="{{ \Storage::url('images/assets/app/checkbox.png') }}" width="150px"/>
                @else
                <img class="displayed" src="{{ \Storage::url('images/assets/app/cross.png') }}" width="150px"/>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
