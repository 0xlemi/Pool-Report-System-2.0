<template>
<div class="form-group row" v-for="permission in data">
    <div class="col-md-12">
        <div class="checkbox-toggle">
			<input type="checkbox" id="{{ permission.id }}" v-model="permission.checked" @click="sendRequest(permission)"/>
			<label for="{{ permission.id }}">{{ permission.name }}</label>
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
                'id': permission.id,
                'checked': (!permission.checked) ? true : false,
                'name': permission.name,
            }).then((response) => {
                // if success do nothing
            }, (response) => {
                // throw error
            });
        }
    }
}
</script>
