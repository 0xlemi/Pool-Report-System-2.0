<template>
<div class="form-group row" v-for="permission in data">
    <div class="col-md-12">
        <div class="checkbox-toggle">
			<input type="checkbox" id="{{ 'notify_'+permission.role+'_'+permission.id }}" v-model="permission.value" @click="sendRequest(permission)"/>
			<label for="{{ 'notify_'+permission.role+'_'+permission.id }}">{{ permission.text }}</label>
		</div>
    </div>
</div>
</template>

<script>
export default{
    props: ['data'],
    methods: {
        sendRequest(permission){
            this.$dispatch('clearError');
            this.$http.post(Laravel.url+'settings/permissions', {
                'id': permission.id,
                'checked': (!permission.value) ? true : false,
                'role' : permission.role
            }).then((response) => {
                // if success do nothing
            }, (response) => {
                this.$dispatch('permissionError');
            });
        }
    }
}
</script>
