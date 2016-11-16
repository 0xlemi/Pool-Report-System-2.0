<template>
    <div class='input-group date'>
        <input class='form-control' v-model='model' type='text' readonly>
        <span class='input-group-addon'>
            <i class='fa fa-fw fa-calendar'></i>
        </span>
    </div>
</template>

<script>


export default {
    replace: true,
    inherit: false,
    props: ['model'],
    ready: function() {
        let options = {
            widgetPositioning: {
            			horizontal: 'right'
            },
            debug: false,
            useCurrent: true,
        };
        $(this.$el).datetimepicker(options);
    }
}
</script>
