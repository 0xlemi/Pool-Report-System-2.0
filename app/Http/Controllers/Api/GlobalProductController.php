<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\PRS\Transformers\GlobalProductTransformer;
use App\PRS\Classes\Logged;
use App\GlobalProduct;
use DB;

class GlobalProductController extends ApiController
{
    protected $productTransformer;

    public function __construct(GlobalProductTransformer $productTransformer)
    {
        $this->productTransformer = $productTransformer;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($this->loggedUser()->cant('list', GlobalProduct::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request, [
            'limit' => 'integer|between:1,25',
        ]);

        $limit = ($request->limit)?: 5;
        $globlaProducts = Logged::company()->globalProducts()->seqIdOrdered()->paginate($limit);

        return $this->respondWithPagination(
            $globlaProducts,
            $this->productTransformer->transformCollection($globlaProducts)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Logged::user()->cannot('create', GlobalProduct::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $company = Logged::company();

        // validation
        $this->validate($request, [
            'name' => 'required|string',
            'brand' => 'required|string',
            'type' => 'required|string',
            'units' => 'required|string',
            'unit_price' => 'required|numeric',
            'unit_currency' => 'required|validCurrency',
            'photos' => 'array',
            'photos.*' => 'required|mimes:jpg,jpeg,png',
        ]);

        // ***** Persisting *****
        $globalProduct = DB::transaction(function () use($request, $company){

            $globalProduct = $company->globalProducts()->create(array_map('htmlentities', $request->except('photos')));

            // Add Photos
            if(isset($request->photos)){
                foreach ($request->photos as $photo) {
                    $globalProduct->addImageFromForm($photo);
                }
            }

            return $globalProduct;
        });

        if($globalProduct){
            return $this->respondPersisted(
                'Global Product created successfully.',
                $this->productTransformer->transform(GlobalProduct::find($globalProduct->id))
            );
        }
        return response()->json(['message' => 'Global Product was not created.'] , 500);
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
            $globalProduct = Logged::company()->globalProducts()->bySeqId($seqId);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Global Product with that id, does not exist.');
        }

        if(Logged::user()->cannot('view', $globalProduct))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if($globalProduct){
            return $this->respond([
                'data' => $this->productTransformer->transform($globalProduct),
            ]);
        }

        return $this->respondInternalError();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $seqId)
    {
        try {
            $globalProduct = Logged::company()->globalProducts()->bySeqId($seqId);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Global Product with that id, does not exist.');
        }

        $user = Logged::user();

        if($user->cannot('update', $globalProduct))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        // validation
        $this->validate($request, [
            'name' => 'required|string',
            'brand' => 'required|string',
            'type' => 'required|string',
            'units' => 'required|string',
            'unit_price' => 'required|numeric',
            'unit_currency' => 'required|validCurrency',
            'add_photos' => 'array',
            'add_photos.*' => 'required|mimes:jpg,jpeg,png',
            'remove_photos' => 'array',
            'remove_photos.*' => 'required|integer|min:1',
        ]);

        // ***** Persisting *****
        DB::transaction(function () use($request, $globalProduct, $user){

            $globalProduct->update(array_map('htmlentities', $request->except('add_photos', 'remove_photos')));

            //Delete Photos
            if(isset($request->remove_photos) && $user->can('removePhoto', $globalProduct)){
                foreach ($request->remove_photos as $order) {
                    $globalProduct->deleteImage($order);
                }
            }

            // Add Photos
            if(isset($request->add_photos) && $user->can('addPhoto', $globalProduct)){
                foreach ($request->add_photos as $photo) {
                    $globalProduct->addImageFromForm($photo);
                }
            }
        });

        return $this->respondPersisted(
            'Equipment updated successfully.',
            $this->productTransformer->transform($globalProduct)
        );
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
            $globalProduct = Logged::company()->globalProducts()->bySeqId($seqId);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Global Product with that id, does not exist.');
        }

        if(Logged::user()->cannot('delete', $globalProduct))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if($globalProduct->delete()){
            return $this->respondWithSuccess('Global Product was successfully deleted.');
        }

        return $this->respondInternalError();
    }
}
