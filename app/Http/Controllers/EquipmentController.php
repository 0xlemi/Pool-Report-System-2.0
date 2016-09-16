<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CreateEquipmentRequest;
use App\Equipment;
use Response;
use App\PRS\Transformers\ImageTransformer;

class EquipmentController extends PageController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ImageTransformer $imageTransformer)
    {
        $this->middleware('auth');
        $this->imageTransformer = $imageTransformer;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEquipmentRequest $request)
    {
        $equipment = Equipment::create(array_map('htmlentities', $request->all()));
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
        try {
            $equipment = Equipment::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Equipment with that id, does not exist.');
        }

        $this->imageTransformer->transformCollection($equipment->images()->get());
        $photo = array(
            'photos' => $this->imageTransformer
                        ->transformCollection($equipment->images()->get())
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
    public function update(CreateEquipmentRequest $request, $id)
    {
        try {
            $equipment = Equipment::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Equipment with that id, does not exist.');
        }

        $equipment->fill(array_map('htmlentities', $request->except('service_id')));

        $equipment->save();
        return Response::json([
                'message' => 'Equipment was successfully updated'
            ], 200);

    }


    public function addPhoto(Request $request, $id)
    {
        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png'
        ]);

        try {
            $equipment = Equipment::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Equipment with that id, does not exist.');
        }

        $file = $request->file('photo');
        if($equipment->addImageFromForm($file)){
            return Response::json([
                'message' => 'The photo was added to the equipment'
            ], 200);
        }
        return Response::json([
                'error' => 'The photo could not added to the equipment'
            ], 500);

    }

    public function removePhoto($id, $order)
    {
        try {
            $equipment = Equipment::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return $this->respondNotFound('Equipment with that id, does not exist.');
        }

        $image = $equipment->image($order, false);

        if($image->delete()){
                return Response::json([
                'message' => 'The photo was deleted from the equipment'
            ], 200);
        }
        return Response::json([
                'error' => 'The photo could not deleted from the equipment'
            ], 500);
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
