<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PRS\Transformers\ChemicalTransformer;
use App\Chemical;

class ChemicalController extends ApiController
{

    protected $chemicalTransformer;

    public function __construct(ChemicalTransformer $chemicalTransformer)
    {
        $this->chemicalTransformer = $chemicalTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $serviceSeqId)
    {
        if($this->getUser()->cannot('list', Chemical::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request, [
            'limit' => 'integer|between:1,25'
        ]);

        $service = $this->loggedUserAdministrator()->serviceBySeqId($serviceSeqId);

        $limit = ($request->limit)?: 5;
        $chemicals = $service->chemicals()->paginate($limit);

        return $this->respondWithPagination(
            $chemicals,
            $this->chemicalTransformer->transformCollection($chemicals)
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
        if($this->getUser()->cannot('create', Chemical::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $service = $this->loggedUserAdministrator()->serviceBySeqId($serviceSeqId);

        // validation
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'units' => 'required|string|max:255',
        ]);

        $chemical = $service->chemicals()->create($request->all());

        if($chemical){
            return $this->respondPersisted(
                'Chemical created successfully.',
                $this->chemicalTransformer->transform($chemical)
            );
        }
        return response()->json(['message' => 'Chemical was not created.'] , 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Chemical $chemical)
    {
        if($this->getUser()->cannot('view', $chemical))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        return $this->respond([
            'data' =>$this->chemicalTransformer->transform($chemical)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chemical $chemical)
    {
        if($this->getUser()->cannot('update', $chemical))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request, [
            'name' => 'string|max:255',
            'amount' => 'numeric',
            'units' => 'string|max:255',
        ]);

        $chemical->update($request->all());

        return $this->respondPersisted(
            'Chemical updated successfully.',
            $this->chemicalTransformer->transform($chemical)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chemical $chemical)
    {
        if($this->getUser()->cannot('delete', $chemical))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if($chemical->delete()) {
            return response()->json(['message' => 'Chemical was deleted.'] , 200);
        }
        return response()->json(['message' => 'Chemical was not deleted.'] , 500);
    }
}
