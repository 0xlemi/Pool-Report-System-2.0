<form method="POST" action="{{ url('settings/company') }}" enctype="multipart/form-data" v-ajax title="Saved" message="Company profile was updated" >
    {{ csrf_field() }}
    {{ method_field('PATCH') }}

    <div class="form-group row">
        <label class="col-sm-2 form-control-label">Company Name:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control maxlength-simple"
                    name="company_name" maxlength="30" v-model="companyName" value="{{ $admin->company_name }}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 form-control-label">Website:</label>
        <div class="col-sm-10">
            <div class="input-group">
                <div class="input-group-addon">http://</div>
                <input type="text" class="form-control maxlength-simple"
                        name="website" maxlength="70" v-model="website" value="{{ $admin->website }}">
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 form-control-label">Facebook:</label>
        <div class="col-sm-10">
            <div class="input-group">
                <div class="input-group-addon">http://www.facebook.com/</div>
                <input type="text" class="form-control maxlength-simple"
                        name="facebook" maxlength="50" v-model="facebook" value="{{ $admin->facebook }}">
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 form-control-label">Twitter:</label>
        <div class="col-sm-10">
            <div class="input-group">
                <div class="input-group-addon">http://www.twitter.com/</div>
                <input type="text" class="form-control maxlength-simple"
                        name="twitter" maxlength="15" v-model="twitter" value="{{ $admin->twitter }}">
            </div>
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
