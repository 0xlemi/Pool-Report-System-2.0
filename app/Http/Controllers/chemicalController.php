<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Chemical;

class chemicalController extends PageController
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
        $service = $this->loggedUserAdministrator()->serviceBySeqId($serviceSeqId);

        $chemicals = $service->chemicals()
                        ->get()
                        ->transform(function($item){
                            return (object) array(
                                'id' => $item->id,
                                'name' => $item->name,
                                'amount' => $item->amount,
                                'units' => $item->units,
                            );
                        });
        return response()->json([
            'data' => $chemicals
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
        // validate

        $service = $this->loggedUserAdministrator()->serviceBySeqId($serviceSeqId);

        $chemical = $service->chemicals()->create($request->all());

        if($chemical){
            return response()->json([
                'message' => 'Chemical was successfully created.'
            ]);
        }
        return response()->json([
                'error' => 'Chemical was not created, please try again.'
            ], 500);
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
        // validate

        $chemical->update($request->all());

        return response()->json([
            'message' => 'Chemical was successfully updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chemical $chemical)
    {
        if($chemical->delete()){
            return response()->json([
                'message' => 'Chemical was successfully deleted.'
            ]);
        }
        return response()->json([
                'error' => 'Chemical was not deleted, please try again.'
            ], 500);
    }
}
