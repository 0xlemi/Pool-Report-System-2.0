<h4>Change Password</h4>
<br>

<form method="POST" action="{{ url('settings/password') }}" v-ajax title="Password Changed" message="The password was changed successfully">
  {{ csrf_field() }}
  {{ method_field('PATCH') }}
  <input type="hidden" name="id" value="{{ $user->id }}">
  <div class="form-group row {{($errors->has('old_password'))? 'form-group-error':''}}">
      <label class="col-sm-2 form-control-label">Old password:</label>
      <div class="col-sm-10">
          <input type="text" class="form-control maxlength-simple"
                  name="old_password" maxlength="40" value="">
          @if ($errors->has('old_password'))
              <small class="text-muted">{{ $errors->first('old_password') }}</small>
          @endif
      </div>
  </div>

  <div class="form-group row {{($errors->has('new_password'))? 'form-group-error':''}}">
      <label class="col-sm-2 form-control-label">New password:</label>
      <div class="col-sm-10">
          <input type="password" class="form-control maxlength-simple"
                  name="new_password" maxlength="40" value="">
          @if ($errors->has('new_password'))
              <small class="text-muted">{{ $errors->first('new_password') }}</small>
          @endif
      </div>
  </div>

  <div class="form-group row {{($errors->has('confirm_password'))? 'form-group-error':''}}">
      <label class="col-sm-2 form-control-label">Confirm password:</label>
      <div class="col-sm-10">
          <input type="password" class="form-control maxlength-simple"
                  name="confirm_password" maxlength="40" value="">
          @if ($errors->has('confirm_password'))
              <small class="text-muted">{{ $errors->first('confirm_password') }}</small>
          @endif
      </div>
  </div>

  <br>
  <p style="float: right;">
      <button  class="btn btn-success"
      type='submit'>Change password</button>
  </p>
</form>
