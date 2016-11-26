<template>

<location-picker :latitude="latitude" :longitude="longitude" :errors="errors">
</location-picker>

<div class="form-group row" :class="[(errors.hasOwnProperty('address_line')) ? 'form-group-error': '']">
	<label class="col-sm-2 form-control-label">Street and number:</label>
	<div class="col-sm-10">
		<input type="text" class="form-control maxlength-simple"
				name="address_line" maxlength="50" :value="addressLine">
		<small v-if="errors.hasOwnProperty('address_line')" class="text-muted">{{ errors.address_line[0] }}</small>
	</div>
</div>

<div class="form-group row" :class="[(errors.hasOwnProperty('city')) ? 'form-group-error': '']">
	<label class="col-sm-2 form-control-label">City:</label>
	<div class="col-sm-10">
		<input type="text" class="form-control maxlength-simple"
				name="city" maxlength="30" :value="city">
		<small v-if="errors.hasOwnProperty('city')" class="text-muted">{{ errors.city[0] }}</small>
	</div>
</div>

<div class="form-group row" :class="[(errors.hasOwnProperty('state')) ? 'form-group-error': '']">
	<label class="col-sm-2 form-control-label">State:</label>
	<div class="col-sm-10">
		<input type="text" class="form-control maxlength-simple"
				name="state" maxlength="30" :value="state">
		<small v-if="errors.hasOwnProperty('state')" class="text-muted">{{ errors.state[0] }}</small>
	</div>
</div>

<div class="form-group row" :class="[(errors.hasOwnProperty('postal_code')) ? 'form-group-error': '']">
	<label class="col-sm-2 form-control-label">Postal Code:</label>
	<div class="col-sm-10">
		<input type="text" class="form-control maxlength-simple"
				name="postal_code" maxlength="15" :value="postalCode">
		<small v-if="errors.hasOwnProperty('postal_code')" class="text-muted">{{ errors.postal_code[0] }}</small>
	</div>
</div>

<div class="form-group row" :class="[(errors.hasOwnProperty('country')) ? 'form-group-error': '']">
	<label class="col-sm-2 form-control-label">Country:</label>
	<div class="col-sm-10">
			<countries :code.sync="country" ></countries>
		<small v-if="errors.hasOwnProperty('country')" class="text-muted">{{ errors.country[0] }}</small>
	</div>
</div>

</template>

<script>
import countries from './countries.vue';
import locationPicker from './locationPicker.vue';

export default {
    props: [
		'addressLine', 'city', 'state',
		'postalCode', 'country', 'latitude',
		'longitude', 'errors'
	],
    components: {
        locationPicker,
        countries
    },
    events: {
        addressChanged(address){
            this.addressLine = address.addressLine1;
            this.city = address.city;
            this.state = address.state;
            this.postalCode = address.postalCode;
            this.country = address.country;
        }
    },

}
</script>
