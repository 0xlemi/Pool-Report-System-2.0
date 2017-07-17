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

    protected $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function add()
    {
        if(!$destinationId = $this->company->destination_id){
            return $this->create();
        }
        $org_id = config('services.devicemagic.organization_id');
        $auth = 'Basic '.config('services.devicemagic.token');
        try{
            $response =  Guzzle::get(
                "https://www.devicemagic.com/api/forms/{$this->company->form_id}/destinations/{$destinationId}.json",
                [
                    'headers' => [
                        'Authorization' => $auth,
                    ],
                ]
            );
        } catch (ClientException $e){
            if($e->getResponse()->getStatusCode() == 404){
                return $this->create();
            }
        }

        return response()->json(['message' => 'There is already a destination in this form. You can only have one.'], 404);
    }

    protected function create()
    {
        if(!$this->company->form_id){
            return false;
        }
        $org_id = config('services.devicemagic.organization_id');
        $auth = 'Basic '.config('services.devicemagic.token');
        $response =  Guzzle::post(
            "https://www.devicemagic.com/api/forms/{$this->company->form_id}/destinations.json",
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
            $this->company->destination_id = $destinationId;
            $this->company->save();
        }

        return $response;
    }

}
