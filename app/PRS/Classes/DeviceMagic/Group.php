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

    public function addForm(Company $company, int $formId)
    {
        if($groupId = $this->getId($company)){

        }
        return null;

    }

    public function addDevice(Company $company, string $deviceId)
    {
        if($groupId = $this->getId($company)){

        }
        return null;

    }

    /**
     * Add Company Group to Device Magic and store the group_id in database
     * @param Company $company
     */
    public function create(Company $company)
    {
        $org_id = config('services.devicemagic.organization_id');
        $auth = 'Basic '.config('services.devicemagic.token');
        $groupName = "PRS-{$company->name}-{$company->id}";
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
            $groupId = $this->getId($company);
            $company->group_id = $groupId;
            $company->save();
            return true;
        }elseif($response->getStatusCode() == 304){
            // Group with that name already exists
            $groupId = $this->getId($groupName);
            $company->group_id = $groupId;
            $company->save();
            return true;
        }

        return false;
    }

    /**
     * Get the Group Id from the GroupName
     * @param  string $groupName
     * @return integer           Group ID
     */
    protected function getId(Company $company)
    {
        $groups = $this->listResponse();

        $groupName = "PRS-{$company->name}-{$company->id}";
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
