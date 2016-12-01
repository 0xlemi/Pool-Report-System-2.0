<template>

<button type="button" class="btn" :class="button.class" data-toggle="modal" data-target="#{{'permissionsModal'+tabsNumber}}">
		<i :class="button.icon"></i>&nbsp;&nbsp;&nbsp;
        {{ button.tag }}
</button>

<!-- Modal for Permissions -->
<div class="modal fade" id="{{'permissionsModal'+tabsNumber}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i :class="button.icon"></i>&nbsp;&nbsp;{{ button.tag }}</h4>
      </div>
      <div class="modal-body">
			<div class="row">
                <div class="col-md-12">
                    <section class="tabs-section">
                    	<div class="tabs-section-nav tabs-section-nav-inline">
                    		<ul class="nav" role="tablist">
                    			<li class="nav-item">
                    				<a class="nav-link active" href="#tabs-{{ tabsNumber }}-tab-1" role="tab" data-toggle="tab">
                    					Reports
                    				</a>
                    			</li>
                    			<li class="nav-item">
                    				<a class="nav-link" href="#tabs-{{ tabsNumber }}-tab-2" role="tab" data-toggle="tab">
                    					Work Orders
                    				</a>
                    			</li>
                    			<li class="nav-item">
                    				<a class="nav-link" href="#tabs-{{ tabsNumber }}-tab-3" role="tab" data-toggle="tab">
                    					Services
                    				</a>
                    			</li>
                    			<li class="nav-item">
                    				<a class="nav-link" href="#tabs-{{ tabsNumber }}-tab-4" role="tab" data-toggle="tab">
                    					Clients
                    				</a>
                    			</li>
                    			<li class="nav-item">
                    				<a class="nav-link" href="#tabs-{{ tabsNumber }}-tab-5" role="tab" data-toggle="tab">
                    					Supervisors
                    				</a>
                    			</li>
                    			<li class="nav-item">
                    				<a class="nav-link" href="#tabs-{{ tabsNumber }}-tab-6" role="tab" data-toggle="tab">
                    					Technicians
                    				</a>
                    			</li>
                    		</ul>
                    	</div><!--.tabs-section-nav-->

                    	<div class="tab-content">

                    		<div role="tabpanel" class="tab-pane fade in active" id="tabs-{{ tabsNumber }}-tab-1">
                                <br>
                                <checkbox-list :data="permissions.report"></checkbox-list>
                            </div>

                    		<div role="tabpanel" class="tab-pane fade" id="tabs-{{ tabsNumber }}-tab-2">
                                <br>
                                workOrder permissions
                            </div>

                    		<div role="tabpanel" class="tab-pane fade" id="tabs-{{ tabsNumber }}-tab-3">
                                <br>
                                <checkbox-list :data="permissions.service"></checkbox-list>
                            </div>

                    		<div role="tabpanel" class="tab-pane fade" id="tabs-{{ tabsNumber }}-tab-4">
                                <br>
                                <checkbox-list :data="permissions.client"></checkbox-list>
                            </div>

                    		<div role="tabpanel" class="tab-pane fade" id="tabs-{{ tabsNumber }}-tab-5">
                                <br>
                                <checkbox-list :data="permissions.supervisor"></checkbox-list>
                            </div>

                    		<div role="tabpanel" class="tab-pane fade" id="tabs-{{ tabsNumber }}-tab-6">
                                <br>
                                <checkbox-list :data="permissions.technician"></checkbox-list>
                            </div>
                    	</div><!--.tab-content-->
                    </section><!--.tabs-section-->
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



</template>

<script>
import checkboxList from './checkboxList.vue';

  export default {
    props: ['permissions', 'button', 'tabsNumber'],
    components: {
        checkboxList
    },
  }
</script>

<style scoped>
  h1 {
    color: red;
  }
</style>
