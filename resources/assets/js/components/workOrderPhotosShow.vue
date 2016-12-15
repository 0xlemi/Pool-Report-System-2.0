<template>

<!-- Buttons  -->
<div class="form-group row">
	<label class="col-sm-2 form-control-label">Photos</label>
	<div class="col-sm-10">

		<button type="button" class="btn btn-warning" @click="changeFocus(1)"
                data-toggle="modal" data-target="#workOrderPhotosModal">
			<i class="font-icon font-icon-picture-2"></i>
            &nbsp;&nbsp;&nbsp;Before Work
		</button>

		<button v-if="finished" type="button" class="btn btn-info" @click="changeFocus(2)"
                data-toggle="modal" data-target="#workOrderPhotosModal">
			<i class="glyphicon glyphicon-check"></i>
            &nbsp;&nbsp;After Work
		</button>

	</div>
</div>



<!-- Modal for email preview -->
<div class="modal fade" id="workOrderPhotosModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{ photoModalTitle }}</h4>
      </div>
      <div class="modal-body">
		<div class="row">

			<!-- Show Before Work is Done Photos -->
			<div class="col-md-12" v-show="focus === 1">
				<photo-list :data="beforePhotos" :object-id="workOrderId"
								:can-delete="false" :photos-url="'workorders/photos/before'">
				</photo-list>
			</div>

			<!-- Show After Work is Done Photos -->
			<div class="col-md-12" v-show="focus === 2">
				<photo-list :data="afterPhotos" :object-id="workOrderId"
								:can-delete="false" :photos-url="'workorders/photos/after'">
				</photo-list>
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
    props: [ 'workOrderId', 'finished' ],
    components: {
        photoList
    },
    data(){
        return {
            focus: null, // 1=before work  2=after work
            beforePhotos: null,
            afterPhotos: null,
        }
    },
    computed:{
        photoModalTitle: function(){
            switch (this.focus){
                case 1:
                    return 'Photos before work started';
                break;
                case 2:
                    return 'Photos after the work was finished';
                break;
                default:
                    return 'Photos';
            }
        },
    },
    methods:{
        refreshWorkOrderPhotos(focus){
            let url = '';
            if(focus === 1){
                url = Laravel.url+'workorders/photos/before/'+this.workOrderId;
            }else if(focus === 2){
                url = Laravel.url+'workorders/photos/after/'+this.workOrderId;
            }

            this.$http.get(url).then((response) => {
                if(focus == 1){
                    this.beforePhotos = response.data;
                }else if(focus == 2){
                    this.afterPhotos = response.data;
                }
            });
        },
        changeFocus($num){
            this.focus = $num;
        }
    },
    ready(){
        this.refreshWorkOrderPhotos(1);
        this.refreshWorkOrderPhotos(2);
    }

}
</script>
