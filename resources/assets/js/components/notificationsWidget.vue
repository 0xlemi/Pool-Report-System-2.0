<template>
<div class="dropdown dropdown-notification notif">
    <a @click.prevent="markAsRead"
       class="header-alarm"
       :class="{ 'active': unreadCount > 0 }"
       id="dd-notification"
       data-toggle="dropdown"
       aria-haspopup="true"
       aria-expanded="false">
        <i class="font-icon-alarm"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-notif" aria-labelledby="dd-notification">
        <div class="dropdown-menu-notif-header">
            Notifications
            <span class="label label-pill label-danger" v-if="unreadCount > 0">{{ unreadCount }}</span>
        </div>
        <div class="dropdown-menu-notif-list">
            <notification :data="notification" v-for="notification in notifications"></notification>
        </div>
        <div class="dropdown-menu-notif-more">
            <a @click.prevent="seeAllNotifications">See more</a>
        </div>
    </div>
</div>
</template>


<script>
import notification from './notification.vue';

export default {
    props: ['notifications'],
    data(){
        return {
            unreadCount: '0',
        }
    },
    components: {
        notification
    },
    methods: {
        markAsRead(){
            // check if I have notifications to mark as read
            // if(this.unreadCount > 0){
                this.$http.post(Laravel.url+'notifications/read/widget').then((response) => {
                    this.getNotifications();
                });
            // }
        },
        seeAllNotifications(){
            window.location = Laravel.url+'notifications';
        },
        getNotifications(){
            this.$http.get(Laravel.url+'notifications/widget').then((response) => {
                let data = response.data;
                this.notifications = data.notifications;
                this.unreadCount = data.unreadCount;
            });
        }
    },
    ready() {
        this.getNotifications();
    }

}
</script>
