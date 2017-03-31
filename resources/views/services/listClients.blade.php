<!-- Modal for email preview -->
	<div class="modal fade" id="clientsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Client List</h4>
	      </div>
	      <div class="modal-body">
				<div class="row">
					<div class="col-md-12">
                        <div id="toolbar">
							<h3><strong>Clients Related To This Service</strong></h3>
						</div>
						<div class="table-responsive">
							<table class="generic_table"
								   class="table"
								   data-toolbar="#toolbar"
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
								        <th data-field="id" data-sortable="true">#</th>
								        <th data-field="name" data-sortable="true">Name</th>
								        <th data-field="email" data-sortable="true">Email</th>
								        <th data-field="type" data-sortable="true">Type</th>
								    </tr>
								</thead>
								<tbody>
									@foreach ($clients as $client)
										<tr>
											<td>{{ $client->seq_id }}</td>
											<td>{{ $client->name.' '.$client->last_name }}</td>
											<td>{{ $client->user->email }}</td>
											<td>{!! $personHelpers->styledTypeClient($client->type, true, false) !!}</td>
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
