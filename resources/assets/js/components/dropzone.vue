<template>
<div class="box-typical-upload box-typical-upload-in">
    <div class="drop-zone">
        <form id="genericDropzone" action="{{ fullUrl }}" method="POST" class="dropzone">
			<input type="hidden" name="_token" value="{{ token }}">
        	<div class="dz-message" data-dz-message><span><i class="font-icon font-icon-cloud-upload-2"></i>
            <div class="drop-zone-caption">Drag file or click to add photos</div></span></div>
        </form>
    </div>
</div>
</template>

<script>

export default {
    props: [ 'url' ],
    data(){
        return {
			token: Laravel.csrfToken,
        }
    },
    computed:{
        fullUrl(){
            return Laravel.url+this.url;
        }
    }
}
</script>
