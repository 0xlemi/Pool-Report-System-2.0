<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CreateContractRequest;
use App\Http\Requests\UpdateContractRequest;
use App\PRS\Helpers\ServiceHelpers;
use App\PRS\Helpers\ContractHelpers;
use App\ServiceContract;

class ServiceContractsController extends PageController
{

    protected $contractHelpers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ContractHelpers $contractHelpers)
    {
        $this->contractHelpers = $contractHelpers;
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateContractRequest $request, $serviceSeqId)
    {
        $this->authorize('create', ServiceContract::class);

        $company = $this->loggedCompany();
        $service = $company->services()->bySeqId($serviceSeqId);

        // get the service days number 0-127
        $serviceDays = $this->contractHelpers->serviceDaysToNum($request->service_days);

        // ServiceContract::flushEventListeners();
        $serviceContract = $service->serviceContract()->create(array_merge(
                        array_map('htmlentities', $request->except('service_days', 'active')),
                        [
                            'service_days' => $serviceDays,
                        ]
                    ));

        if($serviceContract){
            return response()->json([
                'message' => 'Service Contract Successfuly created',
            ]);
        }
        return response()->json([
            'error' => 'Service Contract was not created, please try again.',
        ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($serviceSeqId)
    {
        $company = $this->loggedCompany();
        $service = $company->services()->bySeqId($serviceSeqId);

        $data = [
            'contractExists' => false
        ];
        if($service->hasServiceContract()){
            $serviceContract = $service->serviceContract;

            $this->authorize('view', $serviceContract );

            $data = [
                'object' => $serviceContract,
                'start' => $serviceContract->start()->datePickerValue(),
                'startShow' => (string) $serviceContract->start(),
                'endTime' => $serviceContract->endTime()->timePickerValue(),
                'startTime' => $serviceContract->startTime()->timePickerValue(),
                'contractExists' => true,
                'serviceDaysArray' => $serviceContract->serviceDays()->asArray(),
                'serviceDaysString' => $serviceContract->serviceDays()->shortNames(),
                'active' => $serviceContract->activeStatus()->asBoolean(),
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
    public function update(UpdateContractRequest $request, $serviceSeqId)
    {
        $company = $this->loggedCompany();
        $serviceContract = $company->services()->bySeqId($serviceSeqId)->serviceContract;

        $this->authorize('update', $serviceContract);

        // get the service days number 0-127
        $serviceDays = $this->contractHelpers->serviceDaysToNum($request->service_days);

        $serviceContract->fill(array_merge(
                    array_map('htmlentities', $request->except('service_days')),
                    [
                        'service_days' => $serviceDays,
                    ]
                ));
        $serviceContract->save();

        return response()->json([
            'message' => 'Service Contract Successfuly updated',
        ]);
    }

    public function toggleActivation($serviceSeqId)
    {
        $company = $this->loggedCompany();
        $serviceContract = $company->services()->bySeqId($serviceSeqId)->serviceContract;

        $this->authorize('toggleActivation', $serviceContract);

        $active = !$serviceContract->active;
        $serviceContract->active = $active;
        $serviceContract->save();

        return response()->json([
            'message' => "Service Contract has been set to {$serviceContract->activeStatus()}",
            'active' => $serviceContract->activeStatus()->asBoolean(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($serviceSeqId)
    {
        $company = $this->loggedCompany();
        $serviceContract = $company->services()->bySeqId($serviceSeqId)->serviceContract;

        $this->authorize('delete', $serviceContract);

        if($serviceContract->delete()){
            return response()->json([
                'message' => 'Service Contract Successfuly destroyed',
            ]);
        }
        return response()->json([
                'error' => 'Service Contract could not be destroyed, try again.',
        ], 500);
    }
}
