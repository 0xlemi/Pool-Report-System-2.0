<?php

namespace App\Http\Controllers;

use App\Product;
use App\GlobalProduct;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\PRS\Transformers\FrontEnd\DataTables\GlobalProductDatatableTransformer;
use App\PRS\Transformers\FrontEnd\GlobalProductFrontTransformer;
use App\Http\Requests\UpdateGlobalProductRequest;
use App\Http\Requests\CreateGlobalProductRequest;

class GlobalProductController extends PageController
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
    public function index(GlobalProductDatatableTransformer $transformer)
    {
        $this->authorize('list', GlobalProduct::class);

        $globalProducts = $this->loggedCompany()->globalProducts;

        return response()->json([
            'data' => $transformer->transformCollection($globalProducts)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGlobalProductRequest $request)
    {
        $this->authorize('create', GlobalProduct::class);

        $company = $this->loggedCompany();

        $globalProduct = $company->globalProducts()->create(array_map('htmlentities', $request->all()));

        if($globalProduct){
            return response()->json([
                'message' => 'Global Product was successfully created'
            ]);
        }
        return response()->json([
                'error' => 'Global Product was not created'
            ], 500);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GlobalProduct  $globalProduct
     * @return \Illuminate\Http\Response
     */
    public function show($seqId, GlobalProductFrontTransformer $transformer)
    {
        try {
            $globalProduct = $this->loggedCompany()->globalProducts()->bySeqId($seqId);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Global Product with that id does not exist',
            ], 404);
        }

        $this->authorize('view', $globalProduct);

        return response()->json([
            'data' => $transformer->transform($globalProduct),
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GlobalProduct  $globalProduct
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGlobalProductRequest $request, $seqId)
    {
        try {
            $globalProduct = $this->loggedCompany()->globalProducts()->bySeqId($seqId);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Global Product with that id does not exist',
            ], 404);
        }

        $this->authorize('update', $globalProduct);

        $globalProduct->update(array_map('htmlentities', $request->all()));

        return response()->json([
                'message' => 'Global Product was successfully updated'
            ]);
    }

    public function addPhoto(Request $request, $seqId)
    {

        try {
            $globalProduct = $this->loggedCompany()->globalProducts()->bySeqId($seqId);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Global Product with that id does not exist',
            ], 404);
        }

        // change this to handle errors as api response
        $this->authorize('addPhoto', $globalProduct);

        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png'
        ]);

        $file = $request->file('photo');
        if($globalProduct->addImageFromForm($file)){
            return response()->json([
                'message' => 'The photo was added to the Global Product'
            ]);
        }
        return response()->json([
                'error' => 'The photo could not added to the Global Product'
            ], 500);

    }

    public function removePhoto($seqId, $order)
    {
        try {
            $globalProduct = $this->loggedCompany()->globalProducts()->bySeqId($seqId);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Global Product with that id does not exist',
            ], 404);
        }

        // change this to handle errors as api response
        $this->authorize('removePhoto', $globalProduct);

        $image = $globalProduct->image($order, false);
        if($image->delete()){
                return response()->json([
                'message' => 'The photo was deleted from the Global Product'
            ]);
        }
        return response()->json([
                'error' => 'The photo could not deleted from the Global Product'
            ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GlobalProduct  $globalProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy($seqId)
    {
        try {
            $globalProduct = $this->loggedCompany()->globalProducts()->bySeqId($seqId);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Global Product with that id does not exist',
            ], 404);
        }

        $this->authorize('delete', $globalProduct);

        if($globalProduct->delete()){
            return response()->json([
                        'title' => 'Global Product Deleted',
                        'message' => 'The Global Product was deleted successfully.'
                    ]);
        }
        return response()->json([
                        'title' => 'Not Deleted',
                        'message' => 'The Global Product was not deleted.'
                    ], 500);
    }
}
