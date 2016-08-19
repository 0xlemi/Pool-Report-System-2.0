<template>
    <v-select :value.sync="selected" :options="countries"></v-select>
</template>

<script>
import vSelect from 'vue-select'
export default {
  components: {vSelect},
  data() {
     return {
        selected: null
     }
  }
}
</script>
