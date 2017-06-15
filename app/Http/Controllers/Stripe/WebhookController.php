<?php

namespace App\Http\Controllers\Stripe;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use App\Company;

class WebhookController extends CashierController
{
    /**
     * Handle Stripe Remove Account Webhook
     * @param  array $payload
     * @return Response
     */
    public function handleAccountApplicationDeauthorized($payload)
    {
        // This is usless because stripe don't send the account id
        // Resarch more to see if there is something to do.
    }

}
