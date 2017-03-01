<template>
<modal title="Service Contract" id="contractModal">
    <div class="col-md-12">

        <div class="form-group row">
    		<label class="col-sm-2 form-control-label">Service days</label>
    		<div class="col-sm-10">
                <span class="label label-pill label-default">{{ serviceDaysString }}</span>
    		</div>
    	</div>
    	<div class="form-group row">
    		<label class="col-sm-2 form-control-label">Time interval</label>
    		<div class="col-sm-10">
    			<div class="input-group">
    				<div class="input-group-addon">From:</div>
    				<input type="text" class="form-control"
    						name="start_time" value="{{ startTime }}" readonly>
    				<div class="input-group-addon">To:</div>
    				<input type="text" class="form-control"
    						name="end_time" value="{{ endTime }}" readonly>
    			</div>
    		</div>
    	</div>
    	<div class="form-group row">
    		<label class="col-sm-2 form-control-label">Price</label>
    		<div class="col-sm-10">
    			<input type="text" readonly class="form-control" value="{{ price }}">
    		</div>
    	</div>

    	<div class="form-group row">
    		<label class="col-sm-2 form-control-label">Started at</label>
    		<div class="col-sm-10">
    			<input type="text" readonly class="form-control" value="{{ start }}">
    		</div>
    	</div>

    </div>
</modal>

<button @click="$broadcast('openModal', 'contractModal')" type="button" class="btn btn-secondary">
    <i class="font-icon font-icon-page"></i>&nbsp;&nbsp;&nbsp;See Contract
</button>

</template>

<script>
import modal from './modal.vue'

export default {
    props: [ 'serviceDaysString', 'startTime', 'endTime', 'price', 'start' ],
    components:{
        modal
    }
}
</script>
