<template>

    <button type="button" class="btn btn-primary btn-sm" @click="$broadcast('openModal', 'serviceContractsInovice')">Services for the Month</button>

    <modal title="Service contracts pending payments for the month" id="serviceContractsInovice" modal-class="modal-lg">
        <div class="col-md-12">
            <div class="col-md-5">

            </div>
            <div class="col-md-7">
                <div class="input-group pull-right">
					<div class="input-group-addon">
						<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
					</div>
					<input v-model="searchFor" @keyup.enter="setFilter" type="text" class="form-control" placeholder="Search">
					<div class="input-group-btn">
                        <button type="button" class="btn btn-primary" @click="setFilter">Go</button>
                        <button type="button" class="btn btn-default" @click="resetFilter">Reset</button>
					</div>
				</div>
            </div>
            <div class="table-responsive">
                <br>
                <vuetable
                    api-url="http://prs.dev/query/servicescontractinvoices"
                    pagination-component="vuetable-pagination-bootstrap"
                    pagination-path="paginator"
                    table-wrapper="#content"
                    :fields="columns"
                    :append-params="moreParams"

                    table-class="table table-bordered table-hover"
                    ascending-icon="glyphicon glyphicon-chevron-up"
                    descending-icon="glyphicon glyphicon-chevron-down"
                    pagination-class="fixed-table-pagination"
                    pagination-info-class="pull-left pagination-detail"
                    wrapper-class="vuetable-wrapper "
                    table-wrapper=".vuetable-wrapper"
                    loading-class="loading"
                ></vuetable>
            </div>
        </div>
    </modal>

</template>

<script>
import Vue from 'vue';
import modal from './modal.vue';
import Vuetable from 'vuetable/src/components/Vuetable.vue';
import VuetablePaginationBootstrap from './vuetablePaginationBootstrap.vue';
Vue.component('vuetable', Vuetable);
Vue.component('vuetable-pagination-bootstrap', VuetablePaginationBootstrap)

export default Vue.extend({
    components:{
        modal,
    },
    data(){
        return {
            columns: [
                {
                    name: 'id',
                    sortField: 'seq_id',
                    title: '#'
                },
                {
                    name: 'name',
                    sortField: 'name',
                },
                {
                    name: 'address',
                    sortField: 'address_line',
                },
                {
                    name: 'price',
                    title: 'Monthly Price',
                },
                {
                    name: 'contract_balance',
                    title: 'Monthly Balance'
                }
			],
            itemActions: [
                { name: 'view-item', label: '', icon: 'zoom icon', class: 'ui teal button' },
                { name: 'edit-item', label: '', icon: 'edit icon', class: 'ui orange button'},
                { name: 'delete-item', label: '', icon: 'delete icon', class: 'ui red button' }
            ],
            moreParams: [],
            searchFor: '',
        }
    },
    methods: {
         setFilter(){
            this.moreParams = [
                'filter=' + this.searchFor
            ]
            this.$nextTick(function() {
                this.$broadcast('vuetable:refresh')
            })
        },
        resetFilter(){
            this.searchFor = ''
            this.setFilter()
        },
        viewProfile(id){
            console.log('view profile with id:', id)
        },
        /** Other Functions **/
         preg_quote: function( str ) {
            return (str+'').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:])/g, "\\$1");
        },
        highlight(needle, haystack) {
            return haystack.replace(
                new RegExp('(' + this.preg_quote(needle) + ')', 'ig'),
                '<mark>$1</mark>'
            )
        },
    },
    events: {
        'vuetable:action': function(action, data) {
            console.log('vuetable:action', action, data)

            if (action == 'view-item') {
                sweetAlert(action, data.name)
            } else if (action == 'edit-item') {
                sweetAlert(action, data.name)
            } else if (action == 'delete-item') {
                sweetAlert(action, data.name)
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
            console.log('main.js: total = ', response.data.data)
            var data = response.data.data
            if (this.searchFor !== '') {
                for (n in data) {
                    data[n].name = this.highlight(this.searchFor, data[n].name)
                    data[n].address = this.highlight(this.searchFor, data[n].address)
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
