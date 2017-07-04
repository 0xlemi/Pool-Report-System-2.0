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


                    table-class="table table-bordered table-hover"
                    ascending-icon="glyphicon glyphicon-chevron-up"
                    descending-icon="glyphicon glyphicon-chevron-down"

                    :append-params="moreParams"
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
                    sortField: 'id',
                    title: '#'
                },
                {
                    name: 'name',
                    sortField: 'name',
                },
                {
                    name: 'address',
                    sortField: 'address',
                },
                {
                    name: 'price',
                    sortField: 'price',
                },
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
         setFilter: function() {
            this.moreParams = [
                'filter=' + this.searchFor
            ]
            this.$nextTick(function() {
                this.$broadcast('vuetable:refresh')
            })
        },
        resetFilter: function() {
            this.searchFor = ''
            this.setFilter()
        },
        viewProfile: function(id) {
            console.log('view profile with id:', id)
        }
    },
    events: {
        'vuetable:action': function(action, data) {
            console.log('vuetable:action', action, data)
            if (action == 'view-item') {
                this.viewProfile(data.id)
            }
        },
        'vuetable:load-error': function(response) {
            console.log('Load Error: ', response)
        }
    }

});
</script>
