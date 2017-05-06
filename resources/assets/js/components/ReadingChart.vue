<script>
import { Bar } from 'vue-chartjs'

export default Bar.extend({
    props: ['title', 'color', 'value', 'tags'],
    ready () {

        let info = {
            labels: [this.title],
            backgroundColor: ['rgba('+this.color.red+', '+this.color.green+', '+this.color.blue+', 0.5)'],
            borderColor: ['rgba('+this.color.red+', '+this.color.green+', '+this.color.blue+', 1)'],
            data: [this.value],
        };
        let tags = this.tags;
        function tagsValue(value) {
            return tags[value-1];
        }
        this.render(
            {
                labels: info.labels,
                datasets: [
                    {
                        backgroundColor: info.backgroundColor,
                        borderColor: info.borderColor,
                        borderWidth: 1,
                        data: info.data,
                    }
                ]
            },
            {
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: false
                },
                responsive: true,
                // maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        barPercentage: .6
                    }],
                    yAxes: [{
                        ticks: {
                        userCallback: tagsValue,
                            min: 0,
                            max: tags.length,
                            stepSize: 1,
                        }
                    }]
                }
            }
        )
    }
})
</script>
