<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\PRS\Classes\Logged;
use App\PRS\Classes\DeviceMagic\Form;
use App\PRS\Classes\DeviceMagic\Group;
use App\PRS\Classes\DeviceMagic\Device;
use App\PRS\Classes\DeviceMagic\Destination;
use App\PRS\Helpers\ReportHelpers;
use App\UserRoleCompany;
use App\Jobs\DeviceMagic\CreateGroup;
use App\Jobs\DeviceMagic\CreateOrUpdateForm;
use App\Report;
use App\Notifications\NewReportNotification;
use Carbon\Carbon;
use Psy\Exception\Exception;

class DeviceMagicController extends Controller
{
    public function report(Request $request, ReportHelpers $helper)
    {
        $answers = $request->answers;
        $deviceId = $request->metadata['device_id'];

        $person = $this->getPerson($deviceId);

        $company = $person->company;

        $serviceSeqId = (int) $answers['service']['value'];
        $service = $this->getService($serviceSeqId, $company);

        $completed = Carbon::parse($request->metadata['submitted_at'], $company->timezone);

        $location = (object)[
            'latitude' => null,
            'longitude' => null,
        ];
        if(array_key_exists("geostamp" ,$answers['image_1'])){
            $locationArray = explode(", ", $answers['image_1']['geostamp']);
            $location->latitude = str_replace('lat=', '', $locationArray[0]);
            $location->longitude = str_replace('lat=', '', $locationArray[0]);
        }

        $onTime = 'onTime';
        if($service->hasServiceContract()){
            $onTime = $helper->checkOnTimeValue(
                // ****** check the timezone for check on time
                    $completed,
                    $service->serviceContract->start_time,
                    $service->serviceContract->end_time,
                    $company->timezone
                );
        }

        Report::flushEventListeners();

        $report = $service->reports()->create([
            'user_role_company_id' => $person->id,
            'completed' => $completed->setTimezone('UTC'),
            'on_time' => $onTime,
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
        ]);

        $image1 = $report->addImageFromUrl('temp/'.explode('/temp/', $answers['image_1']['value'])[1]);
        $image2 = $report->addImageFromUrl('temp/'.explode('/temp/', $answers['image_2']['value'])[1]);
        $image3 = $report->addImageFromUrl('temp/'.explode('/temp/', $answers['image_3']['value'])[1]);
        if(array_key_exists('image_4', $answers) && array_key_exists('value', $answers['image_4'])){
            $image4 = $report->addImageFromUrl('temp/'.explode('/temp/', $answers['image_4']['value'])[1]);
        }
        if(array_key_exists('image_5', $answers) && array_key_exists('value', $answers['image_5'])){
            $image5 = $report->addImageFromUrl('temp/'.explode('/temp/', $answers['image_5']['value'])[1]);
        }


        $people = $person->company->userRoleCompanies()->ofRole('admin', 'supervisor')->get();
        foreach ($people as $urc){
            $urc->notify(new NewReportNotification($report, $person));
        }
        foreach ($report->service->userRoleCompanies as $client) {
            $client->notify(new NewReportNotification($report, $person));
        }

        return response()->json(['message' => 'Report Created Successfully']);
    }

    public function workorder(Request $request)
    {
        // info($request);
        $answers = $request->answers;
        $deviceId = $request->metadata['device_id'];

        $person = $this->getPerson($deviceId);

        $company = $person->company;

        $serviceSeqId = (int) $answers['service']['value'];
        $service = $this->getService($serviceSeqId, $company);

        $completed = Carbon::parse($request->metadata['submitted_at'], $company->timezone);

        
    }

    protected function getPerson($deviceId)
    {
        try{
            return UserRoleCompany::query()->paid(true)->ofRole('sup', 'tech')->where('device_id', $deviceId)->firstOrFail();
        }catch(ModelNotFoundException $e){
            logger()->error('UserRoleCompany Not Found. When crating Report by Device Magic.');
            throw new Exception("Invalid Device Id. UserRoleCompany Not Found.");
        }
    }

    protected function getService($serviceSeqId, $company)
    {
        try{
            return $company->services()->bySeqId($serviceSeqId);
        }catch(ModelNotFoundException $e){
            logger()->error('Service Not Found. When crating Report by Device Magic.');
            throw new Exception("Invalid Service Id. Service not Found.");
        }
    }


}
