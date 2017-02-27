<template>
    <section class="card" :class="classCard">
    	<header class="card-header card-header-xxl" :class="classHeader">
    		{{ title }}
    	</header>
    	<div class="card-block">
            <div class="row">
                <slot>
                </slot>
            </div>
    	</div>
    </section>
</template>

<script>

export default {
    props: {
        classCard: {
            type: String,
            default: 'card-default'
        },
        classHeader: {
            type: String,
            default: 'card-header-lg'
        },
        title:{
            type: String
        }
    }
}
</script>
