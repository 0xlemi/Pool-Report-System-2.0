<?php

namespace App\Http\Controllers\Stripe;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;
use App\Company;
use App\PRS\Classes\Logged;

class SubscriptionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create stripe customer for the first time
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function subscribe(Request $request)
    {
        if(!Logged::user()->selectedUser->isRole('admin')){
            abort(403, 'You need to be System Administrator to do this operation');
        }

        $company = Logged::company();

        // Admin is upgrading the credit card.
        if ($company->subscribed('main')) {
            return $this->updateCreditCard($company, $request->stripeToken);
        }

        // Admin is subscribing for the first time
        $result = $company->newSubscription('main', 'pro')
                    ->create($request->stripeToken)
                    ->updateQuantity($company->billableObjects());
        if($result){
            flash()->overlay('Upgraded to Pro',
                    'You are now free to add as much technicians and supervisors as you need.',
                    'success');
            return redirect()->back();
        }
            flash()->overlay('Error upgrading to Pro',
                    'Send us an email to support@poolreprotsystem to upgrade you manualy.',
                    'error');
            return redirect()->back();
    }

    private function updateCreditCard(Company $company, string $stripeToken)
    {
        if(!Logged::user()->selectedUser->isRole('admin')){
            abort(403, 'You need to be System Administrator to do this operation');
        }

        $company->updateCard($stripeToken);
        $result = $company->subscription('main')
                    ->updateQuantity($company->billableObjects());

        if($result){
            flash()->overlay('Credit Card Changed', 'Your credit card was updated successfully.', 'success');
            return redirect()->back();
        }
        flash()->overlay('Error changing credit card',
                'Send us an email to support@poolreprotsystem to change your credit card manualy.',
                'error');
        return redirect()->back();
    }

    public function upgradeSubscription(Request $request)
    {
        if(!Logged::user()->selectedUser->isRole('admin')){
            abort(403, 'You need to be System Administrator to do this operation');
        }

        $company = Logged::company();

        if($company->subscribedToPlan('free', 'main')) {
            return $company->subscription('main')
                            ->swap('pro')
                            ->updateQuantity($company->billableObjects());
        }elseif($company->subscribedToPlan('pro', 'main')){
            return response()->json(['error' => 'You cannot upgrade if you are on pro subscription.'], 422);
        }

    }

    public function downgradeSubscription(Request $request)
    {
        if(!Logged::user()->selectedUser->isRole('admin')){
            abort(403, 'You need to be System Administrator to do this operation');
        }

        $company = Logged::company();

        if ($company->subscribedToPlan('pro', 'main')) {
            $result = $company->subscription('main')->swap('free');
            if($result){
                return (string) $company->setBillibleUsersAsInactive();
            }
        }elseif($company->subscribedToPlan('free', 'main')){
            return response()->json(['error' => 'You cannot downgrade if you are on free subscription.'], 422);
        }
    }
}
