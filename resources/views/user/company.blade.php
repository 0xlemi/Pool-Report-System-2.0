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
        type='submit'>Save Changes</button>
    </p>
    <br>
    <br>
</form>
