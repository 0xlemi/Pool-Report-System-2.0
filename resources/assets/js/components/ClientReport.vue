<template>
<div class="col-md-12">
    <br>
    <h3 class="with-border semibold">&nbsp;&nbsp;&nbsp;Pool Photos</h3>
    <div class="col-xl-8 col-xl-offset-2 col-lg-12 col-lg-offset-0">
        <photo-list
            :data="photos"
            :can-delete="false"
            list-class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-5 m-b-md">
    	</photo-list>
        <button v-if="report.photos.length > 3" @click="morePhotos = !morePhotos" type="button" class="btn btn-block btn-default-outline">
            {{ photosButtonMessage }}
        </button>
        <br>
        <br>
    </div>
</div>
<div class="col-md-12">
    <div class="col-xxl-6 col-xl-12">
        <panel title="Chemicals">
            <chemical-chart
            :values="values"
            :tags="tags"
            :height="187">
            </chemical-chart>
        </panel>
    </div>
    <div class="col-xxl-3 col-xl-6">
        <panel title="Temperature">
            <chemical-chart
            :values="temperature"
            :tags="tags"
            :height="400">
            </chemical-chart>
        </panel>
    </div>
    <div class="col-xxl-3 col-xl-6">
        <panel title="Turbidity">
            <chemical-chart
            :values="turbidity"
            :tags="[
                'Very High',
                'High',
                'Low',
                'Perfect',
            ]"
            :height="400">
            </chemical-chart>
        </panel>
    </div>
</div>

<div class="col-md-12">
    <div class="col-xxl-6 col-xl-12">
        <panel title="Staff">
            <client-report-staff
                :supervisor="report.supervisor"
                :technician="report.technician">
            </client-report-staff>
        </panel>
    </div>
</div>
</template>

<script>
import photoList from './photoList.vue';
import chemicalChart from './ChemicalChart.vue';
import clientReportStaff from './ClientReportStaff.vue';
import panel from './panel.vue';


export default {
    props: ['report'],
    components:{
        photoList,
        chemicalChart,
        clientReportStaff,
        panel
    },
    data(){
        return {
            morePhotos: false,
            values: [
                {
                    tag: 'PH',
                    data: this.report.ph,
                    color: {
                        red: 255,
                        green: 99,
                        blue: 132,
                    }
                },
                {
                    tag: 'Chlorine',
                    data: this.report.chlorine,
                    color: {
                        red: 54,
                        green: 162,
                        blue: 235,
                    }
                },
                {
                    tag: 'Salt',
                    data: this.report.salt,
                    color: {
                        red: 255,
                        green: 206,
                        blue: 86,
                    }
                },
            ],
            temperature: [
                {
                    tag: 'Temperature',
                    data: this.report.temperature,
                    color: {
                        red: 255,
                        green: 99,
                        blue: 132,
                    }
                },
            ],
            turbidity: [
                {
                    tag: 'Turbidity',
                    data: this.report.turbidity,
                    color: {
                        red: 75,
                        green: 192,
                        blue: 192,
                    }
                },
            ],
            tags: [
                'Very Low',
                'Low',
                'Perfect',
                'High',
                'Very High',
            ],
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
            return (this.morePhotos) ? 'Show Less Photos' : 'Show More Photos';
        }
    },

}
</script>
