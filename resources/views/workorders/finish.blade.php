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



				</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button class="btn btn-success" type="button" @click="markedAsFinished()">
				<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Mark as Finished</button>
	      </div>
	    </div>
	  </div>
	</div>
