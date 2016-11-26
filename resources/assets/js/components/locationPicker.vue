<template>

<!-- Button -->
<div class="form-group row">
	<div class="col-sm-2">Location:</div>
	<div class="col-sm-10">
		<button type="button" class="btn btn-primary" data-toggle="modal"
			:class="locationPickerTag.class"
			data-target="#locationPickerModal">
			<i class="{{ locationPickerTag.icon }}"></i>&nbsp;&nbsp;&nbsp;
			{{ locationPickerTag.text }}
		</button>
		<!-- <small class="text-muted">Location is required</small> -->
	</div>
</div>

<!-- Hidden inputs for regular request -->
<input type="hidden" name="latitude" :value="latitude">
<input type="hidden" name="longitude" :value="longitude">

<!-- Modal for Lacation picker -->
<div class="modal fade" id="locationPickerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Choose Service Location</h4>
      </div>
      <div class="modal-body">
			<div class="row">

				<div class="col-md-12">
					<label class="col-sm-2 form-control-label">Search:</label>
						<input type="text" class="form-control"
											id="addressField"
											name="addressField">
				</div>

				<br><br><br>
				<div class="col-md-12">
					<div id="locationPicker" style="width: 650px; height: 450px;"></div>
				</div>

				<br>
				<div class="col-md-12">
					<label class="col-sm-2 form-control-label">Latitude</label>
					<input type="text" class="form-control" id="latitude">

					<label class="col-sm-2 form-control-label">Longitude</label>
					<input type="text" class="form-control" id="longitude">
				</div>

			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info" @click="setLocation('create')" data-dismiss="modal">
			<i class="font-icon font-icon-pin-2"></i>&nbsp;&nbsp;Only Set Location
		</button>
        <button type="button" class="btn btn-success" @click="setAddressFields('create')" data-dismiss="modal">
			<i class="font-icon font-icon-map"></i>&nbsp;&nbsp;Set Location and Address Fields
		</button>
      </div>
    </div>
  </div>
</div>
</template>

<script>
let locationPicker  = require("jquery-locationpicker");

export default {

    data(){
        return {
            pickerAddressLine1: null,
            pickerCity: null,
            pickerState: null,
            pickerPostalCode: null,
            pickerCountry: null,
            pickerLatitude: null,
            pickerLongitude: null,

            latitude: null,
            longitude: null,
        }
    },
    computed: {
        locationPickerTag(){
            let attributes = {
                    'icon': 'font-icon font-icon-ok',
                    'text': 'Location Selected',
                    'class': 'btn-success'
                };
            if((this.latitude == null) || (this.longitude == null)){
                attributes = {
                    'icon': 'font-icon font-icon-pin-2',
                    'text': 'Choose Location',
                    'class': 'btn-primary'
                };
            }
            return attributes;
        },
    },
    methods: {
        setAddressFields(){
            this.setLocation();
            let address = {
                addressLine1: this.pickerAddressLine1,
                city: this.pickerCity,
                postalCode: this.pickerPostalCode,
                state: this.pickerState,
                country: this.pickerCountry,
            }
            this.$dispatch('addressChanged', address);
        },
        setLocation(){
            this.longitude = this.pickerLongitude;
            this.latitude = this.pickerLatitude;
        },
    },
    ready(){
        let locPicker = $('#locationPicker').locationpicker({
            vue: this,
            location: {latitude: 23.04457265331633, longitude: -109.70587883663177},
            radius: 0,
            inputBinding: {
            	latitudeInput: $('#latitude'),
            	longitudeInput: $('#longitude'),
            	locationNameInput: $('#addressField')
            },
            enableAutocomplete: true,
            onchanged: function (currentLocation, radius, isMarkerDropped) {
                let addressComponents = $(this).locationpicker('map').location.addressComponents;
                let vue = $(this).data("locationpicker").settings.vue;

                vue.pickerAddressLine1 = addressComponents.addressLine1;
                vue.pickerCity         = addressComponents.city;
                vue.pickerState        = addressComponents.stateOrProvince;
                vue.pickerPostalCode   = addressComponents.postalCode;
                vue.pickerCountry      = addressComponents.country;
                vue.pickerLongitude      = currentLocation.longitude;
                vue.pickerLatitude      = currentLocation.latitude;
            },
            oninitialized: function(component) {
                let addressComponents = $(component).locationpicker('map').location.addressComponents;
                let startLocation = $(component).data("locationpicker").settings.location;
                let vue = $(component).data("locationpicker").settings.vue;

                vue.pickerAddressLine1 = addressComponents.addressLine1;
                vue.pickerCity         = addressComponents.city;
                vue.pickerState        = addressComponents.stateOrProvince;
                vue.pickerPostalCode   = addressComponents.postalCode;
                vue.pickerCountry      = addressComponents.country;
                vue.pickerLongitude      = startLocation.longitude;
                vue.pickerLatitude      = startLocation.latitude;
            }
        });

    }
}
</script>
