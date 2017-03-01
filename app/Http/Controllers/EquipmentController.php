<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CreateEquipmentRequest;
use App\Equipment;
use Response;
use App\PRS\Transformers\ImageTransformer;
use App\PRS\Transformers\FrontEnd\DataTables\EquipmentDatatableTransformer;

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


    public function index(Request $request, EquipmentDatatableTransformer $equipmentTransformer, $service_seq_id)
    {
        // change this to handle errors as api response
        $this->authorize('list', Equipment::class);

        // if client check that he owns the service

        $service = $this->loggedUserAdministrator()->serviceBySeqId($service_seq_id);

        $equipment = $service->equipment()->get();

        return response()->json($equipmentTransformer->transformCollection($equipment));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEquipmentRequest $request, $service_seq_id)
    {
        // change this to handle errors as api response
        $this->authorize('create', Equipment::class);

        $service = $this->loggedUserAdministrator()->serviceBySeqId($service_seq_id);

        $equipment = $service->equipment()->create(array_map('htmlentities', $request->all()));

        if($equipment){
            return response()->json([
                'message' => 'Equipment was successfully created'
            ]);
        }
        return response()->json([
                'error' => 'Equipment was not created created'
            ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Equipment $equipment)
    {
        // change this to handle errors as api response
        $this->authorize('view', $equipment);

        $photo = [
            'photos' => $this->imageTransformer
                        ->transformCollection($equipment->images()->get())
        ];
        return response()->json(array_merge($equipment->toArray(), $photo));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateEquipmentRequest $request, Equipment $equipment)
    {
        // change this to handle errors as api response
        $this->authorize('update', $equipment);

        $equipment->fill(array_map('htmlentities', $request->except('service_id')));

        $equipment->save();
        return response()->json([
                'message' => 'Equipment was successfully updated'
            ]);

    }


    public function addPhoto(Request $request, Equipment $equipment)
    {
        // change this to handle errors as api response
        $this->authorize('addPhoto', $equipment);

        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png'
        ]);

        $file = $request->file('photo');
        if($equipment->addImageFromForm($file)){
            return response()->json([
                'message' => 'The photo was added to the equipment'
            ]);
        }
        return response()->json([
                'error' => 'The photo could not added to the equipment'
            ], 500);

    }

    public function removePhoto(Equipment $equipment, $order)
    {
        // change this to handle errors as api response
        $this->authorize('removePhoto', $equipment);

        $image = $equipment->image($order, false);
        if($image->delete()){
                return response()->json([
                'message' => 'The photo was deleted from the equipment'
            ]);
        }
        return response()->json([
                'error' => 'The photo could not deleted from the equipment'
            ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipment $equipment)
    {
        // change this to handle errors as api response
        $this->authorize('delete', $equipment);

        if($equipment->delete()){
            return response()->json([
                        'title' => 'Equipment Deleted',
                        'message' => 'The equipment was deleted successfully.'
                    ]);
        }
        return response()->json([
                        'title' => 'Not Deleted',
                        'message' => 'The equipment was not deleted.'
                    ], 500);
    }
}
