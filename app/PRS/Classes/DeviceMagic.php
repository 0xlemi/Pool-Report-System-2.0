<?php

namespace App\PRS\Classes;

use Guzzle;
use Uuid;
use Excel;
use Storage;
use App\PRS\Classes\Logged;
use App\Company;
use GuzzleHttp\Psr7\Response;

class DeviceMagic{

    public function createResource(Company $company)
    {
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
                            'file_name' => 'file.xlsx',
                            'file_data' => $base64,
                            'content_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        ]
                    ]
                ]
            ]
        );
        return $response;
    }

    public function addOrUpdateResource(Company $company)
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
    }

    // public function createGroup()
    // {
    //     $response = Guzzle::post(
    //         'https://api.sendbird.com/v3/users',
    //         [
    //             'headers' => [
    //                 'Api-Token' => env('SENDBIRD_TOKEN')
    //             ],
    //             'json' => [
    //                 "user_id" =>  $urc->chat_id,
    //                 "nickname" =>  $urc->chat_nickname,
    //                 "profile_url" =>  Storage::url($urc->icon()),
    //                 "issue_access_token" => true
    //             ]
    //         ]
    //     );
    //     if($response->getStatusCode() == 200){
    //         $object = json_decode($response->getBody()->getContents());
    //         $urc->chat_token = $object->access_token;
    //         $urc->save();
    //         return $object;
    //     }
    //
    // }

    // public function createForm()
    // {
    //        $response = Guzzle::post(
    //         'https://api.sendbird.com/v3/users',
    //         [
    //             'headers' => [
    //                 'Api-Token' => env('SENDBIRD_TOKEN')
    //             ],
    //             'json' => [
    //                 "user_id" =>  $urc->chat_id,
    //                 "nickname" =>  $urc->chat_nickname,
    //                 "profile_url" =>  Storage::url($urc->icon()),
    //                 "issue_access_token" => true
    //             ]
    //         ]
    //     );
    //     if($response->getStatusCode() == 200){
    //         $object = json_decode($response->getBody()->getContents());
    //         $urc->chat_token = $object->access_token;
    //         $urc->save();
    //         return $object;
    //     }
    //
    // }



    public function servicesResource()
    {
        $company = Logged::company();

        return $company->services->transform(function ($item){
            return [
                'id' => $item->seq_id,
                'name' => $item->seq_id." ".$item->name
            ];
        });
    }

}
