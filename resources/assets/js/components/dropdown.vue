<template>
    <div>
        <multiselect
            :selected="selected"
            :options="options"
            @update="updateSelected"
            :searchable="true",
            :close-on-select="true",
            :allow-empty="false",
            deselect-label="Can't remove this value"
            key="key"
            label="label"
            placeholder="Choose a option"
            >

        </multiselect>
    </div>
    <input type="hidden" name="{{name}}" value="{{key}}">
</template>

<script>
import Multiselect from 'vue-multiselect'
export default {
    components: { Multiselect },
    props :[ 'key', 'options', 'name' ],
    data () {
        return {
            selected: null,
        }
    },
    methods: {
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
