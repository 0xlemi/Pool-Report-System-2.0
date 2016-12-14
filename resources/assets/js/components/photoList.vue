<template>
    <div class="col-md-4 m-b-md" v-for="image in data">
        <photo :image="image" :can-delete="canDelete" :object-id="objectId" :photos-url="photosUrl"></photo>
    </div><!--.col-->
</template>

<script>
import photo from './photo.vue';

export default {
    props :['data', 'canDelete', 'objectId', 'photosUrl'],
    components:{
        photo
    },
    events:{
        removePhoto(order){
            // remove the just deleted photo from options
            let index = this.data.findIndex(data => data.order === order);
            this.data = this.data.splice(index, 1);
        }
    },
}

</script>
