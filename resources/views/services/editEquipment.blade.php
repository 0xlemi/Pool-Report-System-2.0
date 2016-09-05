<!-- Modal for email preview -->
	<div class="modal fade" id="equipmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" :class="{'modal-lg' : (equipmentFocus == 1)}" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">@{{ equipmentModalTitle }}</h4>
	      </div>
	      <div class="modal-body">
				<div class="row">
					<div class="col-md-12" v-show="checkEquipmentFocusIs(1)">
							<div id="equipmentToolbar">
								<button type="button" class="btn btn-primary"
                                            @click="setEquipmentFocus(2)">
									<i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;&nbsp;Add Equipment
                                </button>
							</div>
							<div class="table-responsive">
							<table id="equipmentTable"
								   class="table"
								   data-url='{{ $default_table_url }}'
								   data-toolbar="#equipmentToolbar"
								   data-search="true"
								   data-show-export="true"
								   data-page-size="5"
								   data-export-types="['excel', 'pdf']"
								   data-minimum-count-columns="2"
								   data-pagination="true"
								   data-show-footer="false"
								   >
								<thead>
								    <tr>
								        <th data-field="id" data-sortable="true" data-visible="false">ID</th>
								        <th data-field="kind" data-sortable="true">Kind</th>
								        <th data-field="type" data-sortable="true">Type</th>
								        <th data-field="brand" data-sortable="true">Brand</th>
								        <th data-field="model" data-sortable="true">Model</th>
								        <th data-field="capacity" data-sortable="true">Capacity</th>
								    </tr>
								</thead>
							</table>
						</div>
					</div>

                    <!-- Create new Equipment -->
					<div class="col-md-12" v-show="checkEquipmentFocusIs(2)">

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Kind</label>
							<div class="col-sm-10">
								<input type="text" name="kind" class="form-control" v-model="equipmentKind">
							</div>
						</div>

                       <div class="form-group row">
							<label class="col-sm-2 form-control-label">Type</label>
							<div class="col-sm-10">
								<input type="text" name="type" class="form-control" v-model="equipmentType">
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Brand</label>
							<div class="col-sm-10">
								<input type="text" name="brand" class="form-control" v-model="equipmentBrand">
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Model</label>
							<div class="col-sm-10">
								<input type="text" name="model" class="form-control" v-model="equipmentModel">
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Capacity</label>
							<div class="col-sm-10">
								<input type="number" name="capacity" class="form-control" v-model="equipmentCapacity">
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Units</label>
							<div class="col-sm-10">
								<input type="text" name="units" class="form-control" v-model="equipmentUnits">
							</div>
						</div>

                    </div>

					<div class="col-md-12" v-show="checkEquipmentFocusIs(3)">
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
								<input type="text" readonly class="form-control" value="@{{ equipmentCapacity+' '+equipmentUnits }}">
							</div>
						</div>
						<br>

						<div v-if="equipmentPhotos[0].order != 0">
							<h4>Equipment Photos</h4>
							<hr>
							<photo-list :data="equipmentPhotos"></photo-list>
						</div>
					</div>
                    <div class="col-md-12" v-show="checkEquipmentFocusIs(4)">

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Kind</label>
							<div class="col-sm-10">
								<input type="text" name="kind" class="form-control" v-model="equipmentKind">
							</div>
						</div>

                       <div class="form-group row">
							<label class="col-sm-2 form-control-label">Type</label>
							<div class="col-sm-10">
								<input type="text" name="type" class="form-control" v-model="equipmentType">
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Brand</label>
							<div class="col-sm-10">
								<input type="text" name="brand" class="form-control" v-model="equipmentBrand">
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Model</label>
							<div class="col-sm-10">
								<input type="text" name="model" class="form-control" v-model="equipmentModel">
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Capacity</label>
							<div class="col-sm-10">
								<input type="number" name="capacity" class="form-control" v-model="equipmentCapacity">
							</div>
						</div>

                        <div class="form-group row">
							<label class="col-sm-2 form-control-label">Units</label>
							<div class="col-sm-10">
								<input type="text" name="units" class="form-control" v-model="equipmentUnits">
							</div>
						</div>

                        <br>
                        <h4>Equipment Photos</h4>
						<hr>
                        <!-- Dropzone -->
                    </div>
				</div>
	      </div>
	      <div class="modal-footer">
			<button v-show="!checkEquipmentFocusIs(1)" class="btn btn-warning" type="button" @click="openEquimentList()">
				<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Back to the table</button>
            <button v-show="checkEquipmentFocusIs(2)" class="btn btn-success" type="button" @click="sendEquipment('create')">
				<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Add Equipment</button>
            <button v-show="checkEquipmentFocusIs(4)" class="btn btn-success" type="button" @click="sendEquipment('edit')">
				<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Edit Equipment</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>
