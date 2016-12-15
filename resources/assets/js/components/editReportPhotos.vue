<template>

<h4>Photos</h4>
<br>
<div class="row">
	<div class="col-md-12">
        <photo-list :data="photos" :object-id="id"
			:can-delete="true" photos-url="reports/photos" list-class="col-xxl-3 col-xl-4 col-lg-4 col-md-4 col-sm-5 m-b-md">
		</photo-list>
	</div>
</div>
<br>
<div class="row">
    <div class="col-sm-12">
    	<dropzone :url="'reports/photos/'+id"></dropzone>
    </div><!--.col-->
</div><!--.row-->

</template>

<script>
import alert from './alert.vue';
import photoList from './photoList.vue';
import dropzone from './dropzone.vue';

export default {
    props:['id'],
    components:{
        alert,
        photoList,
        dropzone
    },
    data(){
        return {
			alertMessage: '',
			alertActive: false,
            photos: {},
        }
    },
    events:{
        photoUploaded(){
			this.getPhotos(this.id);
		}
    },
    methods:{
        getPhotos(id){
            this.$http.get(Laravel.url+'reports/photos/'+id).then((response) => {
				this.photos = response.data;
            }, (response) => {
				this.alertMessage = "The images could not be retrieved, please try again.";
				this.alertActive = true;
            });
        },
    },
    ready(){
        this.getPhotos(this.id);
    }
}
</script>
