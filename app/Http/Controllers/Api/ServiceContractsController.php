<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Service;
use App\PRS\Transformers\ContractTransformer;
use App\PRS\Helpers\ContractHelpers;
use App\ServiceContract;

class ServiceContractsController extends ApiController
{

    protected $contractTransformer;
    protected $contractHelpers;

    public function __construct(ContractTransformer $contractTransformer,
                                ContractHelpers $contractHelpers)
    {
        $this->contractTransformer = $contractTransformer;
        $this->contractHelpers = $contractHelpers;
    }

    /**
     * Store or update the contract, depending if it has one or not.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $serviceSeqId
     * @return \Illuminate\Http\Response
     */
    public function storeOrUpdate(Request $request, $serviceSeqId)
    {
        $service = $this->loggedUserAdministrator()->serviceBySeqId($serviceSeqId);
        $contract = $service->serviceContract;

        if($service->hasServiceContract()){
            return $this->update($request, $contract);
        }
        return $this->store($request, $service);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($serviceSeqId)
    {
        $service = $this->loggedUserAdministrator()->serviceBySeqId($serviceSeqId);

        if(!$service->hasServiceContract()){
            return response()->json([
                'message' => 'This service has no contract.'
            ], 422);
        }

        return $this->respond([
            'data' =>$this->contractTransformer->transform($service->serviceContract),
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
        $service = $this->loggedUserAdministrator()->serviceBySeqId($serviceSeqId);

        if(!$service->hasServiceContract()){
            return response()->json([
                'message' => 'This service has no contract.'
            ], 422);
        }

        if($service->serviceContract->delete()){
            return response()->json([
                'message' => 'Contract was successfully destroyed'
            ]);
        }
        return response()->json([
            'error' => 'Contract could not be destroyed, please try again.'
        ], 500);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Service  $service
     * @return \Illuminate\Http\Response
     */
    protected function store(Request $request, Service $service)
    {
        $this->validate($request, [
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'amount' => 'required|numeric|max:10000000',
            'currency' => 'required|string|validCurrency',
            'comments' => 'string',
            'service_days' => 'required|array|size:7',
            'service_days.monday' => 'required|boolean',
            'service_days.tuesday' => 'required|boolean',
            'service_days.wednesday' => 'required|boolean',
            'service_days.thursday' => 'required|boolean',
            'service_days.friday' => 'required|boolean',
            'service_days.saturday' => 'required|boolean',
            'service_days.sunday' => 'required|boolean',
        ]);

        $contract = $service->serviceContract()->create(array_merge(
                    array_map('htmlentities', $request->except('service_days')),
                    [
                        'active' => true,
                        'service_days' => $this->contractHelpers
                                            ->serviceDaysToNum($request->service_days),
                    ]
                ));

        if($contract){
            return $this->respondPersisted(
                'Service Contract created successfully.',
                $this->contractTransformer->transform($contract)
            );
        }
        return response()->json(['message' => 'Service Contract was not created.'] , 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Service  $service
     * @return \Illuminate\Http\Response
     */
    protected function update(Request $request, ServiceContract $contract)
    {
        $this->validate($request, [
            'active' => 'boolean',
            'start_time' => 'date_format:H:i',
            'end_time' => "date_format:H:i|timeAfterDB:service_contracts,start_time,{$contract->service_id},start_time",
            'status' => 'boolean',
            'amount' => 'numeric|max:10000000',
            'currency' => 'string|validCurrency',
            'comments' => 'string',
            'service_days' => 'array|size:7',
            'service_days.monday' => 'required_with:service_days|boolean',
            'service_days.tuesday' => 'required_with:service_days|boolean',
            'service_days.wednesday' => 'required_with:service_days|boolean',
            'service_days.thursday' => 'required_with:service_days|boolean',
            'service_days.friday' => 'required_with:service_days|boolean',
            'service_days.saturday' => 'required_with:service_days|boolean',
            'service_days.sunday' => 'required_with:service_days|boolean',
        ]);

        $values = array_map('htmlentities', $request->except('service_days'));

        // get the service days number 0-127 from request
        if($request->has('service_days')){
            $values = array_merge(
                    $values,
                    [
                        'service_days' => $this->contractHelpers
                                            ->serviceDaysToNum($request->service_days),
                    ]
                );
        }
        $contract->update($values);

        return $this->respondPersisted(
            'Service Contract was updated successfully.',
            $this->contractTransformer->transform($contract)
        );

    }

}
