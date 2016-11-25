<template>
<div class="box-typical-upload box-typical-upload-in">
    <div class="drop-zone">
        <form id="vueDropzone" :action="fullUrl" method="POST" class="dropzone">
			<input type="hidden" name="_token" value="{{ token }}">
        	<div class="dz-message" data-dz-message><span><i class="font-icon font-icon-cloud-upload-2"></i>
            <div class="drop-zone-caption">Drag file or click to add photos</div></span></div>
        </form>
    </div>
</div>
</template>

<script>
var Dropzone = require("dropzone");

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
    },
    watch: {
        url(){
            Dropzone.forElement("#vueDropzone").destroy();
            // generating the dropzone dinamicly
            // in order to change the url
            $("#vueDropzone").dropzone({
                    vue: this,
                    url: this.fullUrl,
                    method: 'post',
                    paramName: 'photo',
                    maxFilesize: 50,
                    acceptedFiles: '.jpg, .jpeg, .png',
                    init: function() {
                        this.on("success", function(file) {
                            this.options.vue.$dispatch('photoUploaded');
                        });
                    }
            });
        }
    },
    ready(){
        Dropzone.options.vueDropzone = {
            vue: this,
            paramName: 'photo',
        	maxFilesize: 50,
        	acceptedFiles: '.jpg, .jpeg, .png',
            init: function() {
                this.on("success", function(file) {
                    this.options.vue.$dispatch('photoUploaded');
                });
            }
        }
    }
}
</script>
