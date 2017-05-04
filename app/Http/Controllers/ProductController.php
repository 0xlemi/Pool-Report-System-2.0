<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends PageController
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
    public function index($serviceSeqId)
    {
        $this->authorize('list', Product::class);

        $service = $this->loggedCompany()->services()->bySeqId($serviceSeqId);

        $products = $service->products()
                        ->get()
                        ->transform(function($item){
                            $globalProduct = $item->globalProduct;
                            return (object) [
                                    'id' => $item->id,
                                    'name' => $globalProduct->name,
                                    'brand' => $globalProduct->brand,
                                    'monthly_amount' => $item->amount.' '.$globalProduct->units,
                                    'monthly_price' => $item->amount*$globalProduct->unit_price.' '.$globalProduct->unit_currency,
                                ];
                        });
        return response()->json([
            'data' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $serviceSeqId)
    {
        $this->authorize('create', Product::class);
        $company = $this->loggedCompany();
        $service = $company->services()->bySeqId($serviceSeqId);

        $product = $service->products()->create([
            'global_product_id' => $request->global_product,
            'amount' => $request->amount
        ]);

        if($product){
            return response()->json([
                'message' => 'Measurement was successfully created.'
            ]);
        }
        return response()->json([
                'error' => 'Measurement was not created, please try again.'
            ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $this->authorize('view', $product);

        $globalProduct = $product->globalProduct;
        return response()->json([
            'data' => (object)[
                'name' => $globalProduct->name,
                'brand' => $globalProduct->brand,
                'type' => $globalProduct->type,
                'amount' => $product->amount,
                'units' => $globalProduct->units,
                'unit_price' => $globalProduct->unit_price.' '.$globalProduct->unit_currency.' per '.str_singular($globalProduct->units),
                'monthly_price' => $product->amount*$globalProduct->unit_price.' '.$globalProduct->unit_currency.'/month',
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $product->update([
            'amount' => $request->amount,
        ]);

        return response()->json([
            'message' => 'Measurement was successfully updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        if($product->delete()){
            return response()->json([
                'message' => 'Product was successfully deleted.'
            ]);
        }
        return response()->json([
                'error' => 'Product was not deleted, please try again.'
            ], 500);
    }
}
