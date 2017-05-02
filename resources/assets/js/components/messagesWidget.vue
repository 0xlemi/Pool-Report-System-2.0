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
    props: ['sb', 'currentUser', 'soundUrl'],
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
        messageViewed(channel){
            this.hasUnreadMessage = false;
        }
    },
    methods: {
        checkIfHasNewMessages(){
            let vue = this;
            let channelListQuery = this.sb.GroupChannel.createMyGroupChannelListQuery();
            channelListQuery.includeEmpty = true;
            channelListQuery.limit = 1; // pagination limit could be set up to 100

            if (channelListQuery.hasNext) {
                channelListQuery.next(function(channelList, error){
                    if (error) {
                        console.error(error);
                        return;
                    }
                    if((channelList.length > 0) && (channelList[0].unreadMessageCount > 0)){
                        vue.channel = channelList[0];
                        vue.hasUnreadMessage = true;
                    }
                });
            }
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
