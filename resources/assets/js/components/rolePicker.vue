<template>
<div class="dropdown dropdown-typical">
    <a class="dropdown-toggle" id="dd-header-marketing" data-target="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span :class="selectedUser.icon"></span>&nbsp;&nbsp;<span class="lbl">{{ selectedUser.company_name }}</span>
    </a>

    <div class="dropdown-menu" aria-labelledby="dd-header-marketing">
        <span v-for="roles in companies">
            <div class="dropdown-header">{{roles[0].company_name}}</div>
                <a v-for="role in roles" class="dropdown-item" @click="redirect(role.id)">
                    <span :class="role.icon"></span>&nbsp;&nbsp;&nbsp;{{role.text}}</a>
            <div v-if="!last(roles, companies)" class="dropdown-divider"></div>
        <span>
    </div>
</div>
</template>

<script>

export default {
    props: ['selectedUser', 'companies'],

    methods: {
        redirect(id){
            window.location = Laravel.url+'change/role/'+id;
        },
        last(roles, companies){
            var keys = Object.keys(companies);
            var last = keys[keys.length-1];
            return (roles[0].company_name === last);
        }
    },

}
</script>
