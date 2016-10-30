<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ServiceContractsController extends PageController
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
    public function index()
    {
        //
    }


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
    public function show($serviceSeqId)
    {
        $admin = $this->loggedUserAdministrator();
        $service = $admin->serviceBySeqId($serviceSeqId);

        $data = [
            'contractExists' => false
        ];
        if($service->hasServiceContract()){
            $serviceContract = $service->serviceContract;
            $data = [
                'object' => $serviceContract,
                'contractExists' => true,
                'serviceDaysArray' => $serviceContract->serviceDays()->asArray(),
                'serviceDaysString' => $serviceContract->serviceDays()->shortNames(),
                'contractActiveBoolean' => $serviceContract->contractActive()->asBoolean(),
                'contractActiveString' => (string) $serviceContract->contractActive(),
            ];
        }
        return response()->json($data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $serviceSeqId)
    {
        // $admin = $this->loggedUserAdministrator();
        // $serviceContract = $admin->serviceBySeqId($serviceSeqId)->serviceContract;

        // $serviceContract->fill($request->all());
        return $request->all();

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
