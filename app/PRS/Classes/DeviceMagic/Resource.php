<?php
namespace App\PRS\Classes\DeviceMagic;

use Guzzle;
use Uuid;
use Excel;
use Storage;
use App\PRS\Classes\Logged;
use App\Company;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;

class Resource{


    public function updateServicesList(Company $company)
    {
        $base64 = $this->servicesInExcel($company);

        if($company->resource_id){
            return $this->updateRequest($company, $base64);
        }
        return $this->createRequest($company, $base64);

    }

    protected function createRequest(Company $company, string $base64)
    {
        $auth = 'Basic '.config('services.devicemagic.token');
        $response = Guzzle::post(
            'https://www.devicemagic.com/api/resources.json',
            [
                'headers' => [
                    'Authorization' => $auth,
                ],
                'form_params' => [
                    'resource' => [
                        'description' => "PRS_{$company->name}_ServiceList",
                        'file' => [
                            'file_name' => 'services.xlsx',
                            'file_data' => $base64,
                            'content_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        ]
                    ]
                ]
            ]
        );

        if($response->getStatusCode() == 201){
            $resource_id = json_decode($response->getBody()->getContents())->resource->id;
            $company->resource_id = $resource_id;
            $company->save();
        }
        return $response;
    }

    protected function updateRequest(Company $company, string $base64)
    {
        $auth = 'Basic '.config('services.devicemagic.token');
        try{
            $response = Guzzle::put(
                "https://www.devicemagic.com/api/resources/{$company->resource_id}.json",
                [
                    'headers' => [
                        'Authorization' => $auth,
                    ],
                    'form_params' => [
                        'resource' => [
                            'file' => [
                                'file_name' => 'services.xlsx',
                                'file_data' => $base64,
                                'content_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                            ]
                        ]
                    ]
                ]
            );
        } catch (ClientException $e) {
            if($e->getResponse()->getStatusCode() == 404){
                $company->resource_id = null;
                $company->save();
                return response()->json(['message' => 'Cannot update resource that don\'t exists. Please try again'], 404);
            }
        }

        if($response->getStatusCode() == 200){
            // success
        }

        return $response;
    }

    /**
     * Get all services list with seq_id in excel base64 format
     * @param  Company $company  The company the list of services belong to
     * @return  string          base64 encoded excel file
     */
    protected function servicesInExcel(Company $company)
    {
        $services = $company->services->transform(function ($item){
            return [
                'id' => $item->seq_id,
                'name' => $item->seq_id." ".$item->name
            ];
        });
        $uuid = Uuid::generate();
        Excel::create($uuid, function($excel) use ($services){

            // Call writer methods here
            $excel->sheet('services', function($sheet) use ($services){

                $sheet->fromModel($services);

            });

        })->store('xlsx', storage_path('temp/exports/excel'));

        $filePath = storage_path("temp/exports/excel/{$uuid}.xlsx");
        $documentData = file_get_contents($filePath);
        $base64 = base64_encode($documentData);

        unlink($filePath);

        return $base64;

    }

}
