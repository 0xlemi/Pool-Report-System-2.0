<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CreateChemicalRequest;
use App\Http\Requests\UpdateChemicalRequest;
use App\Chemical;
use App\Notifications\AddedChemicalNotification;

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
        $this->authorize('list', Chemical::class);

        $service = $this->loggedCompany()->services()->bySeqId($serviceSeqId);

        $chemicals = $service->chemicals()
                        ->get()
                        ->transform(function($item){
                            $globalChemical = $item->globalChemical;
                            return (object) [
                                    'id' => $item->id,
                                    'name' => $globalChemical->name,
                                    'amount' => $item->amount,
                                    'units' => $globalChemical->units,
                                ];
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
    public function store(CreateChemicalRequest $request, $serviceSeqId)
    {
        $this->authorize('create', Chemical::class);

        $company = $this->loggedCompany();
        $service = $company->services()->bySeqId($serviceSeqId);

        $chemical = $service->chemicals()->create([
                'amount' => $request->amount,
                'global_chemical_id' => $request->global_chemical,
            ]);

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
    public function update(UpdateChemicalRequest $request, Chemical $chemical)
    {
        $this->authorize('update', $chemical);

        $chemical->update([
            'amount' => $request->amount,
        ]);

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
        $this->authorize('delete', $chemical);

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
