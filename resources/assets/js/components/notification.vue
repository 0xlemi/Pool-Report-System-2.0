<template>
    <div class="dropdown-menu-notif-item">
        <div class="photo">
            <img src="" alt="">
        </div>
        <div class="dot" v-if="!data.read"></div>
        {{{ data.title }}}
        <div class="color-blue-grey-lighter">{{ data.time }}</div>
    </div>
</template>

<script>
export default {
    props: ['data']
}
</script>
