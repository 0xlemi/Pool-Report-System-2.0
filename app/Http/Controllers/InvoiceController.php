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
        $this->authorize('view', Invoice::class);

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
        $this->authorize('view', Invoice::class);

        $invoice = $this->loggedUserAdministrator()->invoicesBySeqId($seqId);
        $service = $invoice->invoiceable->service;

        return view('invoices.show', compact('invoice', 'service'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($seqId)
    {
        $this->authorize('delete', Invoice::class);

        $invoice = $this->loggedUserAdministrator()->invoicesBySeqId($seqId);

        if($invoice->delete()){
            flash()->success('Deleted', 'The invoice was successfuly deleted');
            return redirect('invoices');
        }
        flash()->error('Not Deleted', 'We could not delete this invoice, please try again later.');
        return redirect()->back();
    }
}
