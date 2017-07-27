<template>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<br>
			</div>
			<div class="col-md-6">
				<div class="col-md-12 form-group">
                	<button v-if="button" type="button" class="btn btn-primary" @click="goToCreate" >
						<i :class="button.icon"></i>&nbsp;&nbsp;&nbsp;{{ button.label }}
					</button>

					 <div v-if="toggle" class="checkbox-toggle" style="display:inline;left:30px;" >
						<input type="checkbox" id="toggle" v-model="toggle.checked" @click="changeToggle(!toggle.checked)">
						<label for="toggle">{{ toggle.label }}</label>
					</div>
				</div>
			</div>
			<div class="col-md-6">
                <div class="col-md-12 input-group pull-right">
					<div class="input-group-addon">
						<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
					</div>
					<input v-model="searchFor" @keyup.enter="setFilter" type="text" class="form-control" placeholder="Search" :disabled="loading">
					<div class="input-group-btn">
                        <button type="button" class="btn btn-primary" @click="setFilter" :disabled="loading">Go</button>
                        <button type="button" class="btn btn-default" @click="resetFilter" :disabled="loading">Reset</button>
					</div>
				</div>
            </div>
			<div class="col-md-12">
				<br>
			</div>
			<div class="col-md-12">
			    <vuetable v-ref:vuetable
			        :api-url="url"
			        pagination-component="vuetable-pagination-bootstrap"
			        pagination-path="paginator"
			        table-wrapper="#content"
			        :fields="columns"
					:item-actions="itemActions"
	                :append-params="moreParams"

			        table-class="table table-bordered table-hover"
			        ascending-icon="glyphicon glyphicon-chevron-up"
			        descending-icon="glyphicon glyphicon-chevron-down"
			        pagination-class="fixed-table-pagination"
			        pagination-info-class="pull-left pagination-detail"
			        :wrapper-class="vuetableWrapper"
			        table-wrapper=".vuetable-wrapper"
			    ></vuetable>
			</div>
		</div>
	</div>

</template>

<script>
import Vue from 'vue';
import Vuetable from 'vuetable/src/components/Vuetable.vue';
import VuetablePaginationBootstrap from './vuetablePaginationBootstrap.vue';
Vue.component('vuetable', Vuetable);
Vue.component('vuetable-pagination-bootstrap', VuetablePaginationBootstrap)

export default Vue.extend({
	props: ['dataUrl', 'actionsUrl', 'columns', 'highlightColumns', 'button', 'toggle'],
    components:{
    },
    data() {
        return {
			itemActions: [
                { name: 'view-item', label: 'view', icon: 'glyphicon glyphicon-zoom-in', class: 'btn btn-sm btn-primary' },
            ],

            moreParams: [],
            totalParams: {},
            searchFor: '',
            loading: false,
            url: Laravel.url+this.dataUrl,

        }
    },
	computed:{
        vuetableWrapper(){
            if(this.loading){
                return 'vuetable-wrapper loading';
            }
                return 'vuetable-wrapper';
        }
    },
	methods: {
		// search
        setFilter(){
			this.totalParams['filter'] = 'filter=' + this.searchFor;
            this.updateParams()
            this.$nextTick(function() {
                this.$broadcast('vuetable:refresh')
            })
        },
        resetFilter(){
            this.searchFor = ''
            this.setFilter()
        },
		updateParams(){
            let totalParams = this.totalParams;
            let moreParams = Object.keys(totalParams).map(function(key){return totalParams[key]});
            this.moreParams = moreParams;
        },
		// Toggle
		changeToggle(toggle){
			let toggleInt = (toggle) ? '1' : '0';
			this.totalParams['toggle'] = 'toggle=' + toggleInt;
            this.updateParams();
            this.$nextTick(function() {
                this.$broadcast('vuetable:refresh')
            });
		},
		// Redirect to Create
		goToCreate(){
			window.location.href = Laravel.url+this.actionsUrl+"/create";
		},
		// highlight
        preg_quote: function( str ) {
            return (str+'').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:])/g, "\\$1");
        },
        highlight(needle, haystack) {
            return haystack.toString().replace(
                new RegExp('(' + this.preg_quote(needle) + ')', 'ig'),
                '<mark>$1</mark>'
            )
        },
	},
	events: {
        'vuetable:loading': function(){
            this.loading = true;
        },
        'vuetable:loaded': function(){
            this.loading = false;
        },
        'vuetable:action': function(action, data) {
            if (action == 'view-item') {
				let id = data.id;
				if(id.includes('<mark>')){
					id = id.replace("<mark>", "");
					id = id.replace("</mark>", "");
				}
				window.location.href = Laravel.url+this.actionsUrl+"/"+id;
            }
        },
        'vuetable:cell-dblclicked': function(item, field, event) {
            var self = this
            console.log('cell-dblclicked: old value =', item[field.name])
            this.$editable(event, function(value) {
                console.log('$editable callback:', value)
            })
        },
        'vuetable:load-success': function(response) {
            var data = response.data.data
            if (this.searchFor !== '') {
                for (n in data) {
					// basicly a foreach
					for (index in this.highlightColumns) {
						let column = this.highlightColumns[index];
	                    data[n][column] = this.highlight(this.searchFor, data[n][column]);
					}
                }
            }
        },
        'vuetable:load-error': function(response) {
            if (response.status == 400) {
                sweetAlert('Something\'s Wrong!', response.data.message, 'error')
            } else {
                sweetAlert('Oops', E_SERVER_ERROR, 'error')
            }
        }
    }
});
</script>


<style scoped>
    /* Loading Animation: */
    .vuetable-wrapper {
        opacity: 1;
        position: relative;
        filter: alpha(opacity=100); /* IE8 and earlier */
    }
    .vuetable-wrapper.loading {
      opacity:0.4;
       transition: opacity .3s ease-in-out;
       -moz-transition: opacity .3s ease-in-out;
       -webkit-transition: opacity .3s ease-in-out;
    }
    .vuetable-wrapper.loading:after {
      position: absolute;
      content: '';
      top: 40%;
      left: 50%;
      margin: -30px 0 0 -30px;
      border-radius: 100%;
      -webkit-animation-fill-mode: both;
              animation-fill-mode: both;
      border: 4px solid #000;
      height: 60px;
      width: 60px;
      background: transparent !important;
      display: inline-block;
      -webkit-animation: pulse 1s 0s ease-in-out infinite;
              animation: pulse 1s 0s ease-in-out infinite;
    }
    @keyframes pulse {
      0% {
        -webkit-transform: scale(0.6);
                transform: scale(0.6); }
      50% {
        -webkit-transform: scale(1);
                transform: scale(1);
             border-width: 12px; }
      100% {
        -webkit-transform: scale(0.6);
                transform: scale(0.6); }
    }
</style>
