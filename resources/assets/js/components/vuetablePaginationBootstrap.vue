<template>
    <nav>
        <ul class="pull-right pagination">
            <li class="{{isOnFirstPage ? disabledClass : ''}} page-item">
                <a class="page-link" @click="loadPage('prev')"><i class="glyphicon glyphicon-chevron-left"></i></a>
            </li>
            <template v-for="n in totalPage">
                <li class="{{isCurrentPage(n+1) ? ' active' : ''}} page-item">
                    <a class="page-link" @click="loadPage(n+1)"> {{ n+1 }}</a>
                </li>
            </template>
            <li class="{{isOnLastPage ? disabledClass : ''}} page-item">
                <a class="page-link" @click="loadPage('next')"><i class="glyphicon glyphicon-chevron-right"></i></a>
            </li>
        </ul>
    </nav>
</template>

<script>
import PaginationMixin from 'vuetable/src/components/VuetablePaginationMixin.vue';
export default {
    mixins: [PaginationMixin],
    methods: {
        loadPage: function(page) {
            this.$dispatch('vuetable-pagination:change-page', page)
        },
    },
}
</script>
