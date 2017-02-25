<template>
<span id="tableOverlay" :class="(disabled) ? 'disabled' : ''">
    <alert type="danger" :message="alertMessage" :active="alertActive"></alert>
    <section class="tabs-section">
    	<div class="tabs-section-nav tabs-section-nav-inline">
    		<ul class="nav" role="tablist">
    			<li v-for="(key, report) in reports" class="nav-item">
    				<a class="nav-link" :class="{'active': key == 0 }" href="#tabs-1-tab-{{ report['id'] }}" role="tab" data-toggle="tab">
                        {{ report['service']['name'] }}
    				</a>
    			</li>
    		</ul>
    	</div><!--.tabs-section-nav-->

    	<div class="tab-content">
    		<div v-for="(key, report) in reports" role="tabpanel" class="tab-pane fade in" :class="{'active': key == 0 }" id="tabs-1-tab-{{ report['id'] }}">
                    {{ report['service']['name'] }}
            </div>
    	</div><!--.tab-content-->
    </section><!--.tabs-section-->
</span>
</template>

<script>
import alert from './alert.vue';

export default {
    props: ['today'],
    components:{
        alert
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
</style>
