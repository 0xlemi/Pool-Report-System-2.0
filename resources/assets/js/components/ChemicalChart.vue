<script>
import { Bar } from 'vue-chartjs'

export default Bar.extend({
    props: ['values', 'tags'],
    ready () {

        let info = {
            labels: [],
            backgroundColor: [],
            borderColor: [],
            data: [],
        };
        for (var i = 0; i < this.values.length; i++) {
            info.labels.push(this.values[i].tag);
            info.backgroundColor.push('rgba('+this.values[i].color.red+', '+this.values[i].color.green+', '+this.values[i].color.blue+', 0.2)');
            info.borderColor.push('rgba('+this.values[i].color.red+', '+this.values[i].color.green+', '+this.values[i].color.blue+', 1)');
            info.data.push(this.values[i].data);
        }
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
