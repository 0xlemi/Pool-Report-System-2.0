<template>

    <header class="box-typical-header-sm" v-if="header">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ header }}:
    </header>

    <div class="form-group row" v-for="permission in data">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-11">
            <div class="checkbox-toggle">
    			<input type="checkbox" id="{{ permission.id }}" v-model="permission.checked" @click="sendRequest(permission)"/>
    			<label for="{{ permission.id }}">{{ permission.name }}</label>
    		</div>
        </div>
    </div>


</template>

<script>
  var Vue = require('vue');

  export default Vue.component('checkbox-list', {
    props: ['header', 'data', 'url'],

    data() {
      return {
        debug: {}
      }
    },

    methods: {
      sendRequest(permission) {
        // HTTP Request or what ever to update the permission
        $.ajax({
            url:      this.url,
            type:     'PATCH',
            dataType: 'json',
            data: {
                    'id': permission.id,
                    'checked': (!permission.checked) ? true : false,
                    'name': permission.name,
                },
            complete: function(xhr, textStatus) {
                //called when complete
                // console.log('complete');
            },
            success: function(data, textStatus, xhr) {
                //called when successful
                // console.log('success');
            },
            error: function(xhr, textStatus, errorThrown) {
                //called when there is an error
                // console.log('error');
            }
        });
      }
    }
  })

</script>
