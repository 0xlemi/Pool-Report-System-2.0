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
    <div v-for="reading in report.readings" class="col-xxl-3 col-xl-6">
        <panel :title="reading.title">
            <reading-chart
                :title="reading.title"
                :color="reading.color"
                :value="reading.value"
                :tags="reading.tags"
                :height="400">
            </reading-chart>
        </panel>
    </div>
</div>

<div class="col-md-12">
    <div class="col-xxl-6 col-xl-12">
        <panel title="Report Created by">
            <client-report-staff :person="report.urc">
            </client-report-staff>
        </panel>
    </div>
</div>
</template>

<script>
import photoList from './photoList.vue';
import readingChart from './ReadingChart.vue';
import clientReportStaff from './ClientReportStaff.vue';
import panel from './panel.vue';


export default {
    props: ['report'],
    components:{
        photoList,
        readingChart,
        clientReportStaff,
        panel
    },
    data(){
        return {
            morePhotos: false,
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
