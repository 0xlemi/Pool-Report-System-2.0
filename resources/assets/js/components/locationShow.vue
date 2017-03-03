<template>

<!-- Button     -->
<button @click="clickButton" type="button" class="btn btn-success">
	<i class="font-icon font-icon-earth-bordered"></i>&nbsp;&nbsp;&nbsp;Show Map
</button>

<modal title="Location" id="locationModal" modal-class="modal-lg">
    <div id='serviceMap' style="margin: auto;width: 90%; height: 400px;"></div>
</modal>

</template>

<script>
import modal from './modal.vue';
var Gmaps = require("gmaps.core");
require("gmaps.markers");

export default {
    props: ['latitude', 'longitude'],
    components:{
        modal
    },
	events:{
		modalOpened(){
            this.generate();
		}
	},
    methods:{
        clickButton(){
            let vue = this;
            this.$broadcast('openModal', 'locationModal');
        },
        generate(){
            let map = new Gmaps({
                el: '#serviceMap',
                lat: this.latitude,
                lng: this.longitude,
            });

            map.addMarker({
                lat: this.latitude,
                lng: this.longitude
            });
        }
    }
}
</script>
