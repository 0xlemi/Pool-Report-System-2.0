<template>
	<button @click="markAsRead" class="btn btn-warning">Mark all as read</button>
</template>

<script>
export default {
    methods: {
        markAsRead(){
            this.$http.post('notifications/read/all').then((response) => {
                window.location.reload();    
            });
        }
    }
}
</script>

<style scoped>
.btn {
    float: right;
    margin-top:20px;
    margin-right:10px;
}
</style>
