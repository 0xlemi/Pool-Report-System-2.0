<script>
import { Bar } from 'vue-chartjs'

export default Bar.extend({
  props: ['data', 'options'],
  ready () {
    this.render(this.data, this.options)
  }
})
</script>
