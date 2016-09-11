<template>

    <div class="col-md-4 m-b-md" v-for="image in data">
        <div class="gallery-col">
        	<article class="gallery-item">
        		<img class="gallery-picture" :src="image.thumbnail" alt="" height="127">
        		<div class="gallery-hover-layout">
        			<div class="gallery-hover-layout-in">
        				<p class="gallery-item-title">{{ image.title }}</p>
        				<div class="btn-group">
        					<a class="fancybox btn" href="{{ image.full_size }}" title="{{ image.title }}">
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
    </div><!--.col-->
</template>

<script>

export default {
    props :['data', 'objectId', 'canDelete', 'photosUrl'],
    data () {
        return {
            debug: {}
        }
    },
    computed:{
        deleteUrl: function(){
            return this.photosUrl+'/'+this.objectId+'/'
        }
    },
    methods:{
        deletePhoto(order){
            $.ajax({
                vue: this,
                url: this.deleteUrl+order,
                type: 'DELETE',
                success: function(data, textStatus, xhr) {
                    console.log('image deleted');
                    this.vue.$dispatch('equipmentChanged')
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log('image was not deleted');
                }
            });
        }
    },
}

</script>
