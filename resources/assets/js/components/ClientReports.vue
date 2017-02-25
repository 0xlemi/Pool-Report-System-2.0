<template>
    <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-12">
		<client-report-date-picker></client-report-date-picker>
	</div>
	<div class="col-xxl-10 col-xl-9 col-lg-8 col-md-12">
        <client-reports-group
            :today="today"
        ></client-reports-group>
	</div>
</template>

<script>
import clientReportsGroup from './ClientReportsGroup.vue';
import clientReportDatePicker from './ClientReportDatePicker.vue';

export default {
    props: ['today'],
    components: {
        clientReportsGroup,
        clientReportDatePicker
    },
    events: {
        // triangulate to get to sibling
        disableDatePicker(disable){
            this.$broadcast('disableDatePicker', disable);
        }
    }
}
</script>
