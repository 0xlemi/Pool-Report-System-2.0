<template>
    <div :class="listClass" v-for="image in data">
        <photo :image="image" :can-delete="canDelete" :object-id="objectId" :photos-url="photosUrl"></photo>
    </div><!--.col-->
</template>

<script>
import photo from './photo.vue';

export default {
    props: {
        data: null,
        canDelete: null,
        objectId: Number,
        photosUrl: String,
        listClass:{
            type: String,
            default: "col-md-4 m-b-md"
        }
    },
    components:{
        photo
    },
    events:{
        photoRemoved(order){
            // remove the just deleted photo from options
            let index = this.data.findIndex(data => data.order === order);
            this.data.splice(index, 1);
        }
    },
}

</script>
