<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CreateEquipmentRequest;
use App\Equipment;
use Response;

class EquipmentController extends PageController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEquipmentRequest $request)
    {
        $equipment = Equipment::create([
            'kind' => $request->kind,
            'type' => $request->type,
            'brand' => $request->brand,
            'model' => $request->model,
            'capacity' => $request->capacity,
            'units' => $request->units,
            'service_id' => $request->serviceId,
        ]);
        if($equipment){
            return Response::json([
                'message' => 'Equipment was successfully created'
            ], 200);
        }
        return Response::json([
                'error' => 'Equipment was not created created'
            ], 500);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $equipment = Equipment::findOrFail($id);

        $photo = array(
            'photos' => $equipment->images()->get()
                        ->transform(function($item){
                            return (object) array(
                                    'normal' => url($item->normal_path),
                                    'thumbnail' => url($item->thumbnail_path),
                                    'order' => $item->order,
                                    'title' => 'Photo title',
                                );
                        })
                        ->toArray()
        );

        return Response::json(array_merge($equipment->toArray(), $photo), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return 'update';    
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
