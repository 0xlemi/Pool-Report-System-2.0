<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JavaScript;

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
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
