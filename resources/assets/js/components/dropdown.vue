<template>
    <div>
        <multiselect
            :selected="selected"
            :options="options"
            @update="updateSelected"
            :searchable="true"
            :close-on-select="true"
            :allow-empty="false"
            :custom-label="styleLabel"
            option-partial="basicNameIconOptionPartial"
            deselect-label="Can't remove this value"
            key="key"
            label="label"
            >
        </multiselect>
    </div>
    <input type="hidden" name="{{name}}" value="{{key}}">
</template>

<script>
var Vue = require('vue');
import Multiselect from 'vue-multiselect'
import basicNameIconOptionPartial from './partials/basicNameIconOptionPartial.html'
Vue.partial('basicNameIconOptionPartial', basicNameIconOptionPartial)

export default {
    components: { Multiselect },
    props :[ 'key', 'options', 'name'],
    data () {
        return {
            selected: this.options.find(options => options.key === this.key),
        }
    },
    methods: {
        styleLabel ({ key, label }) {
            return key+' '+label;
        },
        updateSelected (newSelected) {
          this.selected = newSelected;
          this.key = newSelected.key;
        }
    },
    watch: {
        // if the key is changed change the selected
        key: function(val){
            this.selected = this.options.find(options => options.key === val);
        }
    }
}

</script>
