<template>
<div class="col-xl-8 col-xl-offset-2 col-lg-12 col-lg-offset-0">
    <section class="card">
    	<header class="card-header card-header-xxl">
    		Pool Photos
    	</header>
    	<div class="card-block">
            <div class="row">
                <photo-list :data="photos" :can-delete="false" list-class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-5 m-b-md">
            	</photo-list>
                <bar-chart
                    :data="chartData"
                    :options="chartOptions">
                </bar-chart>
            </div>
    	</div>
        <button v-if="report.photos.length > 3" @click="morePhotos = !morePhotos" type="button" class="btn btn-block btn-default-outline">{{ photosButtonMessage }}</button>
    </section>
</div>
</template>

<script>
import photoList from './photoList.vue';
import barChart from './BarChart.vue';


export default {
    props: ['report'],
    components:{
        photoList,
        barChart
    },
    data(){
        return {
            morePhotos: false,
            chartData: {
                labels: ["PH", "Chlorine", "Temperature", "Salt"],
                datasets: [
                    {
                        label: "My First dataset",
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                        ],
                        borderWidth: 1,
                        data: [this.report.ph, this.report.chlorine, this.report.temperature, this.report.salt],
                    }
                ]
            },
            chartOptions: {
                scales: {
                // yAxes: [{
                //   ticks: {
                //     userCallback: function(value) {
                //         switch (value) {
                //             case value == 1:
                //
                //                 break;
                //             default:
                //
                //         }
                //         return v+'hello'
                //     }
                //   }
                // }]
              },
            },
        }
    },
    methods:{

    },
    computed:{
        photos(){
            let result;
            if(this.morePhotos){
                result = this.report.photos;
            }else{
                result = this.report.photos.slice(0,3);
            }
            return result;
        },
        photosButtonMessage(){
            return (this.morePhotos) ? 'Show less' : 'Show more';
        }
    },

}
</script>
