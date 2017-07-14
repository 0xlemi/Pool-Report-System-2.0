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

class Destination {

    public function view(Company $company)
    {
        $org_id = config('services.devicemagic.organization_id');
        $auth = 'Basic '.config('services.devicemagic.token');
        $response =  Guzzle::get(
            "https://www.devicemagic.com/api/forms/{$company->form_id}/destinations/2151965.json",
            [
                'headers' => [
                    'Authorization' => $auth,
                ],
            ]
        );

        return json_decode($response->getBody()->getContents());

    }

    public function create(Company $company)
    {
        if((!$company->form_id) || $company->destination_id){
            return false;
        }
        $org_id = config('services.devicemagic.organization_id');
        $auth = 'Basic '.config('services.devicemagic.token');
        $response =  Guzzle::post(
            "https://www.devicemagic.com/api/forms/{$company->form_id}/destinations.json",
            [
                'headers' => [
                    'Authorization' => $auth,
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    "destination"=> [
                        "description"=> "To Pool Report System server",
                        "format_selection"=> "json_format",
                        "transport_selection"=> "http_transport",
                        "binary_transport_selection"=> "binary_s3_transport"
                    ],
                    "http_transport"=> [
                        "uri"=> env('DEVICE_MAGIC_DESTINATION_URL')
                    ],
                    "binary_s3_transport"=> [
                        'access_key_id' => env('DEVICE_MAGIC_DESTINATION_S3_KEY_ID'),
                        'secret_access_key' => env('DEVICE_MAGIC_DESTINATION_S3_KEY_SECRET'),
                        'bucket_name' => env('DEVICE_MAGIC_DESTINATION_S3_BUCKET_NAME'),
                        'region' => env('DEVICE_MAGIC_DESTINATION_S3_REGION'),
                        'folder_path_template' => env('DEVICE_MAGIC_DESTINATION_S3_FOLDER')
                    ]
                ]
            ]
        );

        if($response->getStatusCode() == 201){
            $destinationId = json_decode($response->getBody()->getContents())->destination->id;
            $company->destination_id = $destinationId;
            $company->save();
        }

        return $response;

    }

}
