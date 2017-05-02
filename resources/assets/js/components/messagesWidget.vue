<template>
<audio v-el:audio :src="soundUrl" preload="auto"></audio>
<div class="dropdown dropdown-notification messages">
    <a @click.prevent="goToChat()" class="header-alarm" :class="{'active' : hasUnreadMessage}">
        <i class="font-icon-mail"></i>
    </a>
</div>
</template>

<script>

export default {
    props: ['selectedUser', 'soundUrl'],
    data(){
        return {
            hasUnreadMessage: false,
            channel: {},
        };
    },
    events: {
        chatReady(){
            this.checkIfHasNewMessages();
        },
        newMessage(info){
            this.hasUnreadMessage = true;
            this.playSound(this.$els.audio);
        },
        messageViewed(){
            this.checkIfHasNewMessages();
        }
    },
    methods: {
        checkIfHasNewMessages(){
            let url = Laravel.url+'chat/unreadcount/'+this.selectedUser.id
            this.$http.get(url).then(response => {
                this.hasUnreadMessage = (response.data.data > 0);
            }, response => {
                console.log('error trying to get unread messages count');
            });
        },
        goToChat(){
            window.location = Laravel.url+'chat';
        },
        playSound(audio){
            if (audio.paused) {
                audio.play();
            }else{
                audio.currentTime = 0
            }
        },
    },
}
</script>
