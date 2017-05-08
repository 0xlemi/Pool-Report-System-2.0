<style scoped>
    .action-link {
        cursor: pointer;
    }

    .m-b-none {
        margin-bottom: 0;
    }
</style>

<template>
    <div>

        <section class="card">
            <header class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>
                        OAuth Clients
                    </span>

                    <a class="action-link" @click="$broadcast('openModal', 'createClient')">
                        Create New Client
                    </a>
                </div>
            </header>

            <div class="card-block">
                <!-- Current Clients -->
                <p class="m-b-none" v-if="clients.length === 0">
                    You have not created any OAuth clients.
                </p>

                <table class="table" v-if="clients.length > 0">
                    <tbody>
                        <tr>
                            <th>Client ID</th>
                            <th>Name</th>
                            <th>Secret</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr v-for="client in clients">
                            <!-- ID -->
                            <td style="vertical-align: middle;">
                                {{ client.id }}
                            </td>

                            <!-- Name -->
                            <td style="vertical-align: middle;">
                                {{ client.name }}
                            </td>

                            <!-- Secret -->
                            <td style="vertical-align: middle;">
                                <mark><code>{{ client.secret }}</code></mark>
                            </td>

                            <!-- Edit Button -->
                            <td style="vertical-align: middle;">
                                <a class="action-link" @click="edit(client)">
                                    Edit
                                </a>
                            </td>

                            <!-- Delete Button -->
                            <td style="vertical-align: middle;">
                                <a class="action-link text-danger" @click="destroy(client)">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Create Client Modal -->
        <modal title="Create Client" id="createClient">
            <!-- Form Errors -->
            <div class="alert alert-danger" v-if="createForm.errors.length > 0">
                <p><strong>Whoops!</strong> Something went wrong!</p>
                <br>
                <ul>
                    <li v-for="error in createForm.errors">
                        {{ error }}
                    </li>
                </ul>
            </div>

            <!-- Create Client Form -->
            <form class="form-horizontal" role="form">
                <!-- Name -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Name</label>

                    <div class="col-md-7">
                        <input id="create-client-name" type="text" class="form-control"
                                                    @keyup.enter="store" v-model="createForm.name">
                        <small class="text-muted">Something your users will recognize and trust.</small>
                    </div>
                </div>

                <!-- Redirect URL -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Redirect URL</label>

                    <div class="col-md-7">
                        <input type="text" class="form-control" name="redirect"
                                        @keyup.enter="store" v-model="createForm.redirect">
                        <small class="text-muted">Your application's authorization callback URL.</small>
                    </div>
                </div>
            </form>
            <button slot="buttons" type="button" class="btn btn-primary" @click="store">
                Create
            </button>
        </modal>

        <!-- Edit Client Modal -->
        <modal title="Edit Client" id="editClient">
            <!-- Form Errors -->
            <div class="alert alert-danger" v-if="editForm.errors.length > 0">
                <p><strong>Whoops!</strong> Something went wrong!</p>
                <br>
                <ul>
                    <li v-for="error in editForm.errors">
                        {{ error }}
                    </li>
                </ul>
            </div>

            <!-- Edit Client Form -->
            <form class="form-horizontal" role="form">
                <!-- Name -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Name</label>

                    <div class="col-md-7">
                        <input id="edit-client-name" type="text" class="form-control"
                                                    @keyup.enter="update" v-model="editForm.name">

                        <span class="help-block">
                            Something your users will recognize and trust.
                        </span>
                    </div>
                </div>

                <!-- Redirect URL -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Redirect URL</label>

                    <div class="col-md-7">
                        <input type="text" class="form-control" name="redirect"
                                        @keyup.enter="update" v-model="editForm.redirect">

                        <span class="help-block">
                            Your application's authorization callback URL.
                        </span>
                    </div>
                </div>
            </form>
            <button slot="buttons" type="button" class="btn btn-primary" @click="update">
                Save Changes
            </button>
        </modal>
    </div>
</template>

<script>
import modal from '../modal.vue';
    export default {
        components: {
            modal
        },
        /*
         * The component's data.
         */
        data() {
            return {
                clients: [],

                createForm: {
                    errors: [],
                    name: '',
                    redirect: ''
                },

                editForm: {
                    errors: [],
                    name: '',
                    redirect: ''
                }
            };
        },

        /**
         * Prepare the component
         */
        ready() {
            this.prepareComponent();
        },
        methods: {
            /**
             * Prepare the component.
             */
            prepareComponent() {
                this.getClients();
            },

            /**
             * Get all of the OAuth clients for the user.
             */
            getClients() {
                axios.get('/oauth/clients')
                        .then(response => {
                            this.clients = response.data;
                        });
            },

            /**
             * Create a new OAuth client for the user.
             */
            store() {
                this.persistClient(
                    'post', '/oauth/clients',
                    this.createForm, 'createClient'
                );
            },

            /**
             * Edit the given client.
             */
            edit(client) {
                this.editForm.id = client.id;
                this.editForm.name = client.name;
                this.editForm.redirect = client.redirect;

                this.$broadcast('openModal', 'editClient');
            },

            /**
             * Update the client being edited.
             */
            update() {
                this.persistClient(
                    'put', '/oauth/clients/' + this.editForm.id,
                    this.editForm, 'editClient'
                );
            },

            /**
             * Persist the client to storage using the given form.
             */
            persistClient(method, uri, form, modal) {
                form.errors = [];

                axios[method](uri, form)
                    .then(response => {
                        this.getClients();

                        form.name = '';
                        form.redirect = '';
                        form.errors = [];

                        this.$broadcast('closeModal', modal);
                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            form.errors = _.flatten(_.toArray(error.response.data));
                        } else {
                            form.errors = ['Something went wrong. Please try again.'];
                        }
                    });
            },

            /**
             * Destroy the given client.
             */
            destroy(client) {
                axios.delete('/oauth/clients/' + client.id)
                        .then(response => {
                            this.getClients();
                        });
            }
        }
    }
</script>
