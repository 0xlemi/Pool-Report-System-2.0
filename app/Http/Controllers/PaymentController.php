<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;

class PaymentController extends PageController
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($invoiceSeqId)
    {
        $this->authorize('list', Payment::class);

        $invoice = $this->loggedUserAdministrator()->invoicesBySeqId($invoiceSeqId);

        $payments = $invoice->payments
                        ->transform(function($item) use ($invoice){
                            return (object) array(
                                'id' => $item->seq_id,
                                'paid' => $item->createdAt()
                                            ->format('d M Y h:i:s A'),
                                'amount' => "{$item->amount} <strong>{$invoice->currency}</strong>",
                            );
                        });
        return response()->json([
            'list' => $payments,
            'currency' => $invoice->currency,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $invoiceSeqId)
    {
        $this->authorize('create', Payment::class);

        $this->validate($request, [
            'amount' => 'required|numeric|max:10000000',
        ]);
        $invoice = $this->loggedUserAdministrator()->invoicesBySeqId($invoiceSeqId);

        $payment = $invoice->payments()->create($request->all());

        if($payment){
            return response()->json([
                'message' => 'Payment was successfully created.'
            ]);
        }
        return response()->json([
                'error' => 'Payment was not created, please try again.'
            ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($paymentSeqId)
    {
        $payment = $this->loggedUserAdministrator()->paymentsBySeqId($paymentSeqId);

        $this->authorize('view', $payment);

        return response()->json([
            'amount' => $payment->amount,
            'paid' => $payment->createdAt()->format('d M Y h:i:s A'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($paymentSeqId)
    {
        $payment = $this->loggedUserAdministrator()->paymentsBySeqId($paymentSeqId);

        $this->authorize('destroy', $payment);

        if($payment->delete()){
            return response()->json([
                'message' => 'Payment was successfully deleted.'
            ]);
        }
        return response()->json([
                'error' => 'Payment was not deleted, please try again.'
            ], 500);
    }
}
