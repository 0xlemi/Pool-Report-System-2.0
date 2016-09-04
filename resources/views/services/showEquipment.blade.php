<!-- Modal for email preview -->
	<div class="modal fade" id="equipmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" :class="{'modal-lg' : equipmentTableFocus}" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">@{{ (equipmentTableFocus) ? 'Equipment List' : equipmentKind }}</h4>
	      </div>
	      <div class="modal-body">
				<div class="row">
					<div class="col-md-12" v-show="equipmentTableFocus">
							<div id="equipmentToolbar">
								<h3><strong>List of Pool Equipment</strong></h3>
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
					<div class="col-md-12" v-else>
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
						<br>

						<div v-if="equipmentPhotos[0].order != 0">
							<h4>Equipment Photos</h4>
							<hr>
							<photo-list :data="equipmentPhotos"></photo-list>
						</div>
					</div>
				</div>
	      </div>
	      <div class="modal-footer">
			<button v-show="!equipmentTableFocus" class="btn btn-warning" type="button" @click="openEquimentList()">
				<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Back to the table</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>
