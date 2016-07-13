<script>
var Vue = require('vue');

  export default Vue.directive('ajax', {
        params: ['title', 'message'],
        http: {
            headers: {
                // You could also store your token in a global object,
                // and reference it here. APP.token
                'X-CSRF-TOKEN': (document.querySelector('input[name="_token"]') ? document.querySelector('input[name="_token"]').value : '')
            }
        },

        bind: function () {
            this.el.addEventListener(
                'submit', this.onSubmit.bind(this)
            );
        },

        onSubmit: function (e) {
            e.preventDefault();
            var requestType = this.getRequestType();

            this.vm
                .$http[requestType](this.el.action, this.getFormData())
                .then(this.onComplete.bind(this))
                .catch(this.onError.bind(this));
        },

        onComplete: function () {
            if (this.params.title && this.params.message) {
                swal({
                  title: this.params.title,
                  text: this.params.message,
                  type: 'success',
                  timer: 2000,
                  showConfirmButton: false
                });
            }
        },

        onError: function (response) {
            // first show validation errors
            var errors = '';
            $.each(response.data, function(key, value){
              errors += value+'\n'
            });
            swal("Oops, there was an error", errors, "error");
        },

        getRequestType: function () {
            var method = this.el.querySelector('input[name="_method"]');

            return (method ? method.value : this.el.method).toLowerCase();
        },
          getFormData: function() {
            // You can use $(this.el) in jQuery and you will get the same thing.
            var serializedData = $(this.el).serializeArray();
            var objectData = {};
            $.each(serializedData, function() {
                if (objectData[this.name] !== undefined) {
                    if (!objectData[this.name].push) {
                        objectData[this.name] = [objectData[this.name]];
                    }
                    objectData[this.name].push(this.value || '');
                } else {
                    objectData[this.name] = this.value || '';
                }
            });
            return objectData;
        },
    });
</script>
