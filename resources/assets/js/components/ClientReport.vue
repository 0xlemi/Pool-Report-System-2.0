<template>
<div class="col-xl-8 col-xl-offset-2 col-lg-12 col-lg-offset-0">
    <section class="card">
    	<header class="card-header card-header-xxl">
    		Pool Photos
    	</header>
    	<div class="card-block">
            <div class="row">
                <photo-list :data="photos" :can-delete="false" list-class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-5 m-b-md">
            	</photo-list>
            </div>
    	</div>
        <button @click="morePhotos = !morePhotos" type="button" class="btn btn-block btn-default-outline">{{ photosButtonMessage }}</button>
    </section>
</div>
</template>

<script>
import photoList from './photoList.vue';

export default {
    props: ['report'],
    components:{
        photoList
    },
    data(){
        return {
            morePhotos: false,
        }
    },
    methods:{

    },
    computed:{
        photos(){
            let result;
            if(this.morePhotos){
                result = this.report.photos;
            }else{
                result = this.report.photos.slice(0,3);
            }
            return result;
        },
        photosButtonMessage(){
            return (this.morePhotos) ? 'Show less' : 'Show more';
        }
    },

}
</script>
