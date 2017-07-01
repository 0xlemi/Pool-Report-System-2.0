<template>

    <button type="button" class="btn btn-primary btn-sm" @click="$broadcast('openModal', 'serviceContractsInovice')">Services for the Month</button>

    <modal title="Service contracts pending payments for the month" id="serviceContractsInovice" modal-class="modal-lg">
        <vuetable
            api-url="http://prs.dev/query/servicescontractinvoices"
            table-wrapper="#content"
            :fields="columns"
        ></vuetable>
    </modal>

</template>

<script>
import Vue from 'vue';
import modal from './modal.vue';
import Vuetable from 'vuetable/src/components/Vuetable.vue';
import VuetablePagination from 'vuetable/src/components/VuetablePagination.vue';
import VuetablePaginationDropdown  from 'vuetable/src/components/VuetablePaginationDropdown.vue';
Vue.component('vuetable', Vuetable);
Vue.component('vuetable-pagination', VuetablePagination)
Vue.component('vuetable-pagination-dropdown', VuetablePaginationDropdown)

export default Vue.extend({
    components:{
        modal,
    },
    data(){
        return {
            columns: [
                'id',
                'name',
                'address',
                'price',
                'contract_balance',
			],
            itemActions: [
                { name: 'view-item', label: '', icon: 'zoom icon', class: 'ui teal button' },
                { name: 'edit-item', label: '', icon: 'edit icon', class: 'ui orange button'},
                { name: 'delete-item', label: '', icon: 'delete icon', class: 'ui red button' }
            ]
        }
    },
    methods: {
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
