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
                        Personal Access Tokens
                    </span>

                    <a class="action-link" @click="$broadcast('openModal', 'createToken')">
                        Create New Token
                    </a>
                </div>
            </header>

            <div class="card-block">
                <!-- No Tokens Notice -->
                <p class="m-b-none" v-if="tokens.length === 0">
                    You have not created any personal access tokens.
                </p>

                <!-- Personal Access Tokens -->
                <table class="table" v-if="tokens.length > 0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="token in tokens">
                            <!-- Client Name -->
                            <td style="vertical-align: middle;">
                                {{ token.name }}
                            </td>

                            <!-- Delete Button -->
                            <td style="vertical-align: middle;">
                                <a class="action-link text-danger" @click="revoke(token)">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Create Token Modal -->
        <modal title="Create Token" id="createToken">
            <!-- Form Errors -->
            <div class="alert alert-danger" v-if="form.errors.length > 0">
                <p><strong>Whoops!</strong> Something went wrong!</p>
                <br>
                <ul>
                    <li v-for="error in form.errors">
                        {{ error }}
                    </li>
                </ul>
            </div>

            <!-- Create Token Form -->
            <form class="form-horizontal" role="form" @submit.prevent="store">
                <!-- Name -->
                <div class="form-group">
                    <label class="col-md-4 control-label">Name</label>

                    <div class="col-md-6">
                        <input id="create-token-name" type="text" class="form-control" name="name" v-model="form.name">
                    </div>
                </div>

                <!-- Scopes -->
                <div class="form-group" v-if="scopes.length > 0">
                    <label class="col-md-4 control-label">Scopes</label>

                    <div class="col-md-6">
                        <div v-for="scope in scopes">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"
                                        @click="toggleScope(scope.id)"
                                        :checked="scopeIsAssigned(scope.id)">

                                        {{ scope.id }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <button slot="buttons" type="button" class="btn btn-primary" @click="store">
                Create
            </button>
        </modal>



        <!-- Access Token Modal -->
        <modal title="Personal Access Token" id="showToken">
            <div class="col-md-12">
                <p>
                    Here is your new personal access token. This is the only time it will be shown so don't lose it!
                    You may now use this token to make API requests.
                </p>

                <pre class="code">{{ accessToken }}</pre>
            </div>
        </modal>

    </div>
</template>

<script>
import modal from '../modal.vue';
    export default {
        components:{
            modal
        },
        /*
         * The component's data.
         */
        data() {
            return {
                accessToken: null,

                tokens: [],
                scopes: [],

                form: {
                    name: '',
                    scopes: [],
                    errors: []
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
                this.getTokens();
                this.getScopes();
            },

            /**
             * Get all of the personal access tokens for the user.
             */
            getTokens() {
                axios.get('/oauth/personal-access-tokens')
                        .then(response => {
                            this.tokens = response.data;
                        });
            },

            /**
             * Get all of the available scopes.
             */
            getScopes() {
                axios.get('/oauth/scopes')
                        .then(response => {
                            this.scopes = response.data;
                        });
            },

            /**
             * Create a new personal access token.
             */
            store() {
                this.accessToken = null;

                this.form.errors = [];

                axios.post('/oauth/personal-access-tokens', this.form)
                        .then(response => {
                            this.form.name = '';
                            this.form.scopes = [];
                            this.form.errors = [];

                            this.tokens.push(response.data.token);

                            this.showAccessToken(response.data.accessToken);
                        })
                        .catch(error => {
                            if (typeof error.response.data === 'object') {
                                this.form.errors = _.flatten(_.toArray(error.response.data));
                            } else {
                                this.form.errors = ['Something went wrong. Please try again.'];
                            }
                        });
            },

            /**
             * Toggle the given scope in the list of assigned scopes.
             */
            toggleScope(scope) {
                if (this.scopeIsAssigned(scope)) {
                    this.form.scopes = _.reject(this.form.scopes, s => s == scope);
                } else {
                    this.form.scopes.push(scope);
                }
            },

            /**
             * Determine if the given scope has been assigned to the token.
             */
            scopeIsAssigned(scope) {
                return _.indexOf(this.form.scopes, scope) >= 0;
            },

            /**
             * Show the given access token to the user.
             */
            showAccessToken(accessToken) {
                this.$broadcast('closeModal', 'createToken')

                this.accessToken = accessToken;

                this.$broadcast('openModal', 'showToken');
            },

            /**
             * Revoke the given token.
             */
            revoke(token) {
                axios.delete('/oauth/personal-access-tokens/' + token.id)
                        .then(response => {
                            this.getTokens();
                        });
            }
        }
    }
</script>
