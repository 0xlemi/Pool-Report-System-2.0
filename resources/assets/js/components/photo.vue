<template>
    <div class="gallery-col">
        	<article class="gallery-item">
        		<img class="gallery-picture" :src="image.thumbnail" alt="" height="127">
        		<div class="gallery-hover-layout">
        			<div class="gallery-hover-layout-in">
        				<p class="gallery-item-title">{{ image.title }}</p>
        				<div class="btn-group">
        					<a class="fancybox btn" href="{{ image.big }}" title="{{ image.title }}">
        						<i class="font-icon font-icon-eye"></i>
        					</a>
                            <a v-if="canDelete" @click="deletePhoto(image.order)" class="btn">
								<i class="font-icon font-icon-trash"></i>
							</a>
        				</div>
        				<p>Photo number {{ image.order }}</p>
        			</div>
        		</div>
        	</article>
        </div><!--.gallery-col-->
</template>

<script>

export default {
    props :['image', 'canDelete', 'objectId', 'photosUrl'],
    methods:{
        deletePhoto(order){
            this.$http.delete(Laravel.url+this.photosUrl+'/'+this.objectId+'/'+order).then((response) => {
                // remove the just deleted photo from options
                this.$dispatch('removePhoto', order);
            }, (response) => {
                console.log('image was not deleted');
            });
        }
    }
}
</script>
