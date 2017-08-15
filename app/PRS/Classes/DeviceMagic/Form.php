<?php
namespace App\PRS\Classes\DeviceMagic;

use Guzzle;
use Uuid;
use Excel;
use Storage;
use App\PRS\Classes\Logged;
use App\PRS\Classes\DeviceMagic\Destination;
use App\Company;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;

abstract class Form {

    protected $company;
    protected $destination;

    public function __construct(Destination $destination)
    {
        $this->company = $destination->getCompany();
        $this->destination = $destination;
    }

    abstract public function createOrUpdate();

    abstract protected function create();

    abstract protected function update(int $formId);

    protected function updateGroup($formId)
    {
        $org_id = config('services.devicemagic.organization_id');
        $auth = 'Basic '.config('services.devicemagic.token');
        $companyName = str_replace(" ", "_", $this->company->name);
        $response =  Guzzle::post(
            "https://www.devicemagic.com/organizations/{$org_id}/forms/{$formId}/properties",
            [
                'headers' => [
                    'Authorization' => $auth,
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    "group" => "PRS-{$companyName}-{$this->company->id}"
                ]
            ]
        );

        return ($response->getStatusCode() === 200);
    }

    abstract protected function formJson();


}
