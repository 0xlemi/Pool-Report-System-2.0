<template>

    <button type="button" class="btn btn-primary btn-sm" @click="$broadcast('openModal', 'serviceContractsInovice')">Services Contract Payments in Month</button>

    <modal title="Service Contract Payments in Month" id="serviceContractsInovice" modal-class="modal-lg">
        <div class="col-md-12">
            <div class="col-md-5">
                <div class="input-group">
					<div class="input-group-addon">Services with</div>
                    <div class="input-group-btn">
						<button type="button" class="btn dropdown-toggle" :class="{'disabled' : loading}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						   {{ activeOption }}
						</button>
						<div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" @click="filterActive('')">All</button>
    						<button class="dropdown-item" @click="filterActive('1')">Active Contract</button>
    						<button class="dropdown-item" @click="filterActive('0')">No Contract or Inactive</button>
						</div>
					</div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="input-group pull-right">
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
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <br>
                <div class="input-group pull-right">
					<div class="input-group-addon">Invoices charged in </div>
                    <div class="input-group-btn">
						<button type="button" class="btn dropdown-toggle" :class="{'disabled' : loading}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{{ selectedMonth }}
						</button>
						<div class="dropdown-menu dropdown-menu-right">
                        	<button v-for="month in months" class="dropdown-item"
                                    @click="filterMonth(month.month, month.year, $index)">
                                {{ month.monthText+" "+month.year }}
                            </button>
						</div>
					</div>
					<div class="input-group-addon">where payments are</div>
                    <div class="input-group-btn">
						<button type="button" class="btn dropdown-toggle" :class="{'disabled' : loading}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    {{ onTimeOption }}
						</button>
						<div class="dropdown-menu dropdown-menu-right">
    						<button class="dropdown-item" @click="filterOnTime('')">All</button>
    						<button class="dropdown-item" @click="filterOnTime('1')">On Time</button>
    						<button class="dropdown-item" @click="filterOnTime('0')">Late</button>
						</div>
					</div>
				</div>
            </div>
            <div class="table-responsive">
                <br>
                <vuetable v-ref:vuetable
                    :api-url="url"
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
                    :wrapper-class="vuetableWrapper"
                    table-wrapper=".vuetable-wrapper"
                ></vuetable>
            </div>
            <div class="col-md-10 col-md-offset-2">
                <div class="form-group pull-right">
                    <div class="col-md-6">
    					<div class="input-group">
    						<div class="input-group-addon">Total Charged </div>
    						<input type="text" class="form-control" :value="totalCharged[totalChargedSelected]" readonly>
                            <div class="input-group-btn dropup">
    							<button type="button" class="btn dropdown-toggle" data-toggle="dropdown" :class="{'disabled' : loading}" aria-haspopup="true" aria-expanded="false">
    								{{ totalChargedSelected }}
    							</button>
    							<div class="dropdown-menu dropdown-menu-right">
            						<button v-for="(index, charged) in totalCharged" class="dropdown-item" @click="changeChargedSelected(index)">{{ index }}</button>
        						</div>
    						</div>
    					</div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
    						<div class="input-group-addon">Total Paid </div>
    						<input type="text" class="form-control" :value="totalPaid[totalPaidSelected]" readonly>
                            <div class="input-group-btn dropup">
    							<button type="button" class="btn dropdown-toggle" data-toggle="dropdown" :class="{'disabled' : loading}" aria-haspopup="true" aria-expanded="false">
    								{{ totalPaidSelected }}
    							</button>
    							<div class="dropdown-menu dropdown-menu-right">
            						<button v-for="(index, paid) in totalPaid" class="dropdown-item" @click="changePaidSelected(index)">{{ index }}</button>
        						</div>
    						</div>
    					</div>
				    </div>
				</div>
            </div>
        </div>
        <span slot="buttonsBefore">
            <a :href="pdfUrl" slot="buttonsBefore" class="btn btn-danger pull-left" :class="{'disabled' : loading}" target="_blank">
                <span class="fa fa-file-pdf-o"></span>&nbsp;&nbsp;&nbsp;Get PDF
            </a>
            &nbsp;&nbsp;
            <a :href="excelUrl"  class="btn btn-success pull-left" :class="{'disabled' : loading}" target="_blank">
                <span class="fa fa-file-excel-o"></span>&nbsp;&nbsp;&nbsp;Get Excel
            </a>
        </span>
    </modal>

</template>

<script>
let moment = require('moment');
let momentMonths = [
    moment().subtract(6, 'months'),
    moment().subtract(5, 'months'),
    moment().subtract(4, 'months'),
    moment().subtract(3, 'months'),
    moment().subtract(2, 'months'),
    moment().subtract(1, 'months'),
    moment().add(0, 'months'),
    moment().add(1, 'months'),
    moment().add(2, 'months'),
    moment().add(3, 'months'),
    moment().add(4, 'months'),
    moment().add(5, 'months'),
];
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
            paymentsMonth: 'month',
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
                    name: 'payments_month',
                    title: 'Sum Payments on Month'
                }
			],


            months: [
                {
                    month: momentMonths[0].format('MM'),
                    year: momentMonths[0].format('YYYY'),
                    monthText: momentMonths[0].format('MMMM'),
                },
                {
                    month: momentMonths[1].format('MM'),
                    year: momentMonths[1].format('YYYY'),
                    monthText: momentMonths[1].format('MMMM'),
                },
                {
                    month: momentMonths[2].format('MM'),
                    year: momentMonths[2].format('YYYY'),
                    monthText: momentMonths[2].format('MMMM'),
                },
                {
                    month: momentMonths[3].format('MM'),
                    year: momentMonths[3].format('YYYY'),
                    monthText: momentMonths[3].format('MMMM'),
                },
                {
                    month: momentMonths[4].format('MM'),
                    year: momentMonths[4].format('YYYY'),
                    monthText: momentMonths[4].format('MMMM'),
                },
                {
                    month: momentMonths[5].format('MM'),
                    year: momentMonths[5].format('YYYY'),
                    monthText: momentMonths[5].format('MMMM'),
                },
                {
                    month: momentMonths[6].format('MM'),
                    year: momentMonths[6].format('YYYY'),
                    monthText: momentMonths[6].format('MMMM'),
                },
                {
                    month: momentMonths[7].format('MM'),
                    year: momentMonths[7].format('YYYY'),
                    monthText: momentMonths[7].format('MMMM'),
                },
                {
                    month: momentMonths[8].format('MM'),
                    year: momentMonths[8].format('YYYY'),
                    monthText: momentMonths[8].format('MMMM'),
                },
                {
                    month: momentMonths[9].format('MM'),
                    year: momentMonths[9].format('YYYY'),
                    monthText: momentMonths[9].format('MMMM'),
                },
                {
                    month: momentMonths[10].format('MM'),
                    year: momentMonths[10].format('YYYY'),
                    monthText: momentMonths[10].format('MMMM'),
                },
                {
                    month: momentMonths[11].format('MM'),
                    year: momentMonths[11].format('YYYY'),
                    monthText: momentMonths[11].format('MMMM'),
                }
            ],
            // itemActions: [
            //     { name: 'view-item', label: '', icon: 'zoom icon', class: 'ui teal button' },
            //     { name: 'edit-item', label: '', icon: 'edit icon', class: 'ui orange button'},
            //     { name: 'delete-item', label: '', icon: 'delete icon', class: 'ui red button' }
            // ],
            moreParams: [],
            totalParams: {},
            totalCharged: {},
            totalPaid: {},
            totalChargedSelected: 'USD',
            totalPaidSelected: 'USD',
            activeOption: 'All',
            onTimeOption: 'All',
            currentMonth: Number(moment().format("MM"))-1,
            searchFor: '',
            loading: false,
            url: Laravel.url+'query/servicescontractinvoices',
            pdfUrl: Laravel.url+'query/servicescontractinvoices/pdf',
            excelUrl: Laravel.url+'query/servicescontractinvoices/excel'
        }
    },
    computed:{
        vuetableWrapper(){
            if(this.loading){
                return 'vuetable-wrapper loading';
            }
                return 'vuetable-wrapper';
        },
        selectedMonth(){
            return this.months[this.currentMonth].monthText;
        }
    },
    methods: {
        viewProfile(id){
            console.log('view profile with id:', id)
        },
        /** Other Functions **/
        filterOnTime(onTime){
            if(onTime == ''){
                this.onTimeOption = "All";
            }else if(onTime == '1'){
                this.onTimeOption = "On Time";
            }else if(onTime == '0'){
                this.onTimeOption = "Late";
            }
            this.totalParams['ontime'] = 'ontime=' + onTime;
            this.updateParams()
            this.$nextTick(function() {
                this.$broadcast('vuetable:refresh')
            });

        },
        filterMonth(month, year, index){
            this.currentMonth = index;
            this.totalParams['month'] = 'month=' + Number(month);
            this.totalParams['year'] = 'year=' + Number(year);
            this.updateParams()
            this.$nextTick(function() {
                this.$broadcast('vuetable:refresh')
            });
        },
        filterActive(active){
            if(active == ''){
                this.activeOption = "All";
            }else if(active == '1'){
                this.activeOption = "Active Contract";
            }else if(active == '0'){
                this.activeOption = "No Contract or Inactive";
            }

            this.totalParams['contract'] = 'contract=' + active;
            this.updateParams()
            this.$nextTick(function() {
                this.$broadcast('vuetable:refresh')
            });
        },
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
        // PDF URL
        updateParams(){
            let totalParams = this.totalParams;
            let moreParams = Object.keys(totalParams).map(function(key){return totalParams[key]});
            this.moreParams = moreParams;
            let params = moreParams.join("&");
            this.pdfUrl = this.url+'/pdf?'+params;
            this.excelUrl = this.url+'/excel?'+params;
        },
        // highlight
        preg_quote: function( str ) {
            return (str+'').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:])/g, "\\$1");
        },
        highlight(needle, haystack) {
            return haystack.replace(
                new RegExp('(' + this.preg_quote(needle) + ')', 'ig'),
                '<mark>$1</mark>'
            )
        },
        // Total
        changeChargedSelected(charged){
            this.totalChargedSelected = charged;
        },
        changePaidSelected(paid){
            this.totalPaidSelected = paid;
        }
    },
    events: {
        'vuetable:loading': function(){
            this.loading = true;
        },
        'vuetable:loaded': function(){
            this.loading = false;
        },
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
            var data = response.data.data
            this.totalCharged = response.data.total_charged;
            this.totalPaid = response.data.total_paid;
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
