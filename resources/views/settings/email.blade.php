<h4>Change Email</h4>
<br>
<form method="POST" action="{{ url('settings/email') }}" v-ajax title="Email Changed" message="The email was changed successfully">
  {{ csrf_field() }}
  {{ method_field('PATCH') }}

  <div class="form-group row {{($errors->has('old_password'))? 'form-group-error':''}}">
      <label class="col-sm-2 form-control-label">Old password:</label>
      <div class="col-sm-10">
          <input type="text" class="form-control maxlength-simple"
                  name="old_password" maxlength="25" value="">
          @if ($errors->has('old_password'))
              <small class="text-muted">{{ $errors->first('old_password') }}</small>
          @endif
      </div>
  </div>

  <div class="form-group row {{($errors->has('new_email'))? 'form-group-error':''}}">
      <label class="col-sm-2 form-control-label">New email:</label>
      <div class="col-sm-10">
          <input type="text" class="form-control maxlength-simple"
                  name="new_email" maxlength="25" value="{{ $user->new_email }}">
          @if ($errors->has('new_email'))
              <small class="text-muted">{{ $errors->first('new_email') }}</small>
          @endif
      </div>
  </div>

  <br>
  <p style="float: right;">
      <button  class="btn btn-success"
      type='submit'>Change email</button>
  </p>
  <br>
</form>
