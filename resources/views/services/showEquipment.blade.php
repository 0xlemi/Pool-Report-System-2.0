<!-- Modal for email preview -->
	<div class="modal fade" id="equipmentObjectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">@{{ equipmentKind }}</h4>
	      </div>
	      <div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Type</label>
							<div class="col-sm-10">
								<input type="text" readonly class="form-control" value="@{{ equipmentType }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Brand</label>
							<div class="col-sm-10">
								<input type="text" readonly class="form-control" value="@{{ equipmentBrand }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Model</label>
							<div class="col-sm-10">
								<input type="text" readonly class="form-control" value="@{{ equipmentModel }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Capacity</label>
							<div class="col-sm-10">
								<input type="text" readonly class="form-control" value="@{{ equipmentCapacity }}">
							</div>
						</div>
						<h4>Pool Photos</h4>
						<hr>
						<photo-list :data="equipmentPhotos"></photo-list>	
					</div>
				</div>
	      </div>
	      <div class="modal-footer">
			  <button class="btn btn-danger" type="button" @click="openEquimentList()">
					<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

	      </div>
	    </div>
	  </div>
	</div>
