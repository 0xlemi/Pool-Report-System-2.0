<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Service;

class ServiceContractsController extends ApiController
{

    protected $contractTransformer;

    public function __construct( $contractTransformer)
    {
        $this->contractTransformer = $contractTransformer;
    }

    /**
     * Store or update the contract, depending if it has one or not.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOrUpdate(Request $request, $serviceSeqId)
    {
        $service = $this->loggedUserAdministrator()->serviceBySeqId($serviceSeqId);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Service  $service
     * @return \Illuminate\Http\Response
     */
    protected function update(Request $request, Service $service)
    {
        //
    }

}
