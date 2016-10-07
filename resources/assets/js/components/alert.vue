<template>
    <div v-if="active" class="alert alert-{{ type }} alert-fill alert-close fade in" role="alert">
    	<button type="button" @click="close" class="close" aria-label="Close">
    		<span aria-hidden="true">&times;</span>
    	</button>
    	<span>{{ message }}</span>
    </div>
</template>

<script>
  export default {
    props: ['type', 'message', 'active'],
    data () {
        return {

        }
    },
    methods: {
        close(){
            this.active = false;
        },
    }
  }
</script>
