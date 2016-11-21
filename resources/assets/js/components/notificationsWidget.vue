<template>
<div class="dropdown dropdown-notification notif">
    <a href="#"
       class="header-alarm dropdown-toggle active"
       id="dd-notification"
       data-toggle="dropdown"
       aria-haspopup="true"
       aria-expanded="false">
        <i class="font-icon-alarm"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-notif" aria-labelledby="dd-notification">
        <div class="dropdown-menu-notif-header">
            Notifications
            <span class="label label-pill label-danger">4</span>
        </div>
        <div class="dropdown-menu-notif-list">
            <div class="dropdown-menu-notif-item">
                <div class="photo">
                    <img src="" alt="">
                </div>
                <div class="dot"></div>
                <a href="#">Morgan</a> was bothering about something
                <div class="color-blue-grey-lighter">7 hours ago</div>
            </div>
            <div class="dropdown-menu-notif-item">
                <div class="photo">
                    <img src="" alt="">
                </div>
                <div class="dot"></div>
                <a href="#">Lioneli</a> had commented on this <a href="#">Super Important Thing</a>
                <div class="color-blue-grey-lighter">7 hours ago</div>
            </div>
            <div class="dropdown-menu-notif-item">
                <div class="photo">
                    <img src="" alt="">
                </div>
                <div class="dot"></div>
                <a href="#">Xavier</a> had commented on the <a href="#">Movie title</a>
                <div class="color-blue-grey-lighter">7 hours ago</div>
            </div>
            <div class="dropdown-menu-notif-item">
                <div class="photo">
                    <img src="" alt="">
                </div>
                <a href="#">Lionely</a> wants to go to <a href="#">Cinema</a> with you to see <a href="#">This Movie</a>
                <div class="color-blue-grey-lighter">7 hours ago</div>
            </div>
        </div>
        <div class="dropdown-menu-notif-more">
            <a href="">See more</a>
        </div>
    </div>
</div>
</template>


<script>
export default {
    props: ['notifications'],
    methods: {
    },
    ready() {
        this.$http.get(Laravel.url+'/notifications/widget').then((response) => {
            this.notifications = response.data;
        });
    }

}
</script>
