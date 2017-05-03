<template>
    <span v-if="unreadMessageCount > 0" class="label label-custom label-pill label-danger">{{ unreadMessageCount }}</span>
</template>

<script>

export default {
    props: ['selectedUser'],
    data(){
        return {
            unreadMessageCount: 0,
        };
    },
    events: {
        chatReady(){
            this.getUnreadMessageCount();
        },
        newMessage(info){
            this.unreadMessageCount++;
        },
        messageViewed(){
            this.getUnreadMessageCount();
        }
    },
    methods: {
        getUnreadMessageCount(){
            let url = Laravel.url+'chat/unreadcount/'+this.selectedUser.id
            this.$http.get(url).then(response => {
                this.unreadMessageCount = response.data.data;
            }, response => {
                console.log('error trying to get unread messages count');
            });
        }
    },
}
</script>
