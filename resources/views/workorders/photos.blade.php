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

				<!-- Before Work is Done Photos -->
				<div class="col-md-12" v-show="checkPhotoFocus(1)">
						<photo-list :data="workOrderBeforePhotos" :object-id="workId"
										:can-delete="false" :photos-url="'{{ url('works/photos') }}'">
						</photo-list>
				</div>

				<div class="col-md-12" v-show="checkPhotoFocus(2)">
					<photo-list :data="workOrderAfterPhotos" :object-id="workId"
									:can-delete="false" :photos-url="'{{ url('works/photos') }}'">
					</photo-list>
				</div>


				</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>
