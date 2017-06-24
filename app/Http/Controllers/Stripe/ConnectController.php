<?php

namespace App\Http\Controllers\Stripe;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use Guzzle;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\Account;
use GuzzleHttp\Exception\ClientException;
use App\PRS\Classes\Logged;

class ConnectController extends Controller
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

    public function redirectToProvider()
    {
        if(Logged::user()->selectedUser->isRole('admin')){
            return Socialite::with('stripe')->redirect();
        }
        abort(403, 'You need to be System Administrator to do this operation');
    }

    public function handleProviderCallback(Request $request)
    {
        if(!Logged::user()->selectedUser->isRole('admin')){
            abort(403, 'You need to be System Administrator to do this operation');
        }
        if($request->error == 'access_denied'){
            flash()->overlay(
                                'Access to stripe was denied',
                                'Please try again, and accept when it ask you for access to stripe account. Or contact us at support@poolreportsystem.com',
                                'error'
                            );
            return redirect('settings');
        }

        $user = Socialite::driver('stripe')->stateless()->user();
        $company = Logged::company();
        $company->connect_id = $user->id;
        $company->connect_email = $user->email;
        $company->connect_token = $user->token;
        $company->connect_refresh_token = $user->refreshToken;
        $company->connect_business_name = $user->user['business_name'];
        $company->connect_business_url = $user->user['business_url'];
        $company->connect_country = $user->user['country'];
        $company->connect_currency = $user->user['default_currency'];
        $company->connect_support_email = $user->user['support_email'];
        $company->connect_support_phone = $user->user['support_phone'];
        $company->save();
        flash()->success('Stripe Account Connected', 'You can now recive payments in through the plataform.');
        return redirect('settings');
    }

    public function removeAccount()
    {
        if(!Logged::user()->selectedUser->isRole('admin')){
            return response()->json([ 'message' => 'You need to be System Administrator to run this operation.'], 403);
        }

        $company = Logged::company();
        if($company->connect_id == null){
            return response()->json([ 'message' => 'The system don\'t have a stripe account associated.'], 403);
        }

        try {
            $response = Guzzle::post(
                'https://connect.stripe.com/oauth/deauthorize',
                [
                    'headers' => [
                        'Authorization' => 'Bearer '.env('STRIPE_SECRET')
                    ],
                    'form_params' => [
                        'client_id' => config('services.stripe.client_id'),
                        'stripe_user_id' => $company->connect_id
                    ]
                ]
            );
        } catch (ClientException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents());
            // If throws invalid client error it means that they diconnected from the stripe account.
            // And continue with the removal if that is the case.
            // if is other error then throw a failed message
            if($error->error =! 'invalid_client'){
                return response()->json([ 'error' => 'We could not remove your stripe account from Pool Report System, please log in into your Stipe account and remove it there.'], 500);
            }
        }

        $company->connect_id = null;
        $company->connect_email = null;
        $company->connect_token = null;
        $company->connect_refresh_token = null;
        $company->connect_business_name = null;
        $company->connect_business_url = null;
        $company->connect_country = null;
        $company->connect_currency = null;
        $company->connect_support_email = null;
        $company->connect_support_phone = null;
        $company->save();
        return response()->json([ 'message' => 'Stripe Account Removal Successfull']);
    }

    /**
     * Save client customer information .
     * @return response
     */
    public function createCustomer(Request $request)
    {
        $user = Logged::user();
        if(!$user->selectedUser->isRole('client')){
            return response()->json([ 'error' => 'You need to be client to run this operation.'], 403);
        }

        $company = Logged::company();

        if($company->connect_id == null){
            flash()->overlay('We cannot add your Credit Card',
                    'Your pool company don\'t support receiving payments throught the platform.',
                    'error');
            return redirect()->back();
        }

        // If it was registered as stripe client remove him
        if($user->stripe_id){
            $oldCustomer = Customer::retrieve($user->stripe_id);
            $oldCustomer->delete();
        }

        $customer = Customer::create([
            'email' => $user->email,
            'description' => 'Customer for '.$company->name,
            'source' => $request->stripeToken
        ]);

        $card = $customer->sources->data[0];

        $user->stripe_id = $customer->id;
        $user->card_token = $card->id;
        $user->card_brand = $card->brand;
        $user->card_last_four = $card->last4;
        $user->save();

        if($customer){
            flash()->overlay('Credit Card added',
                    'Your credit card was added successfully.',
                    'success');
            return redirect()->back();
        }
        flash()->overlay('Error adding your creditcard',
                'Send us an email to support@poolreprotsystem to add it manualy.',
                'error');
        return redirect()->back();
    }

    public function removeCustomer()
    {
        $user = Logged::user();
        if(!$user->selectedUser->isRole('client')){
            return response()->json([ 'error' => 'You need to be client to run this operation.'], 403);
        }

        if($user->stripe_id){
            // Remove stripe customer
            $oldCustomer = Customer::retrieve($user->stripe_id);
            $response = $oldCustomer->delete();
            if($response->getLastResponse()->json['deleted']){
                // remove info in the database
                $user->stripe_id = null;
                $user->card_token = null;
                $user->card_brand = null;
                $user->card_last_four = null;
                $user->save();
                return response()->json([ 'message' => 'Customer removed successfully']);
            }
        }
        return response()->json([ 'error' => 'Credit Card was not removed.'], 500);

    }

}
