<form method="POST" action="{{ url('settings/account') }}" enctype="multipart/form-data" v-ajax title="Saved" message="Your account information has been updated">
  {{ csrf_field() }}
  {{ method_field('PATCH') }}

  <div class="form-group row">
      <label class="col-sm-2 form-control-label">Name:</label>
      <div class="col-sm-10">
          <input type="text" class="form-control maxlength-simple"
                  name="name" maxlength="25" v-model="objectName" value="{{ $user->userable()->name }}">
      </div>
  </div>

@if($user->isTechnician() || $user->isSupervisor())
  <div class="form-group row">
      <label class="col-sm-2 form-control-label">Last Name:</label>
      <div class="col-sm-10">
          <input type="text" class="form-control maxlength-simple"
                  name="last_name" maxlength="25" v-model="objectLastName" value="{{ $user->userable()->last_name }}">
      </div>
  </div>
@endif

  <div class="form-group row ">
      <label class="col-sm-2 form-control-label">Language:</label>
      <div class="col-sm-10">
            <select class="bootstrap-select bootstrap-select-arrow" name="language">
				<option value="en" {{ ($admin->language == 'en') ? 'selected':'' }}>
					English
				</option>
				<option value="es" {{ ($admin->language == 'es') ? 'selected':'' }}>
					Español
				</option>
			</select>
      </div>
  </div>

@if($user->isAdministrator())
  <div class="form-group row">
      <label class="col-sm-2 form-control-label">Timezone:</label>
      <div class="col-sm-10">
            <select class="bootstrap-select bootstrap-select-arrow" name="timezone" data-live-search="true">
                @foreach($timezones as $region => $list)
                    <optgroup label="{{ $region }}">
                        @foreach($list as $timezone => $name)
                            <option value="{{ $timezone }}"
                            {{ ($admin->timezone == $timezone) ? 'selected':'' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
      </div>
  </div>
@endif
  <br>
  <p style="float: right;">
      <button  class="btn btn-success"
      type='submit'>Save changes</button>
  </p>
  <br>
</form>
