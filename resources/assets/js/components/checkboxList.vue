<template>
<div class="form-group row" v-for="permission in data">
    <div class="col-md-12">
        <div class="checkbox-toggle">
			<input type="checkbox" id="{{ permission.name }}" v-model="permission.checked" @click="sendRequest(permission)"/>
			<label for="{{ permission.name }}">{{ permission.tag }}</label>
		</div>
    </div>
</div>
</template>

<script>
export default{
    props: ['data'],
    methods: {
        sendRequest(permission){
            this.$http.patch(Laravel.url+'settings/permissions', {
                'id': permission.name,
                'checked': (!permission.checked) ? true : false,
                'name': permission.tag,
            }).then((response) => {
                // if success do nothing
            }, (response) => {
                // throw error
            });
        }
    }
}
</script>
