<!-- Modal for email preview -->
	<div class="modal fade" id="equipmentObjectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Equipment</h4>
	      </div>
	      <div class="modal-body">
				<div class="row">
					<div class="col-md-12">
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Equipment photo</label>
								<div class="col-sm-10">
									<div class="col-md-4 m-b-md">
		                                <div class="gallery-col">
											<article class="gallery-item">
												<img class="gallery-picture" src="{{ url($service->thumbnail()) }}" alt="" height="158">
												<div class="gallery-hover-layout">
													<div class="gallery-hover-layout-in">
														<p class="gallery-item-title">Equipment Photo</p>
														<div class="btn-group">
															<a class="fancybox btn" href="{{ url($service->image()) }}" title="Equipment Photo">
																<i class="font-icon font-icon-eye"></i>
															</a>
														</div>
													</div>
												</div>
											</article>
										</div><!--.gallery-col-->
		                            </div><!--.col-->
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Kind</label>
								<div class="col-sm-10">
									<input type="text" readonly class="form-control" value="@{{ equipmentKind }}">
								</div>
							</div>
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
					</div>
				</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>
