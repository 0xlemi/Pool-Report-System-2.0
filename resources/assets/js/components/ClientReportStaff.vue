<template>
<div class="contact-row-list">
    <article @click="$broadcast('openModal', 'personModal')" class="contact-row">
	    <div class="user-card-row">
            <div class="tbl-row">
                <div class="tbl-cell tbl-cell-photo">
                    <img :src="person.photo.icon" :alt="person.photo.title">
                </div>
                <div class="tbl-cell">
                    <p class="user-card-row-name">{{ person.full_name }}</p>
                    <p class="user-card-row-mail">{{ person.email }}</p>
                </div>
                <div class="tbl-cell tbl-cell-status">{{ person.role }}</div>
            </div>
        </div>
    </article>
</div>

<modal :title="person.role" id="personModal">
    <div class="col-md-12">

        <div v-if="person.photo" class="form-group row">
			<label class="col-sm-2 form-control-label">{{ person.role }} photo</label>
			<div class="col-sm-10">
				<div class="col-md-5">
					<photo :image="person.photo" :can-delete="false"></photo>
				</div>
			</div>
		</div>

        <div class="form-group row">
	        <label class="col-sm-2 form-control-label">ID</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control"  v-model="person.id">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label">Name</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control" v-model="person.full_name">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label">Email</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control"  v-model="person.email">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label">Mobile Phone</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control"  v-model="person.cellphone">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label">Address Line</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control"  v-model="person.address">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 form-control-label">Language</label>
			<div class="col-sm-10">
				<input type="text" readonly class="form-control"  v-model="person.language">
			</div>
		</div>

    </div>
</modal>

</template>

<script>
import modal from './modal.vue';
import photo from './photo.vue';

export default {
    props:['person'],
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
