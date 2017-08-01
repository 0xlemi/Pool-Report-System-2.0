<template>

<!-- Button -->
<button type="button" class="btn btn-success" @click="clickButton">
	<i class="fa fa-money"></i>&nbsp;&nbsp;&nbsp;See Payments
</button>

<modal title="Payments" id="equipmentModal" :modal-class="{'modal-lg' : (focus == 2)}">

    <!-- List -->
	<div class="col-md-12" v-show="isFocus(2)">

		<alert type="danger" :message="alertMessageList" :active="alertActiveList"></alert>


	</div>


    <!-- Show Equipment -->
	<div class="col-md-12" v-show="isFocus(3)">

		<div class="form-group row">
			<label class="col-sm-2 form-control-label">Type</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control" value="{{ type }}">
			</div>
		</div>

	</div>


	<button slot="buttonsBefore" v-if="!isFocus(2)" class="btn btn-warning" type="button" @click="goBack">
		<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back
	</button>

</modal>

</template>

<script>
import modal from './modal.vue';
import alert from './alert.vue';

export default {
	props: {
        serviceId: {
            required: true
        },
    },
	components:{
        modal,
        alert,
    },
    data(){
        return {
            focus: 2, //  2=list, 3=show

            id: 0,
            kind: null,

            // alert
			alertMessageList: '',
			alertActiveList: false,


        }
    },
	events: {

	},
    methods: {
		clickButton(){
			this.$broadcast('openModal', 'equipmentModal');
			this.getList();
		},
		// getValues(id){
		// 	this.resetAlert();
		// 	this.$http.get(Laravel.url+'equipment/'+id).then((response) => {
		// 		let data = response.data;
		// 		this.kind = data.kind;
		//         this.type = data.type;
		//         this.brand = data.brand;
		//         this.model = data.model;
		//         this.capacity  = data.capacity+' '+data.units;
		//         this.photos = data.photos;
		// 		this.focus = 3;
	    //     }, (response) => {
		// 		this.focus = 2;
		// 		this.alertMessageList = "The information could not be retrieved, please try again.";
		// 		this.alertActiveList = true;
	    //     });
	    // },
        changeFocus(num){
			if(num == 2){
                // Refresh List
				// this.getList();
			}
            this.focus = num;
        },
		goBack(){
			this.changeFocus(2);
		},
		resetAlert(){
			this.alertMessageList = "";
			this.alertActiveList = false;
		},
        isFocus(num){
            return this.focus == num;
        },
    }
}
</script>
