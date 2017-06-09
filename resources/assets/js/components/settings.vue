<template>
<section class="tabs-section">

    <!-- Tab Navigation -->
    <div class="tabs-section-nav">
        <div class="tbl">
            <ul class="nav" role="tablist">

                <li v-if="profile" class="nav-item">
                    <a class="nav-link active" href="#tabs-1-tab-1" role="tab" data-toggle="tab">
                        <span class="nav-link-in">
                            <i class="font-icon font-icon-user"></i>&nbsp;
                            Profile
                        </span>
                    </a>
                </li>

                <li v-if="customization" class="nav-item">
                    <a class="nav-link" href="#tabs-1-tab-2" role="tab" data-toggle="tab">
                        <span class="nav-link-in">
                            <i class="font-icon font-icon-build"></i>&nbsp;
                            Customization
                        </span>
                    </a>
                </li>

                <li v-if="notifications" class="nav-item">
                    <a class="nav-link" href="#tabs-1-tab-3" role="tab" data-toggle="tab">
                        <span class="nav-link-in">
                            <i class="font-icon font-icon-mail"></i>&nbsp;
                            Notifications
                        </span>
                    </a>
                </li>

                <li v-if="billing" class="nav-item">
                    <a class="nav-link" href="#tabs-1-tab-4" role="tab" data-toggle="tab">
                        <span class="nav-link-in">
                            <i class="glyphicon glyphicon-credit-card"></i>&nbsp;
                            Billing & Payments
                        </span>
                    </a>
                </li>

                <li v-if="permissions" class="nav-item">
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
            <div v-if="profile" class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <account-settings :name="profile.name" :last-name="profile.lastName">
                        </account-settings>
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
                <div class="col-md-12">
                    <hr>
                    <delete-account
                        url="settings/delete/"
                        :icon="profile.deleteIcon">
                    </delete-account>
                </div>
            </div>
        </div>

        <!-- Costumization -->
        <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-2">
            <div v-if="customization" class="row">
                <div class="col-md-12">
                    <customization-settings
                        :name="customization.name"
                        :timezone="customization.timezone"
                        :website="customization.website"
                        :facebook="customization.facebook"
                        :twitter="customization.twitter"
                        :timezone-list="customization.timezoneList"
                        :currencies="customization.currencies">
                    </customization-settings>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-3">
            <div v-if="notifications" class="row">
                <div class="col-md-12">
					<alert type="danger" :message="notificationAlertMessage" :active="notificationAlertActive"></alert>
                    <div class="col-md-12">
                        <notification-settings
                            :settings="notifications.settings">
                        </notification-settings>
                    </div>
                </div>
            </div>
        </div>

        <!-- Billing -->
        <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-4">
            <div v-if="billing" class="row">
                <div class="col-md-12">
                    <br>
                    <billing :subscribed="billing.subscribed" :last-four="billing.lastFour" :plan="billing.plan" :active-objects="billing.activeObjects"
                                :billable-objects="billing.billableObjects" :free-objects="billing.freeObjects" :connect="billing.connect">
                    </billing>
                </div>
            </div>
        </div>

        <!-- Permissions -->
        <div role="tabpanel" class="tab-pane fade" id="tabs-1-tab-5">
            <div v-if="permissions" class="row">
                <div class="col-md-12">
                    <br>
    	                <div class="form-group">
						<h5 class="semibold">Supervisor Permissions:</h5>
                        <permissions :permissions="permissions.supervisor" tabs-number="2"
                                    :button="{ tag: 'Manage Permissions', class: 'btn-warning', icon: 'glyphicon glyphicon-eye-open'}">
                        </permissions>
                    </div>
                    <br>
                    <div class="form-group">
						<h5 class="semibold">Technician Permissions:</h5>
                        <permissions :permissions="permissions.technician" tabs-number="3"
                                    :button="{ tag: 'Manage Permissions', class: 'btn-info', icon: 'glyphicon glyphicon-wrench'}">
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
import notificationSettings from './notificationSettings.vue';
import changeEmail from './changeEmail.vue';
import changePassword from './changePassword.vue';
import deleteAccount from './deleteAccount.vue';
import customizationSettings from './customizationSettings.vue';
import billing from './billing.vue';
import Permissions from './Permissions.vue';
import alert from './alert.vue';

export default {
    props: ['profile', 'customization', 'notifications', 'billing', 'permissions'],
    components: {
        accountSettings,
        customizationSettings,
        notificationSettings,
        changeEmail,
        changePassword,
        deleteAccount,
        billing,
        Permissions,
        alert,
    },
    data(){
		return {
			notificationAlertMessage : '',
			notificationAlertActive : false,
		}
	},
    events: {
		notificationClearError(){
			this.notificationAlertMessage = '';
			this.notificationAlertActive = false;
		},
		notificationPermissionError(){
			this.notificationAlertMessage = "The notification setting was not updated, please try again."
			this.notificationAlertActive = true;
		}
	}

}
</script>
