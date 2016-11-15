<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PRS\Transformers\InvoiceTransformer;

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
        $this->validate($request, [
            'limit' => 'integer|between:1,25'
        ]);

        $limit = ($request->limit)?: 5;
        $invoices = $this->loggedUserAdministrator()->invoices()->paginate($limit);

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
        $invoice = $this->loggedUserAdministrator()->invoicesBySeqId($seqId);

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
        $invoice = $this->loggedUserAdministrator()->invoicesBySeqId($seqId);

        if($invoice->delete()){
            return response()->json([
                'message' => 'Invoice deleted successfully.',
                ] , 200);
        }
        return response()->json(['error' => 'Invoice was not deleted.'] , 500);
    }
}
