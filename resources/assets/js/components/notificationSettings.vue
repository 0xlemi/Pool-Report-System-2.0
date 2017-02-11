<template>
<div class="form-group row" v-for="setting in settings">
    <label class="col-sm-2 form-control-label semibold">{{ setting.tag }}</label>
    <div class="col-sm-10">
        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
            <button v-for="button in setting.buttons"
                @click="sendRequest(setting.name, button.type, button.value)"
                type="button" class="btn"
                :class="(button.value) ? 'btn-default' : 'btn-default-outline'">
                <span :class="button.icon"></span>
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
            // get the Selected Setting
            let selectedSetting = this.settings.find(settings => settings.name === name)
            let selectedSettingId = this.settings.indexOf(selectedSetting);

            // find what button was clicked in that setting
            let selectedButton = selectedSetting.buttons.find(button => button.type === type)
            let selectedButtonId = selectedSetting.buttons.indexOf(selectedButton);

            // toggle button class selection
            this.settings[selectedSettingId].buttons[selectedButtonId].value = value;
        },
        sendRequest(name, type, value){
            // this.$dispatch('clearError');
            this.changeButtonValue(name, type, !value);
            this.$http.post(Laravel.url+'settings/notifications', {
                'name': name,
                'type': type,
                'value': value,
            }).then((response) => {
                // if success do nothing
            }, (response) => {
                this.changeButtonValue(name, type, value);
                // this.$dispatch('notificationError');
            });
        }
    }
}
</script>
