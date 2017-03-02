<template>
<span id="tableOverlay" :class="(disabled) ? 'disabled' : ''">
    <alert type="danger" :message="alertMessage" :active="alertActive"></alert>
    <section v-show="reports.length > 0" class="tabs-section">
    	<div class="tabs-section-nav tabs-section-nav-inline">
    		<ul class="nav" role="tablist">
    			<li v-for="(key, report) in reports" class="nav-item">
    				<a class="nav-link" :class="{'active': key == 0 }"
                            href="#tabs-1-tab-{{ report['id'] }}" role="tab" data-toggle="tab">
                        {{ report['service']['name'] }}
    				</a>
    			</li>
    		</ul>
    	</div><!--.tabs-section-nav-->

    	<div class="tab-content">
    		<div v-for="(key, report) in reports" role="tabpanel" class="tab-pane fade in"
                    :class="{'active': key == 0 }" id="tabs-1-tab-{{ report['id'] }}">
                <div class="row">
                    <client-report :report="report">
                    </client-report>
                </div>
            </div>
    	</div><!--.tab-content-->
    </section><!--.tabs-section-->
	<section v-else class="box-typical">
        <div class="announcement-box">
            <h2 class="announcement-text">There are not reports for this day.</h2>
            <h5 class="announcement-text">Click on a different day to see reports.</h5>
        </div>
    </section>

</span>
</template>

<script>
import alert from './alert.vue';
import clientReport from './ClientReport.vue';

export default {
    props: ['today'],
    components:{
        alert,
        clientReport
    },
    data(){
        return {
            reports: {},
            alertMessage: '',
            alertActive: false,
            disabled: false,
        }
    },
    methods: {
        get(date){
            this.disable(true);
            this.$http.post(Laravel.url+'report',{
                date: date
            }).then(response => {
                this.reports = response.data.reports;
                this.disable(false);
            }, response => {
                this.alertMessage = 'There was an error, please try later.';
                this.alertActive = true;
                this.disable(false);
            });
        },
        disable(disable){
            this.disabled = disable;
            this.$dispatch('disableDatePicker', disable);
        }
    },
    events: {
        datePickerClicked(date){
            this.get(date);
        }
    },
    ready(){
        this.get(this.today);
    }
}
</script>

<style scoped>
.disabled{
    pointer-events:none;
    background-color: white;
    filter:alpha(opacity=50); /* IE */
    opacity: 0.5; /* Safari, Opera */
    -moz-opacity:0.50; /* FireFox */
    z-index: 20;
    height: 100%;
    width: 100%;
    background-repeat:no-repeat;
    background-position:center;
    position:absolute;
    top: 0px;
    left: 0px;
}
.announcement-box{
    padding: 80px 0;
}
.announcement-text{
    text-align: center;
}
</style>
