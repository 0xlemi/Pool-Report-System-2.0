<template>
<section class="tabs-section">
	<div class="tabs-section-nav tabs-section-nav-inline">
		<ul class="nav" role="tablist">
			<li v-for="(key, report) in reports" class="nav-item">
				<a class="nav-link" :class="{'active': key == 0 }" href="#tabs-1-tab-{{ report['id'] }}" role="tab" data-toggle="tab">
                    {{ report['service']['name'] }}
				</a>
			</li>
		</ul>
	</div><!--.tabs-section-nav-->

	<div class="tab-content">
		<div v-for="(key, report) in reports" role="tabpanel" class="tab-pane fade in" :class="{'active': key == 0 }" id="tabs-1-tab-{{ report['id'] }}">
                {{ report['service']['name'] }}
        </div>
	</div><!--.tab-content-->
</section><!--.tabs-section-->
</template>

<script>

export default {
    props: ['reports'],

}
</script>
