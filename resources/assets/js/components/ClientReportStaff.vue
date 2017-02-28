<template>
<div class="contact-row-list">
    <article @click="$broadcast('openModal', 'supervisorModal')" class="contact-row">
	    <div class="user-card-row">
            <div class="tbl-row">
                <div class="tbl-cell tbl-cell-photo">
                    <img :src="supervisor.photo.icon" :alt="supervisor.photo.title">
                </div>
                <div class="tbl-cell">
                    <p class="user-card-row-name">{{ supervisor.full_name }}</p>
                    <p class="user-card-row-mail">{{ supervisor.email }}</p>
                </div>
                <div class="tbl-cell tbl-cell-status">Supervisor</div>
            </div>
        </div>
    </article>
    <article @click="$broadcast('openModal', 'technicianModal')" class="contact-row">
	    <div class="user-card-row">
            <div class="tbl-row">
                <div class="tbl-cell tbl-cell-photo">
                    <img :src="technician.photo.icon" :alt="technician.photo.title">
                </div>
                <div class="tbl-cell">
                    <p class="user-card-row-name">{{ technician.full_name }}</p>
                    <p class="user-card-row-mail">{{ technician.username }}</p>
                </div>
                <div class="tbl-cell tbl-cell-status">Technician</div>
            </div>
        </div>
    </article>
</div>

<modal title="Supervisor" id="supervisorModal">
    <div class="col-md-12">

        <div v-if="supervisor.photo" class="form-group row">
			<label class="col-sm-2 form-control-label">Supervisor photo</label>
			<div class="col-sm-10">
				<div class="col-md-5">
					<photo :image="supervisor.photo" :can-delete="false"></photo>
				</div>
			</div>
		</div>

        <div class="form-group row">
	        <label class="col-sm-2 form-control-label">ID</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control"  v-model="supervisor.id">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label">Name</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control" v-model="supervisor.full_name">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label">Email</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control"  v-model="supervisor.email">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label">Mobile Phone</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control"  v-model="supervisor.cellphone">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label">Address Line</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control"  v-model="supervisor.address">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label">Language</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control"  v-model="supervisor.language">
			</div>
		</div>

    </div>
</modal>

<modal title="Technician" id="technicianModal">
    <div class="col-md-12">

        <div v-if="technician.photo" class="form-group row">
			<label class="col-sm-2 form-control-label">Technician photo</label>
			<div class="col-sm-10">
				<div class="col-md-5">
					<photo :image="technician.photo" :can-delete="false"></photo>
				</div>
			</div>
		</div>

        <div class="form-group row">
	        <label class="col-sm-2 form-control-label">ID</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control"  v-model="technician.id">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label">Name</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control" v-model="technician.full_name">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label">Username</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control"  v-model="technician.username">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label">Mobile Phone</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control"  v-model="technician.cellphone">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label">Address Line</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control"  v-model="technician.address">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label">Language</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control"  v-model="technician.language">
			</div>
		</div>

    </div>
</modal>

</template>

<script>
import modal from './modal.vue';
import photo from './photo.vue';

export default {
    props:['supervisor', 'technician'],
    components: {
        modal,
        photo
    }
}
</script>

<style scoped>
.contact-row:hover {
    background-color: white;
    filter:alpha(opacity=50); /* IE */
    opacity: 0.5; /* Safari, Opera */
    -moz-opacity:0.50; /* FireFox */
    z-index: 20;
    height: 100%;
    width: 100%;
    background-repeat:no-repeat;
    background-position:center;
    top: 0px;
    left: 0px;
}
.contact-row:active {
    background-color: #337ab7;
}
</style>
