<!-- Modal for email preview -->
	<div class="modal fade" id="equipmentTableModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Equipment List</h4>
	      </div>
	      <div class="modal-body">
				<div class="row">
					<div class="col-md-12">
							<div id="equipmentToolbar">
								<h3><strong>List of Pool Equipment</strong></h3>
							</div>
							<div class="table-responsive">
							<table id="equipmentTable"
								   class="table"
								   data-toolbar="#equipmentToolbar"
								   data-search="true"
								   data-show-export="true"
								   data-export-types="['excel', 'pdf']"
								   data-minimum-count-columns="2"
								   data-pagination="true"
								   data-show-footer="false"
								   data-response-handler="responseHandler"
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
								<tbody>
									@foreach ($equipment as $equipment)
										<tr>
											<td>{{ $equipment->id }}</td>
											<td>{{ $equipment->kind }}</td>
											<td>{{ $equipment->type }}</td>
											<td>{{ $equipment->brand }}</td>
											<td>{{ $equipment->model }}</td>
											<td>{{ $equipment->capacity.' '.$equipment->units }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
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
