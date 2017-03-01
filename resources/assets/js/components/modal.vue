<template>
<div class="modal fade" :id="id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" :class="modalClass" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{ title }}</h4>
      </div>
      <div class="modal-body">
			<div class="row">
                <slot>
                </slot>
			</div>
        </div>
      <div class="modal-footer">
        <slot name="buttonsBefore"></slot>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <slot name="buttons"></slot>
      </div>
    </div>
  </div>
</div>
</template>

<script>

export default {
    props: ['title', 'id', 'modalClass'],
    events:{
        openModal(id){
            $('#'+id).modal('show');
        },
        closeModal(id){
            $('#'+id).modal('hide');
        }
    },
}
</script>
