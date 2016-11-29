<template>

        <!-- Button to activate the modal -->
<div class="col-sm-10">
	<button type="button" class="btn btn-warning"
			data-toggle="modal" data-target="#changePasswordModal">
		<i class="fa fa-key"></i>&nbsp;&nbsp;&nbsp;Change Password
	</button>
</div>

<!-- Modal for Change Password Settings -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Change Password</h4>
      </div>
      <div class="modal-body">
			<div class="row">
                <div class="col-md-12">

                    <fieldset class="form-group">
						<input type="password" class="form-control" placeholder="Your current password">
					</fieldset>

                    <fieldset class="form-group">
						<input type="password" class="form-control" placeholder="Your new password">
					</fieldset>

                </div>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success">
			<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Change
		</button>
      </div>
    </div>
  </div>
</div>

</template>

<script>

export default {

}
</script>
