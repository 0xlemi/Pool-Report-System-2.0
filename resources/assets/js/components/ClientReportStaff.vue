<template>
<div class="contact-row-list">
    <article class="contact-row">
	    <div class="user-card-row">
            <div class="tbl-row">
                <div class="tbl-cell tbl-cell-photo">
                    <img :src="supervisor.photo.icon" :alt="supervisor.photo.title">
                </div>
                <div class="tbl-cell">
                    <p class="user-card-row-name">{{ supervisor.full_name }}</p>
                    <p class="user-card-row-mail">{{ supervisor.email }}</p>
                </div>
                <div class="tbl-cell tbl-cell-status">Supervisor</div>
            </div>
        </div>
    </article>
    <article class="contact-row">
	    <div class="user-card-row">
            <div class="tbl-row">
                <div class="tbl-cell tbl-cell-photo">
                    <img :src="technician.photo.icon" :alt="technician.photo.title">
                </div>
                <div class="tbl-cell">
                    <p class="user-card-row-name">{{ technician.full_name }}</p>
                    <p class="user-card-row-mail">{{ technician.username }}</p>
                </div>
                <div class="tbl-cell tbl-cell-status">Technician</div>
            </div>
        </div>
    </article>
</div>
</template>

<script>
import modal from './modal.vue';

export default {
    props:['supervisor', 'technician'],
    components: {
        modal    
    }
}
</script>

<style scoped>
.contact-row:hover {
    background-color: white;
    filter:alpha(opacity=50); /* IE */
    opacity: 0.5; /* Safari, Opera */
    -moz-opacity:0.50; /* FireFox */
    z-index: 20;
    height: 100%;
    width: 100%;
    background-repeat:no-repeat;
    background-position:center;
    top: 0px;
    left: 0px;
}
</style>
