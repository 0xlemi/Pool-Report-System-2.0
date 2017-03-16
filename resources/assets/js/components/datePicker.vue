<template>
    <section class='box-typical' :class="(disabled) ? 'disabled' : ''">
    	<section class="calendar-page-side-section">
    		<div class="calendar-page-side-section-in">
    			<div class="datepicker-inline" id="side-datetimepicker"></div>
    		</div>
    	</section>
    </section>
</template>

<script>

export default {
    data(){
        return {
            disabled: false,
        }
    },
    events:{
        disableDatePicker(disable){
            this.disabled = disable;
        }
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
