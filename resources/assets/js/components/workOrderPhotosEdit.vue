<template>

<!-- Buttons  -->
<div class="form-group row">
	<label class="col-sm-2 form-control-label">Photos</label>
	<div class="col-sm-10">

		<button type="button" class="btn btn-warning" data-toggle="modal"
                data-target="#workOrderPhotosModal">
			<i class="fa fa-camera"></i>
            &nbsp;&nbsp;&nbsp;Before Work
		</button>

	</div>
</div>



<!-- Modal for work order photos preview -->
<div class="modal fade" id="workOrderPhotosModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Photos</h4>
      </div>
      <div class="modal-body">
		<div class="row">

            <!-- Edit After Work is Done Photos -->
			<div class="col-md-12">

				<div class="row">
					<div class="col-md-12">
						<photo-list :data="photos" :object-id="workOrderId"
										:can-delete="true" :photos-url="'workorders/photos/before'">
						</photo-list>
					</div>
				</div>
				<hr>

				<div class="row">
					<div class="col-md-12">
                        <!-- Dropzone -->
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
</template>

<script>
import photoList from './photoList.vue';

export default {
    props: [ 'workOrderId' ],
    components: {
        photoList
    },
    data(){
        return {
            photos: null,
        }
    },
    methods:{
        refreshPhotos(){
            this.$http.get(Laravel.url+'workorders/photos/before/'+this.workOrderId).then((response) => {
                this.photos = response.data;
            });
        }
    },
    ready(){
        this.refreshPhotos();
    }

}
</script>
