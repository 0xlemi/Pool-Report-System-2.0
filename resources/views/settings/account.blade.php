<form method="POST" action="{{ url('settings/account') }}" enctype="multipart/form-data" v-ajax title="Saved" message="Your account information has been updated">
  {{ csrf_field() }}
  {{ method_field('PATCH') }}

  <div class="form-group row {{($errors->has('name'))? 'form-group-error':''}}">
      <label class="col-sm-2 form-control-label">Name:</label>
      <div class="col-sm-10">
          <input type="text" class="form-control maxlength-simple"
                  name="name" maxlength="25" v-model="adminName" value="{{ $user->getFullName() }}">
          @if ($errors->has('name'))
              <small class="text-muted">{{ $errors->first('name') }}</small>
          @endif
      </div>
  </div>

  <div class="form-group row {{($errors->has('language'))? 'form-group-error':''}}">
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
          @if ($errors->has('language'))
              <small class="text-muted">{{ $errors->first('language') }}</small>
          @endif
      </div>
  </div>

  <div class="form-group row {{($errors->has('timezone'))? 'form-group-error':''}}">
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
          @if ($errors->has('timezone'))
              <small class="text-muted">{{ $errors->first('timezone') }}</small>
          @endif
      </div>
  </div>
  <br>
  <p style="float: right;">
      <button  class="btn btn-success"
      type='submit'>Save changes</button>
  </p>
  <br>
</form>
