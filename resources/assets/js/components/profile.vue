<template>
<section class="box-typical">
    <div class="profile-card">
        <div class="profile-card-photo">
            <img src="img/photo-220-1.jpg" alt=""/>
        </div>
        <div class="profile-card-name">{{name}}</div>
        <div class="profile-card-status">{{companyName}}</div>
        <div class="profile-card-location">Business Plan</div>

    </div><!--.profile-card-->

    <div class="profile-statistic tbl">
        <div class="tbl-row">
            <div class="tbl-cell">
                <b></b>
                Technicians
            </div>
            <div class="tbl-cell">
                <b></b>
                Reports done
            </div>
        </div>
    </div>
        <ul class="profile-links-list">
            <li class="nowrap">
                <i class="font-icon font-icon-mail"></i>
                &nbsp;{{ email }}
            </li>
            <li v-if="website" class="nowrap">
                <i class="font-icon font-icon-earth-bordered"></i>
                <a href="http://{{website}}">{{ website }}</a>
            </li>
            <li v-if="facebook" class="nowrap">
                <i class="font-icon font-icon-fb-fill"></i>
                <a href="https://www.facebook.com/{{facebook}}">https://facebook.com/{{facebook}}</a>
            </li>
            <li v-if="twitter" class="nowrap">
                <i class="font-icon font-icon-tw-fill"></i>
                <a href="https://www.twitter.com/{{twitter}}">https://twitter.com/{{twitter}}</a>
            </li>
        </ul>
</section><!--.box-typical-->
</template>

<script>

export default {
    props:[ 'name', 'companyName', 'email', 'website', 'facebook', 'twitter'],
    data(){
		return {
        }
    },

}
</script>
