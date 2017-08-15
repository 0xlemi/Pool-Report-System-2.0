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

    public function add($formId, $destinationId, $path)
    {
        if($destinationId == null){
            return $this->create($formId, $path);
        }
        $org_id = config('services.devicemagic.organization_id');
        $auth = 'Basic '.config('services.devicemagic.token');

        // To get the response out of the try-catch
        $response;
        // Try to delete destination if it exists
        try{
            $response =  Guzzle::delete(
                "https://www.devicemagic.com/api/forms/{$formId}/destinations/{$destinationId}.json",
                [
                    'headers' => [
                        'Authorization' => $auth,
                    ],
                ]
            );
        }catch (ClientException $e){
            // destination don't exist for some reason
        }

        // create a new one
        if($response->getStatusCode() == 200){
            return $this->create($formId, $path);
        }

        return false;
    }

    protected function create($formId, $path)
    {
        if($formId == null){
            return false;
        }
        $org_id = config('services.devicemagic.organization_id');
        $auth = 'Basic '.config('services.devicemagic.token');
        $response =  Guzzle::post(
            "https://www.devicemagic.com/api/forms/{$formId}/destinations.json",
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
                        "uri"=> env('DEVICE_MAGIC_DESTINATION_URL').$path
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
            return json_decode($response->getBody()->getContents())->destination;
        }
        return false;
    }

    public function getCompany()
    {
        return $this->company;
    }

}
