<h4>Change Password</h4>
<br>

<form method="POST" action="{{ url('settings/changePassword') }}" v-ajax title="Password Changed" message="The password was changed successfully">
  {{ csrf_field() }}
  {{ method_field('PATCH') }}
  <input type="hidden" name="id" value="{{ $user->id }}">
  <div class="form-group row">
      <label class="col-sm-2 form-control-label">Old password:</label>
      <div class="col-sm-10">
          <input type="text" class="form-control maxlength-simple"
                  name="old_password" maxlength="40" value="">
      </div>
  </div>

  <div class="form-group row">
      <label class="col-sm-2 form-control-label">New password:</label>
      <div class="col-sm-10">
          <input type="password" class="form-control maxlength-simple"
                  name="new_password" maxlength="40" value="">
      </div>
  </div>

  <div class="form-group row">
      <label class="col-sm-2 form-control-label">Confirm password:</label>
      <div class="col-sm-10">
          <input type="password" class="form-control maxlength-simple"
                  name="confirm_password" maxlength="40" value="">
      </div>
  </div>

  <br>
  <p style="float: right;">
      <button  class="btn btn-success"
      type='submit'>Change password</button>
  </p>
</form>
