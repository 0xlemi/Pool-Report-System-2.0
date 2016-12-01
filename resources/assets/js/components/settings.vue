<template>
<section class="tabs-section">

    <!-- Tab Navigation -->
    <div class="tabs-section-nav">
        <div class="tbl">
            <ul class="nav" role="tablist">

                <li class="nav-item">
                    <a class="nav-link active" href="#tabs-1-tab-1" role="tab" data-toggle="tab">
                        <span class="nav-link-in">
                            <i class="font-icon font-icon-user"></i>&nbsp;
                            Profile
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#tabs-1-tab-2" role="tab" data-toggle="tab">
                        <span class="nav-link-in">
                            <i class="font-icon font-icon-build"></i>&nbsp;
                            Customization
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#tabs-1-tab-3" role="tab" data-toggle="tab">
                        <span class="nav-link-in">
                            <i class="font-icon font-icon-mail"></i>&nbsp;
                            Notifications
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#tabs-1-tab-4" role="tab" data-toggle="tab">
                        <span class="nav-link-in">
                            <i class="glyphicon glyphicon-credit-card"></i>&nbsp;
                            Billing
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#tabs-1-tab-5" role="tab" data-toggle="tab">
                        <span class="nav-link-in">
                            <i class="font-icon font-icon-lock"></i>&nbsp;
                            Permissions
                        </span>
                    </a>
                </li>

            </ul>
        </div>
    </div><!--.tabs-section-nav-->

    <!-- Tabs Content -->
    <div class="tab-content">

        <!-- Profile -->
        <div role="tabpanel" class="tab-pane fade in active" id="tabs-1-tab-1">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <account-settings></account-settings>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr>
                    <change-email></change-email>
                </div>
                <div class="col-md-12">
                    <br>
                    <change-password></change-password>
                </div>
            </div>
        </div>

        <!-- Costumization -->
        <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-2">
            Costumization
        </div>

        <!-- Notifications -->
        <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-3">
            notifications
        </div>

        <!-- Billing -->
        <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-4">
            <div class="row">
                <div class="col-md-12">
                    <br>
                    <billing :subscribed="billing.subscribed" :last-four="billing.lastFour" :plan="billing.plan" :active-objects="billing.activeObjects"
                                :billable-objects="billing.billableObjects" :free-objects="billing.freeObjects">
                    </billing>
                </div>
            </div>
        </div>

        <!-- Permissions -->
        <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-5">
            <div class="row">
                <div class="col-md-12">
                    <br>
                    <div class="form-group">
                        <permissions :permissions="permissions.supervisor" tabs-number="2"
                                    :button="{ tag: 'Supervisor Permissions', class: 'btn-warning', icon: 'glyphicon glyphicon-eye-open'}">
                        </permissions>
                    </div>
                    <div class="form-group">
                        <permissions :permissions="permissions.technician" tabs-number="3"
                                    :button="{ tag: 'Technicians Permissions', class: 'btn-info', icon: 'glyphicon glyphicon-wrench'}">
                        </permissions>
                    </div>
                </div>
            </div>
        </div>

    </div><!--.tab-content-->

</section><!--.tabs-section-->
</template>

<script>
import accountSettings from './accountSettings.vue';
import changeEmail from './changeEmail.vue';
import changePassword from './changePassword.vue';

import billing from './billing.vue';
import Permissions from './Permissions.vue';

export default {
    props: ['billing', 'permissions'],
    components: {
        accountSettings,
        changeEmail,
        changePassword,
        billing,
        Permissions
    }

}
</script>
