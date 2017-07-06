<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PRS\Classes\Logged;
use App\PRS\Classes\DeviceMagic;
use Excel;
use Uuid;

use Guzzle;
use Storage;
use GuzzleHttp\Psr7\Response;

class DeviceMagicController extends Controller
{
    public function forms(Request $request)
    {
        info($request);

    }

    public function getResource(DeviceMagic $deviceMagic, Excel $excel)
    {
        $services = $deviceMagic->servicesResource();
        Excel::create('export', function($excel) use ($services){

            // Call writer methods here
            $excel->sheet('services', function($sheet) use ($services){

                $sheet->fromModel($services);

            });

        })->export('xlsx');
    }

    public function updateResource(DeviceMagic $deviceMagic, Excel $excel)
    {
        $company = Logged::company();

        $services = $deviceMagic->servicesResource();
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

        $auth = 'Basic '. base64_encode(config('services.devicemagic.token').':x');
        $response = Guzzle::put(
            'https://www.devicemagic.com/api/resources/23099.json',
            [
                'headers' => [
                    'Authorization' => $auth,
                ],
                'form_params' => [
                    'resource' => [
                        // 'description' => 'PRSHidroequiposServiceListEdited',
                        'file' => [
                            'file_name' => 'newfile.xlsx',
                            'file_data' => $base64,
                            'content_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        ]
                    ]
                ]
            ]
        );
        return $response;
        if($response->getStatusCode() == 200){
            // return response();
        }

    }

}
