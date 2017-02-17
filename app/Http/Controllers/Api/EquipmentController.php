<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PRS\Transformers\EquipmentTransformer;
use App\Equipment;
use DB;

class EquipmentController extends ApiController
{

    protected $equipmentTransformer;

    public function __construct(EquipmentTransformer $equipmentTransformer)
    {
        $this->equipmentTransformer = $equipmentTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $serviceSeqId)
    {
        if($this->getUser()->cannot('list', Equipment::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $this->validate($request, [
            'limit' => 'integer|between:1,25'
        ]);

        $service = $this->loggedUserAdministrator()->serviceBySeqId($serviceSeqId);

        $limit = ($request->limit)?: 5;
        $equipment = $service->equipment()->paginate($limit);

        return $this->respondWithPagination(
            $equipment,
            $this->equipmentTransformer->transformCollection($equipment)
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
        if($this->getUser()->cannot('create', Equipment::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        $service = $this->loggedUserAdministrator()->serviceBySeqId($serviceSeqId);

        // validation
        $this->validate($request, [
            'kind' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'capacity' => 'required|numeric',
            'units' => 'required|string|max:255',
            'photos.*' => 'mimes:jpg,jpeg,png',
        ]);

        // ***** Persisting *****
        $equipment = DB::transaction(function () use($request, $service){

            $equipment = Equipment::create(array_merge(
                                $request->all(),
                                [
                                    'service_id' => $service->id,
                                ]
                            ));

            // Add Photos
            if(isset($request->photos)){
                foreach ($request->photos as $photo) {
                    $equipment->addImageFromForm($photo);
                }
            }

            return $equipment;
        });

        if($equipment){
            return $this->respondPersisted(
                'Equipment created successfully.',
                $this->equipmentTransformer->transform($equipment)
            );
        }
        return response()->json(['message' => 'Equipment was not created.'] , 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Equipment $equipment)
    {
        if($this->getUser()->cannot('view', $equipment))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        return $this->respond([
            'data' =>$this->equipmentTransformer->transform($equipment)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Equipment $equipment)
    {
        if($this->getUser()->cannot('update', $equipment))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        // validation
        $this->validate($request, [
            'kind' => 'string|max:255',
            'type' => 'string|max:255',
            'brand' => 'string|max:255',
            'model' => 'string|max:255',
            'capacity' => 'numeric',
            'units' => 'string|max:255',
            'photos.*' => 'mimes:jpg,jpeg,png',
            'photosDelete.*' => 'integer|min:1',
        ]);

        // ***** Persisting *****
        DB::transaction(function () use($request, $equipment){

            $equipment->update($request->except('service_id'));

            //Delete Photos
            if(isset($request->photosDelete) && $this->getUser()->can('removePhoto', $equipment)){
                foreach ($request->photosDelete as $order) {
                    $equipment->deleteImage($order);
                }
            }

            // Add Photos
            if(isset($request->photos) && $this->getUser()->can('addPhoto', $equipment)){
                foreach ($request->photos as $photo) {
                    $equipment->addImageFromForm($photo);
                }
            }
        });

        return $this->respondPersisted(
            'Equipment updated successfully.',
            $this->equipmentTransformer->transform($equipment)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipment $equipment)
    {
        if($this->getUser()->cannot('delete', $equipment))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this. The administrator can grant you permission');
        }

        if($equipment->delete()) {
            return response()->json(['message' => 'Equipment was deleted.'] , 200);
        }
        return response()->json(['message' => 'Equipment was not deleted.'] , 500);
    }
}
