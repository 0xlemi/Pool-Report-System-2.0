<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JavaScript;
use App\Invoice;

class InvoiceController extends PageController
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
    public function index()
    {
        $this->authorize('list', Invoice::class);

        $defaultTableUrl = url('datatables/invoices?closed=0');
        JavaScript::put([
            'invoicesTableUrl' => url('datatables/invoices?closed='),
            'click_url' => url('invoices').'/',
        ]);

        return view('invoices.index', compact('defaultTableUrl'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($seqId)
    {
        $invoice = $this->loggedCompany()->invoices()->bySeqId($seqId);

        $this->authorize('view', $invoice);

        $service = $invoice->invoiceable->service;
        $paymentMethods = [];
        foreach (config('constants.paymentMethods') as $key => $method) {
            $paymentMethods[] = (object) [
                'key' => $method,
                'label' => title_case(str_replace('_', ' ' , $method)),
                'icon' => '',
            ];
        }
        return view('invoices.show', compact('invoice', 'service', 'paymentMethods'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($seqId)
    {
        $invoice = $this->loggedCompany()->invoices()->bySeqId($seqId);

        $this->authorize('delete', $invoice);

        if($invoice->delete()){
            flash()->success('Deleted', 'The invoice was successfuly deleted');
            return response()->json([
                'message' => 'The client was deleted successfully.'
            ]);

        }
        return response()->json([
                'error' => 'The client was not deleted, please try again later.'
            ], 500);
    }
}
