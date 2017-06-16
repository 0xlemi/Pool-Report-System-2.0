<?php

namespace App\Http\Controllers\Stripe;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PRS\Classes\Logged;
use Stripe\Customer;

class PaymentSourcesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Logged::user();

        return $user->paymentSources;

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Logged::user();
        if(!$user->selectedUser->isRole('client')){
            return response()->json([ 'message' => 'You need to be client to run this operation.'], 403);
        }

        $company = Logged::company();

        $customer = Customer::create([
            'email' => $user->email,
            'description' => 'Customer for '.$company->name,
            'source' => $request->stripeToken
        ]);

        // if($company->stripe_id == null){
        //     return response()->json([ 'message' => 'The system don\'t have a stripe account associated.'], 403);
        // }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($card_id)
    {
        //
    }
}
