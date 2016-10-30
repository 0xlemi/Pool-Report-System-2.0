<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\PRS\Helpers\ServiceHelpers;

class ServiceContractsController extends PageController
{

    protected $serviceHelpers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ServiceHelpers $serviceHelpers)
    {
        $this->serviceHelpers = $serviceHelpers;
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
                'endTime' => $serviceContract->endTime()->timePickerValue(),
                'startTime' => $serviceContract->startTime()->timePickerValue(),
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
        $admin = $this->loggedUserAdministrator();
        $serviceContract = $admin->serviceBySeqId($serviceSeqId)->serviceContract;

        // get the service days number 0-127
        $serviceDays = $this->serviceHelpers->serviceDaysToNum($request->serviceDays);

        $serviceContract->fill(array_merge(
                    array_map('htmlentities', $request->except('serviceDays')),
                    [
                        'service_days' => $serviceDays,
                    ]
                ));
        $serviceContract->save();

        return response()->json([
            'message' => 'Service Contract Successfuly updated',
        ]);
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
