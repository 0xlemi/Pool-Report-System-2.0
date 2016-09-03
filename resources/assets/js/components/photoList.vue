<template>

    <div class="col-md-4 m-b-md" v-for="image in data">
        <div class="gallery-col">
        	<article class="gallery-item">
        		<img class="gallery-picture" :src="image.thumbnail" alt="" height="127">
        		<div class="gallery-hover-layout">
        			<div class="gallery-hover-layout-in">
        				<p class="gallery-item-title">{{ image.title }}</p>
        				<div class="btn-group">
        					<a class="fancybox btn" href="{{ image.normal }}" title="{{ image.title }}">
        						<i class="font-icon font-icon-eye"></i>
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
    props :['data'],
    data () {
        return {
            debug: {}
        }
    },
}

</script>
