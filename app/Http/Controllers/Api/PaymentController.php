<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PRS\Transformers\PaymentTransformer;
use App\Payment;

class PaymentController extends ApiController
{

    protected $paymentTrasformer;

    public function __construct(PaymentTransformer $paymentTrasformer)
    {
        $this->paymentTrasformer = $paymentTrasformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $invoiceSeqId)
    {
        $this->validate($request, [
            'limit' => 'integer|between:1,25'
        ]);

        $limit = ($request->limit)?: 5;
        $payments = $this->loggedUserAdministrator()->invoicesBySeqId($invoiceSeqId)->payments()->paginate($limit);

        return $this->respondWithPagination(
            $payments,
            $this->paymentTrasformer->transformCollection($payments)
        );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $invoiceSeqId)
    {
        // validation
        $this->validate($request, [
            'amount' => 'required|numeric|max:10000000',
        ]);

        $invoice = $this->loggedUserAdministrator()->invoicesBySeqId($invoiceSeqId);

        $payment = $invoice->payments()->create($request->all());

        if($payment){
            return $this->respondPersisted(
                'Payment created successfully.',
                $this->paymentTrasformer->transform(Payment::findOrFail($payment->id))
            );
        }
        return response()->json(['error' => 'Payment was not created.'] , 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($seqId)
    {
        $payment = $this->loggedUserAdministrator()->paymentsBySeqId($seqId);

        return $this->respond([
            'data' => $this->paymentTrasformer->transform($payment)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($seqId)
    {
        $payment = $this->loggedUserAdministrator()->paymentsBySeqId($seqId);

        if($payment->delete()){
            return response()->json([
                'message' => 'Payment deleted successfully.',
                ]);
        }
        return response()->json(['error' => 'Payment was not deleted.'] , 500);
    }
}
