<?php
namespace App\PRS\Classes\DeviceMagic;

use Guzzle;
use App\PRS\Classes\Logged;
use App\Company;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;

class Device {

    protected $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function view()
    {
        $org_id = config('services.devicemagic.organization_id');
        $auth = 'Basic '.config('services.devicemagic.token');

        $response = Guzzle::get(
            "https://www.devicemagic.com/organizations/{$org_id}/devices.xml",
            [
                'headers' => [
                    'Authorization' => $auth,
                ],
            ]
        );

        $devices = simplexml_load_string($response->getBody()->getContents())->children();

        dd($devices);

    }



}
