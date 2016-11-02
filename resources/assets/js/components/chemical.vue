<template>

    <!-- Modal for Chemical preview -->
	<div class="modal fade" id="chemicalModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Chemicals</h4>
	      </div>
	      <div class="modal-body">
				<div class="row">
                    <!-- Create new Chemical -->
                    <div class="col-md-12" v-show="isFocus(1)">

                    </div>

                    <!-- Index Chemical -->
                    <div class="col-md-12" v-show="isFocus(2)">
                        
                    </div>

                    <!-- Edit Chemical -->
                    <div class="col-md-12" v-show="isFocus(3)">

                    </div>

				</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal" v-if="!isFocus(3)">Close</button>

            <button type="button" class="btn btn-primary" v-if="isFocus(1)" @click="create">
				Create
			</button>

            <button type="button" class="btn btn-warning" v-if="isFocus(3)" @click="changeFocus(2)">
				<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back
			</button>

            <button type="button" class="btn btn-success" v-if="isFocus(3)" @click="update">
				<i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Update
			</button>

	      </div>
	    </div>
	  </div>
	</div>


</template>

<script>

var alert = require('./alert.vue');
var Spinner = require("spin");

  export default {
    props: ['serviceId', 'chemicalUrl'],
	components: {
		alert
	},
    data () {
        return {
            focus: 2, // 1=create, 2=index, 3=edit
            validationErrors: {},

            name: '',
            amount: '',
            units: '',
        }
    },
    computed: {
        Url: function(){
            return this.chemicalUrl+this.serviceId;
        },
    },
    methods: {
        getList(){

        },
        update(){

        },
        checkValidationError($fildName){
            return $fildName in this.validationErrors;
        },
        isFocus(num){
            return this.focus == num;
        },
        changeFocus(num){
            this.focus = num;
        },
		clean(){
			this.validationErrors = {};

			this.name = '';
            this.amount = '';
            this.units = '';
		},
		revertButton(clickEvent, buttonTag){
			// enable, remove spinner and set tab to the one before
			clickEvent.target.disabled = false;
			clickEvent.target.innerHTML = buttonTag;
		}
    },
    ready(){
        this.getList();
    }
  }
</script>
