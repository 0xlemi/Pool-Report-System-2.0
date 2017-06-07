<?php

namespace App\Http\Controllers\Stripe;

use Illuminate\Http\Request;

use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
    /**
     * Handle Stripe Remove Account Webhook
     * @param  array $payload
     * @return Response
     */
    public function handleAccountApplicationDeauthorized($payload)
    {
        // $userRoleCompany = DB::
        // $company->connect_id = null;
        // $company->connect_email = null;
        // $company->connect_token = null;
        // $company->connect_refresh_token = null;
        // $company->connect_business_name = null;
        // $company->connect_business_url = null;
        // $company->connect_country = null;
        // $company->connect_currency = null;
        // $company->connect_support_email = null;
        // $company->connect_support_phone = null;
        // $company->save();
    }

}
