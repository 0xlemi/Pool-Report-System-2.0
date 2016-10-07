<br>
<form action="{{ url('admin/billing') }}" method="POST" id="payment-form">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-6">
            <alert :type="'danger'" :message.sync="alertMessage" :active.sync="alertOpen"></alert>    
        </div>
    </div>

    <fieldset class="form-group">
		<label class="form-label semibold">Card Number</label>
        <div class="row">
            <div class="col-md-4">
		        <input type="text" size="20" data-stripe="number" class="form-control" placeholder="xxxx xxxx xxxx xxxx">
            </div>
        </div>
	</fieldset>

    <fieldset class="form-group">
		<label class="form-label semibold">Expiration Date</label>
        <div class="row">
            <div class="col-md-2">
            	<select class="bootstrap-select bootstrap-select-arrow" data-stripe="exp_month">
                    <option selected value='01'>Janaury</option>
                    <option value='02'>February</option>
                    <option value='03'>March</option>
                    <option value='04'>April</option>
                    <option value='05'>May</option>
                    <option value='06'>June</option>
                    <option value='07'>July</option>
                    <option value='08'>August</option>
                    <option value='09'>September</option>
                    <option value='10'>October</option>
                    <option value='11'>November</option>
                    <option value='12'>December</option>
            	</select>
            </div>
            <div class="col-md-2">
            	<select class="bootstrap-select bootstrap-select-arrow" data-stripe="exp_year">
                    @for ($i = 0; $i <= 20; $i++)
                        <option value='{{ date("y")+$i }}'>{{ date("Y")+$i }}</option>
                    @endfor
            	</select>
            </div>
        </div>
	</fieldset>

    <fieldset class="form-group">
		<label class="form-label semibold">CVC Number</label>
        <div class="row">
            <div class="col-md-2">
        	    <input type="text" size="4" data-stripe="cvc" class="form-control" placeholder="CVC">
            </div>
        </div>
		<small class="text-muted">The number on the back of the card.</small>
	</fieldset>

    <button type="button" class="btn btn-primary" @click="submitCreditCard">Submit Payment</button>
</form>
