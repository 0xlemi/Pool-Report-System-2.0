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

class Group {

    protected $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    // public function addDevice(Company $company, string $deviceId)
    // {
    //     if($groupId = $this->getId($company)){
    //
    //     }
    //     return null;
    // }

    /**
     * Add Company Group to Device Magic and store the group_id in database
     * @param Company $company
     */
    public function create()
    {
        $org_id = config('services.devicemagic.organization_id');
        $auth = 'Basic '.config('services.devicemagic.token');
        $companyName = str_replace(" ", "_", $this->company->name);
        $groupName = "PRS-{$companyName}-{$this->company->id}";
        $response =  Guzzle::post(
            "https://www.devicemagic.com/organizations/{$org_id}/groups",
            [
                'headers' => [
                    'Authorization' => $auth,
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    $groupName
                ]
            ]
        );

        if($response->getStatusCode() == 201){
            $groupId = $this->getId($this->company);
            $this->company->group_id = $groupId;
            $this->company->save();
            return true;
        }elseif($response->getStatusCode() == 304){
            // Group with that name already exists
            $groupId = $this->getId($this->company);
            $this->company->group_id = $groupId;
            $this->company->save();
            return true;
        }

        return false;
    }

    /**
     * Get the Group Id from the GroupName
     * @param  string $groupName
     * @return integer           Group ID
     */
    protected function getId()
    {
        $groups = $this->listResponse();

        $groupName = "PRS-{$this->company->name}-{$this->company->id}";
        $neededGroup = array_filter(
            $groups,
            function ($e) use ($groupName) {
                return $e->name == $groupName;
            }
        );
        if(empty($neededGroup)){
            return null;
        }
        return array_shift($neededGroup)->id;

    }

    /**
     * Get the list of all Groups in device magice
     * @return array       An array of objects
     */
    protected function listResponse()
    {
        $org_id = config('services.devicemagic.organization_id');
        $auth = 'Basic '.config('services.devicemagic.token');
        $response = Guzzle::get(
            "https://www.devicemagic.com/organizations/{$org_id}/groups.json",
            [
                'headers' => [
                    'Authorization' => $auth,
                ],
            ]
        );

        return json_decode($response->getBody()->getContents())->groups;
    }


}
