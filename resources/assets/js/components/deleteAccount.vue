<template>
    <div class="col-md-12">
        <button class="btn btn-danger" @click="destroy">
        	<i class="glyphicon glyphicon-warning-sign"></i>
            &nbsp;&nbsp;Delete Account&nbsp;&nbsp;
        	<i class="glyphicon glyphicon-warning-sign"></i>
        </button>
    	<small class="text-muted">Be carefull, once deleted there is no going back.</small>
    </div>
</template>

<script>
var Spinner = require("spin");

export default {
    props: {
        url: {
            required: true
        },
        icon: {
            required: true
        },
        title: {
            default: "Are you sure?"
        },
        message: {
            default: "You will not be able to recover this!"
        },
        buttonTag: {
            default: "Yes, delete it!"
        }
    },
    methods: {
		destroy(){
			let vue = this;
			let clickEvent = event;
            swal({
                title: "<span style=\"color: #E2574C;\"><i class=\"glyphicon glyphicon-warning-sign\"></i>&nbsp;&nbsp;&nbsp;<strong>Delete Account</strong>&nbsp;&nbsp;&nbsp;<i class=\"glyphicon glyphicon-warning-sign\"></i></span>",
                text: "<strong>Are you sure you want to do delete all your information?</strong><br>The deleting process might take a few minutes.",
                type: "input",
                imageUrl: this.icon,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel plx!",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "Please type your password",
                html: true,
                showLoaderOnConfirm: true,
            },
            function(inputValue){
                if (inputValue === false) return false;

                if (inputValue === "") {
                    swal.showInputError("We need your password!");
                    return false
                }

                vue.destroyRequest(inputValue);
            });
		},
        destroyRequest(password){
            this.$http.delete(Laravel.url+this.url,{
                password: password
            }).then((response) => {
                // redirect to index
                window.location = Laravel.url+'/login';
                // Note: the success message is flashed by the back end
            }, (response) => {
                swal({
            		title: "Not deleted",
            		text: response.data.error,
            		type: "error",
               	});
            });

        },
    }

}
</script>
