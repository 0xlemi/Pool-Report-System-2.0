<template>
    <button class="btn btn-danger" @click="destroy">
    	<i class="font-icon font-icon-close-2"></i>
        &nbsp;&nbsp;Delete
    </button>
</template>

<script>
var Spinner = require("spin");

export default {
    props: {
        url: {
            required: true
        },
        objectId: {
            required: true
        },
        objectType: {
            required: true
        },
        title: {
            default: "Are you sure?"
        },
        message: {
            default: "You will not be able to this!"
        },
        buttonTag: {
            default: "Yes, delete it!"
        }
     },
    data() {
        return {
			token: Laravel.csrfToken,
        }
    },
    methods: {
		destroy(){
			let vue = this;
			let clickEvent = event;
			swal({
                title: this.title,
                text: this.message,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: this.buttonTag,
                cancelButtonText: "No, cancel!",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if(isConfirm){
                    vue.destroyRequest(clickEvent);
                }
            });
		},
        destroyRequest(clickEvent){
			// save button text for later
            let buttonTag = clickEvent.target.innerHTML;

            // Disable the submit button to prevent repeated clicks:
            clickEvent.target.disabled = true;
            clickEvent.target.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Loading';
            new Spinner({
                left: "90%",
                radius: 5,
                length: 4,
                width: 1,
            }).spin(clickEvent.target);

            this.$http.delete(Laravel.url+this.url+this.objectId).then((response) => {
                // redirect to index
                window.location = Laravel.url+this.url;
                // Note: the success message is flashed by the back end    
            }, (response) => {
                swal({
            		title: "Not deleted",
            		text: response.data.error,
            		type: "error",
            		timer: 2000,
            		showConfirmButton: false
               	});
				this.revertButton(clickEvent, buttonTag);
            });

        },
		revertButton(clickEvent, buttonTag){
			// enable, remove spinner and set tab to the one before
			clickEvent.target.disabled = false;
			clickEvent.target.innerHTML = buttonTag;
		}
    }

}
</script>
