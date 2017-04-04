<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        if($this->getUser()->cannot('list', Payment::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        try {
            $invoice = $this->loggedUserAdministrator()->invoices()->bySeqId($invoiceSeqId);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Invoice with that id, does not exist.');
        }

        $this->validate($request, [
            'limit' => 'integer|between:1,25'
        ]);
        $limit = ($request->limit)?: 5;

        $payments = $invoice->payments()->paginate($limit);

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
        if($this->getUser()->cannot('create', Payment::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        try {
            $invoice = $this->loggedUserAdministrator()->invoices()->bySeqId($invoiceSeqId);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Invoice with that id, does not exist.');
        }

        $this->validate($request, [
            'amount' => 'required|numeric|max:10000000',
        ]);

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
        try {
            $payment = $this->loggedUserAdministrator()->payments()->bySeqId($seqId);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Payment with that id, does not exist.');
        }

        if($this->getUser()->cannot('view', $payment))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

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
        try {
            $payment = $this->loggedUserAdministrator()->payments()->bySeqId($seqId);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Payment with that id, does not exist.');
        }

        if($this->getUser()->cannot('delete', $payment))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if($payment->delete()){
            return response()->json([
                'message' => 'Payment deleted successfully.',
                ]);
        }
        return response()->json(['error' => 'Payment was not deleted.'] , 500);
    }
}
