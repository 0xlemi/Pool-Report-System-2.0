<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PRS\Transformers\InvoiceTransformer;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Invoice;

class InvoiceController extends ApiController
{

    protected $invoiceTransformer;

    public function __construct(InvoiceTransformer $invoiceTransformer)
    {
        $this->invoiceTransformer = $invoiceTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($this->getUser()->cannot('list', Invoice::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request, [
            'limit' => 'integer|between:1,25',
            'closed' => 'boolean',
        ]);

        $limit = ($request->limit)?: 5;
        $admin = $this->loggedUserAdministrator();

        if($request->has('closed')){
            if($request->closed){
                $invoices = $admin->invoices()->whereNotNull('closed')->paginate($limit);
            }else{
                $invoices = $admin->invoices()->whereNull('closed')->paginate($limit);
            }
        }else{
            $invoices = $admin->invoices()->paginate($limit);
        }

        return $this->respondWithPagination(
            $invoices,
            $this->invoiceTransformer->transformCollection($invoices)
        );

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
            $invoice = $this->loggedUserAdministrator()->invoicesBySeqId($seqId);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Invoice with that id, does not exist.');
        }

        if($this->getUser()->cannot('view', $invoice))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        return $this->respond([
            'data' => $this->invoiceTransformer->transform($invoice)
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
            $invoice = $this->loggedUserAdministrator()->invoicesBySeqId($seqId);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Invoice with that id, does not exist.');
        }

        if($this->getUser()->cannot('delete', $invoice))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if($invoice->delete()){
            return response()->json([
                'message' => 'Invoice deleted successfully.',
                ] , 200);
        }
        return response()->json(['error' => 'Invoice was not deleted.'] , 500);
    }
}
