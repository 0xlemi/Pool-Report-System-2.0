<!-- Modal for email preview -->
	<div class="modal fade" id="workModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">@{{ workModalTitle }}</h4>
	      </div>
	      <div class="modal-body">
				<div class="row">

                    <!-- Create new Work -->
					<div class="col-md-12" v-show="checkWorkFocusIs(1)">

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Title</label>
							<div class="col-sm-10">
								<input type="text" name="title" class="form-control" v-model="workTitle">
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Technician</label>
							<div class="col-sm-10">
								<dropdown :key.sync="workTechnician.id"
									:options="{{ $technicians }}"
									:name="'technician'">
								</dropdown>
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Quantity</label>
							<div class="col-sm-10">
								<input type="text" name="quantity" class="form-control" v-model="workQuantity">
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Units</label>
							<div class="col-sm-10">
								<input type="text" name="units" class="form-control" v-model="workUnits">
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Cost</label>
							<div class="col-sm-10">
								<input type="text" name="cost" class="form-control" v-model="workCost">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Description</label>
							<div class="col-sm-10">
								<textarea rows="4" class="form-control"
										v-model="workDescription" placeholder="Describe the work done">
								</textarea>
							</div>
						</div>

                    </div>

                    <!-- Show Work -->
					<div class="col-md-12" v-show="checkWorkFocusIs(2)">

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Title</label>
							<div class="col-sm-10">
								<input type="text" name="title" readonly class="form-control" v-model="workTitle">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Technician</label>
							<div class="col-sm-10">
								<input type="text" name="coste" readonly class="form-control" style="text-indent: 40px;"
									:value="workTechnician.fullName">
                            	<img class="iconOption" :src="workTechnician.icon" alt="Technician Photo">
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Quantity</label>
							<div class="col-sm-10">
								<input type="text" name="quantity" readonly class="form-control" v-model="workQuantity">
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Units</label>
							<div class="col-sm-10">
								<input type="text" name="units" readonly class="form-control" v-model="workUnits">
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Cost</label>
							<div class="col-sm-10">
								<input type="text" name="coste" readonly class="form-control" v-model="workCost">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Description</label>
							<div class="col-sm-10">
								<textarea rows="4" class="form-control"
										v-model="workDescription" readonly placeholder="Describe the work done">
								</textarea>
							</div>
						</div>

						<div v-if="(typeof workPhotos[0] !== 'undefined')">
							<hr>
							<photo-list :data="workPhotos" :object-id="workId"
										:can-delete="false" :photos-url="'{{ url('works/photos') }}'"
										>
							</photo-list>
						</div>

					</div>

                    <!-- Edit Work -->
                    <div class="col-md-12" v-show="checkWorkFocusIs(3)">

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Title</label>
							<div class="col-sm-10">
								<input type="text" name="title" class="form-control" v-model="workTitle">
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Technician</label>
							<div class="col-sm-10">
								<dropdown :key.sync="workTechnician.id"
										:options="{{ $technicians }}"
										:name="'technician'">
								</dropdown>
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Quantity</label>
							<div class="col-sm-10">
								<input type="text" name="quantity" class="form-control" v-model="workQuantity">
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Units</label>
							<div class="col-sm-10">
								<input type="text" name="units" class="form-control" v-model="workUnits">
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Cost</label>
							<div class="col-sm-10">
								<input type="text" name="coste" class="form-control" v-model="workCost">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Description</label>
							<div class="col-sm-10">
								<textarea rows="4" class="form-control"
										v-model="workDescription" placeholder="Describe the work done">
								</textarea>
							</div>
						</div>

						<hr>
						<photo-list :data="workPhotos" :object-id="workId"
										:can-delete="true" :photos-url="'{{ url('works/photos') }}'">
						</photo-list>
						<div class="col-md-12">
	                        <!-- Dropzone -->
							<div class="box-typical-upload box-typical-upload-in">
		                        <div class="drop-zone">
		                            <form id="worksDropzone" action="{{ url('/') }}" class="dropzone">
		                            	{{ csrf_field() }}
		                            	<div class="dz-message" data-dz-message><span><i class="font-icon font-icon-cloud-upload-2"></i>
		                                <div class="drop-zone-caption">Drag file or click to add photos</div></span></div>
		                            </form>
		                        </div>
		                    </div><!-- End Dropzone -->
						</div>

                    </div><!-- End Edit Equipment -->

				</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            <button v-show="checkWorkFocusIs(1)" class="btn btn-success" type="button" @click="sendWork('create')">
				<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Create Work</button>
			<button v-show="checkWorkFocusIs(2)" class="btn btn-danger" type="button" @click="destroyWork()">
				<i class="font-icon font-icon-close-2"></i>&nbsp;&nbsp;&nbsp;Delete</button>
            <button v-show="checkWorkFocusIs(2)" class="btn btn-primary" type="button" @click="setWorkFocus(3)">
				<i class="font-icon font-icon-pencil"></i>&nbsp;&nbsp;&nbsp;Edit</button>
            <button v-show="checkWorkFocusIs(3)" class="btn btn-warning" type="button" @click="setWorkFocus(2)">
				<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back</button>
            <button v-show="checkWorkFocusIs(3)" class="btn btn-success" type="button" @click="sendWork('edit')">
				<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Update Work</button>
	      </div>
	    </div>
	  </div>
	</div>
