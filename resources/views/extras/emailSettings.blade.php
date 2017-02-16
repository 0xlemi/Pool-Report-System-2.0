@extends('landing.mainClean')
<style>
.material-switch > input[type="checkbox"] {
    display: none;
}

.material-switch > label {
    cursor: pointer;
    height: 0px;
    position: relative;
    width: 40px;
}

.material-switch > label::before {
    background: rgb(0, 0, 0);
    box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
    border-radius: 8px;
    content: '';
    height: 16px;
    margin-top: 2px;
    position:absolute;
    opacity: 0.3;
    transition: all 0.4s ease-in-out;
    width: 40px;
}
.material-switch > label::after {
    background: rgb(255, 255, 255);
    border-radius: 16px;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
    content: '';
    height: 24px;
    left: -4px;
    margin-top: 2px;
    position: absolute;
    top: -4px;
    transition: all 0.3s ease-in-out;
    width: 24px;
}
.material-switch > input[type="checkbox"]:checked + label::before {
    background: inherit;
    opacity: 0.5;
}
.material-switch > input[type="checkbox"]:checked + label::after {
    background: inherit;
    left: 20px;
}
</style>

@section('content')
<section  class="p-y-lg faqs schedule">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
                <h4 class="text-center m-b-md">When do you what to recive emails?</h4>
                <br>
                <form method="POST" action="{{ url('/unsubscribe') }}">
					{{ csrf_field() }}
                    <input type="hidden" name='token' value={{ $token }} >
                    <!-- List group -->
                    <ul class="list-group">
                        @foreach($notifications as $notification)
                            <li class="list-group-item">
                                <label>{{$notification->tag}}</label>
                                <div class="material-switch pull-right">
                                    <input id="switch{{$notification->name}}"
                                            name="{{ $notification->name }}"
                                            type="checkbox"
                                            {{ ($notification->buttons[1]->value) ? 'checked' : '' }}>
                                    <label for="switch{{$notification->name}}" class="label-success"></label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <br>
                    <button type="sumbit" class="btn btn-blue text-edit">Change Settings</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
