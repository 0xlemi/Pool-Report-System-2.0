<!-- Modal for email preview -->
	<div class="modal fade" id="photosWorkOrderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">@{{ photoModalTitle }}</h4>
	      </div>
	      <div class="modal-body">
				<div class="row">

				<!-- Show Before Work is Done Photos -->
				<div class="col-md-12" v-show="checkPhotoFocus(1)">
					<photo-list :data="workOrderBeforePhotos" :object-id="workOrderId"
									:can-delete="false" :photos-url="'workorders/photos/before'">
					</photo-list>
				</div>

				<!-- Show After Work is Done Photos -->
				<div class="col-md-12" v-show="checkPhotoFocus(2)">
					<photo-list :data="workOrderAfterPhotos" :object-id="workOrderId"
									:can-delete="false" :photos-url="'workorders/photos/after'">
					</photo-list>
				</div>


				<!-- Edit After Work is Done Photos -->
				<div class="col-md-12" v-show="checkPhotoFocus(3)">

					<div class="row">
						<div class="col-md-12">
							<photo-list :data="workOrderBeforePhotos" :object-id="workOrderId"
											:can-delete="true" :photos-url="'workorders/photos/before'">
							</photo-list>
						</div>
					</div>
					<hr>

					<div class="row">
						<div class="col-md-12">
	                        <!-- Dropzone -->
							<div class="box-typical-upload box-typical-upload-in">
		                        <div class="drop-zone">
		                            <form id="workOrderDropzone" action="{{ url('/workorders/photos/before/'.$workOrder->id) }}" class="dropzone">
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
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>
