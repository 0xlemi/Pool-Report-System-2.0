<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\PRS\Transformers\ProductTransformer;
use App\PRS\Classes\Logged;
use App\Product;

class ProductController extends ApiController
{

    protected $productTransformer;

    public function __construct(ProductTransformer $productTransformer)
    {
        $this->productTransformer = $productTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $serviceSeqId)
    {
        if(Logged::user()->cannot('list', Product::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request, [
            'limit' => 'integer|between:1,25'
        ]);

        try {
            $service = Logged::company()->services()->bySeqId($serviceSeqId);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Service with that id, does not exist.');
        }

        $limit = ($request->limit)?: 5;
        $products = $service->products()->paginate($limit);

        return $this->respondWithPagination(
            $products,
            $this->productTransformer->transformCollection($products)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $serviceSeqId)
    {
        if(Logged::user()->cannot('create', Product::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $company = Logged::company();
        try {
            $service = $company->services()->bySeqId($serviceSeqId);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Service with that id, does not exist.');
        }

        // validation
        $this->validate($request, [
            'amount' => 'required|numeric',
            'global_product' => 'required|integer|existsBasedOnCompany:global_products,'.$company->id
        ]);

        $globalProductId = $company->globalProducts()->bySeqId($request->global_product)->id;

        if($service->products->contains('global_product_id', $globalProductId)){
            return $this->setStatusCode(400)->respondWithError('This service already has this product');
        }

        $product = $service->products()->create([
            'amount' => $request->amount,
            'global_product_id' => $globalProductId,
        ]);

        if($product){
            return $this->respondPersisted(
                'Product created successfully.',
                $this->productTransformer->transform($product)
            );
        }
        return response()->json(['message' => 'Product was not created.'] , 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if(Logged::user()->cannot('view', $product))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        return $this->respond([
            'data' =>$this->productTransformer->transform($product)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if(Logged::user()->cannot('update', $product))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request, [
            'amount' => 'numeric',
        ]);

        $product->update($request->except('global_product_id'));

        return $this->respondPersisted(
            'Product updated successfully.',
            $this->productTransformer->transform($product)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if(Logged::user()->cannot('delete', $product))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if($product->delete()) {
            return response()->json(['message' => 'Product was deleted.'] , 200);
        }
        return response()->json(['message' => 'Product was not deleted.'] , 500);
    }
}
