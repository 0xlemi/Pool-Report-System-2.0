<!-- Modal for chemicals preview -->
	<div class="modal fade" id="chemicalModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" :class="{'modal-lg' : (equipmentFocus == 1)}" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">@{{ chemicalsModalTitle }}</h4>
	      </div>
	      <div class="modal-body">
				<div class="row">
					<div class="col-md-12" v-show="checkEquipmentFocusIs(1)">
							<div id="chemicalsToolbar">
								<button type="button" class="btn btn-primary"
                                            @click="setEquipmentFocus(2)">
									<i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;&nbsp;Add Chemical
                                </button>
							</div>
							<div class="table-responsive">
							<table id="chemicalsTable"
								   class="table"
								   data-url='{{ $default_table_url }}'
								   data-toolbar="#chemicalsToolbar"
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
								        <th data-field="kind" data-sortable="true">Name</th>
								        <th data-field="type" data-sortable="true">Amount</th>
								    </tr>
								</thead>
							</table>
						</div>
					</div>

                    <!-- Create new Equipment -->
					<div class="col-md-12" v-show="checkEquipmentFocusIs(2)">

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
					</div>

					<!-- Edit Equipment -->
                    <div class="col-md-12" v-show="checkEquipmentFocusIs(4)">

                    </div><!-- End Edit Equipment -->

				</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button v-show="!checkEquipmentFocusIs(1)" class="btn btn-warning" type="button" @click="openEquimentList()">
				<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back</button>
            <button v-show="checkEquipmentFocusIs(2)" class="btn btn-success" type="button" @click="sendEquipment('create')">
				<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Add Equipment</button>
			<button v-show="checkEquipmentFocusIs(4)" class="btn btn-danger" type="button" @click="destroyEquipment()">
				<i class="font-icon font-icon-close-2"></i>&nbsp;&nbsp;&nbsp;Delete</button>
            <button v-show="checkEquipmentFocusIs(4)" class="btn btn-success" type="button" @click="sendEquipment('edit')">
				<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Edit Equipment</button>
	      </div>
	    </div>
	  </div>
	</div>
