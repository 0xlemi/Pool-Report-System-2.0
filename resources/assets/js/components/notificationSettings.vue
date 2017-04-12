<template>
<div class="form-group row" v-for="setting in settings">
    <label class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-sm-6 form-control-label semibold">{{ setting[0].text }}</label>
    <div class="col-xxl-8 col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <div class="btn-group btn-group-sm" id="notificationButtons{{setting[0].name}}" role="group" aria-label="Basic example">
            <button v-for="option in setting"
                @click="sendRequest(option.name, option.type, option.value)"
                type="button" class="btn"
                :class="(option.value) ? 'btn-default' : 'btn-default-outline'">
                <span :class="buttonIcon(option.type)"></span>
            </button>
		</div>
    </div>
</div>
</template>

<script>

export default {
    props:['settings'],
    methods: {
        changeButtonValue(name, type, value){
            let num = 0;
            if(type == 'database'){
                num = 0;
            }else if(type == 'mail'){
                num = 1;
            }
            // toggle button class selection
            this.settings[name][num].value = value;
        },
        sendRequest(name, type, value){
            this.$dispatch('notificationClearError');
            $("#notificationButtons"+name).children().prop('disabled',true);
            this.changeButtonValue(name, type, !value);
            this.$http.post(Laravel.url+'settings/notifications', {
                'name': name,
                'type': type,
                'value': value,
            }).then((response) => {
                $("#notificationButtons"+name).children().prop('disabled',false);
            }, (response) => {
                this.$dispatch('notificationPermissionError');
                this.changeButtonValue(name, type, value);
                $("#notificationButtons"+name).children().prop('disabled',false);
            });
        },
        buttonIcon(name){
            if(name == 'database'){
                return 'font-icon font-icon-alarm';
            }else if(name == 'mail'){
                return 'font-icon font-icon-mail';
            }
        }
    }
}
</script>
