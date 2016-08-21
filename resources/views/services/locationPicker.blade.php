<!-- Modal for email preview -->
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
												id="serviceAddress"
												name="serviceAddress">
					</div>
					<br>
					<br>
					<br>
					<div class="col-md-12">
						<div id="locationPicker" style="width: 650px; height: 450px;"></div>
					</div>
					<br>
					<div class="col-md-12">
						<label class="col-sm-2 form-control-label">Latitude</label>
						<input type="text" class="form-control maxlength-simple"
											id="serviceLatitude"
											name="latitude" maxlength="30">
						<label class="col-sm-2 form-control-label">Longitude</label>
						<input type="text" class="form-control maxlength-simple"
											id="serviceLongitude"
											name="longitude" maxlength="30">
					</div>
				</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-info" @click="setLocation('create')" data-dismiss="modal">
				<i class="font-icon font-icon-pin-2"></i>&nbsp;&nbsp;Only Set Location
			</button>
	        <button type="button" class="btn btn-success" @click="populateAddressFields('create')" data-dismiss="modal">
				<i class="font-icon font-icon-map"></i>&nbsp;&nbsp;Set Location and Address Fields
			</button>
	      </div>
	    </div>
	  </div>
	</div>
