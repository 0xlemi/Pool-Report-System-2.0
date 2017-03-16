<template>
<div class="col-xl-2">
	<date-picker></date-picker>
</div>
<div class="col-xl-10">
	<section class="box-typical">
		<report-table>
		</report-table>
	</section><!--.box-typical-->
</div>
</template>

<script>
import datePicker from './datePicker.vue';
import reportTable from './reportTable.vue';

export default {
    components: {
        datePicker,
        reportTable
    },
    events: {
        // triangulate to get to sibling
        disableDatePicker(disable){
            this.$broadcast('disableDatePicker', disable);
        }
    }
}
</script>
