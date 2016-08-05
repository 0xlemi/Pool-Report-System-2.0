<h4>Change Email</h4>
<br>
<form method="POST" action="{{ url('settings/changeEmail') }}" v-ajax title="Email Changed" message="The email was changed successfully">
  {{ csrf_field() }}
  {{ method_field('PATCH') }}

  <div class="form-group row">
      <label class="col-sm-2 form-control-label">Old password:</label>
      <div class="col-sm-10">
          <input type="password" class="form-control maxlength-simple"
                  name="old_password" maxlength="40" value="">
      </div>
  </div>

  <div class="form-group row">
      <label class="col-sm-2 form-control-label">New email:</label>
      <div class="col-sm-10">
          <input type="text" class="form-control maxlength-simple"
                  name="new_email" maxlength="40" value="{{ $user->new_email }}">
      </div>
  </div>

  <br>
  <p style="float: right;">
      <button  class="btn btn-success"
      type='submit'>Change email</button>
  </p>
  <br>
</form>
