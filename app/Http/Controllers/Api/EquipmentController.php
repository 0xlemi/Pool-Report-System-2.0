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
    public function index($serviceSeqId)
    {
        $service = $this->loggedUserAdministrator()->serviceBySeqId($serviceSeqId);
        // remeber to add pagination
        return $this->equipmentTransformer->transformCollection($service->equipment()->get());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $serviceSeqId)
    {
        $service = $this->loggedUserAdministrator()->serviceBySeqId($serviceSeqId);

        // add validation

        // ***** Persisting *****
        $equipment = DB::transaction(function () use($request, $service){

            $equipment = Equipment::create(array_merge(
                                $request->all(),
                                [
                                    'service_id' => $service->id,
                                ]
                            ));

            if ($request->photo) {
                $equipment->addImageFromForm($request->file('photo'));
            }

            return $equipment;
        });

        if($equipment){
            return response()->json([
                'message' => 'Equipment created successfully.',
                'object' => $equipment->toArray(),
                ] , 200);
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
        return $this->equipmentTransformer->transform($equipment);
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

        // ***** Persisting *****
        DB::transaction(function () use($request, $equipment){

            $equipment->update($request->except('service_id'));

            // add multiple photo functionality
            if ($request->photo) {
                $equipment->deleteImage(1);
                $equipment->addImageFromForm($request->file('photo'), 1);
            }
        });

        return response()->json([
            'message' => 'Equipment updated successfully.',
            'object' => $equipment->toArray(),
            ] , 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipment $equipment)
    {
        if($equipment->delete()) {
            return response()->json(['message' => 'Equipment was deleted.'] , 200);
        }
        return response()->json(['message' => 'Equipment was not deleted.'] , 500);
    }
}
