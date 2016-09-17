<!-- Modal for email preview -->
	<div class="modal fade" id="finishWorkOrderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Finish Work Order</h4>
	      </div>
	      <div class="modal-body">
			<div class="row">
			<div class="col-md-12">

				<div class="form-group row" :class="{'form-group-error' : (checkValidationError('end'))}">
					<label class="col-sm-2 form-control-label">Finished at</label>
					<div class="col-sm-10">
						<div class='input-group date' id="genericDatepicker">
							<input type='text' name='end' class="form-control"
									id="genericDatepickerInput"
									v-model="workOrderFinishedAt"/>
							<small v-if="checkValidationError('end')" class="text-muted">@{{ workValidationErrors.end[0] }}</small>
							<span class="input-group-addon">
								<i class="font-icon font-icon-calend"></i>
							</span>
						</div>
					</div>
				</div>

				<hr>
				<div class="col-md-12">
					<photo-list :data="workOrderAfterPhotos" :object-id="workOrderId"
									:can-delete="true" :photos-url="'{{ url('workorders/photos/after') }}'">
					</photo-list>
				</div>
				<div class="col-md-12">
                    <!-- Dropzone -->
					<div class="box-typical-upload box-typical-upload-in">
                        <div class="drop-zone">
                            <form id="genericDropzone" action="{{ url('workorders/photos/after/'.$workOrder->id) }}" method="POST" class="dropzone">
                            	{{ csrf_field() }}
                            	<div class="dz-message" data-dz-message><span><i class="font-icon font-icon-cloud-upload-2"></i>
                                <div class="drop-zone-caption">Drag file or click to add photos</div></span></div>
                            </form>
                        </div>
                    </div><!-- End Dropzone -->
				</div>

			</div>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button class="btn btn-success" type="button" @click="finishWorkOrder()">
				<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Mark as Finished</button>
	      </div>
	    </div>
	  </div>
	</div>
