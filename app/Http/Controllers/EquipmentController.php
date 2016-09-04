<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
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
    public function store(Request $request)
    {
        //
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
        //
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
