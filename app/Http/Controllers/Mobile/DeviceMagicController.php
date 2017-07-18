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
use App\UserRoleCompany;
use App\Jobs\DeviceMagic\CreateGroup;
use App\Jobs\DeviceMagic\CreateOrUpdateForm;
use App\Report;
use App\Notifications\NewReportNotification;
use Carbon\Carbon;

class DeviceMagicController extends Controller
{
    public function forms(Request $request)
    {
        $answers = $request->answers;
        $deviceId = $request->metadata['device_id'];
        try{
            $person = UserRoleCompany::query()->ofRole('sup', 'tech')->where('device_id', $deviceId)->firstOrFail();
        }catch(ModelNotFoundException $e){
            logger()->error('UserRoleCompany Not Found. When crating Report by Device Magic.');
            return response()->json(['error' => 'Person don\'t exists'], 404);
        }

        $company = $person->company;

        $serviceSeqId = (int) $answers['service']['value'];
        try{
            $service = $company->services()->bySeqId($serviceSeqId);
        }catch(ModelNotFoundException $e){
            logger()->error('Service Not Found. When crating Report by Device Magic.');
            return response()->json(['error' => 'Service don\'t exists'], 404);
        }

        $completed = Carbon::parse($answers['image_1']['timestamp'], $company->timezone)->setTimezone('UTC');

        $locationArray = explode(", ", $answers['image_1']['geostamp']);
        $location  = (object)[
            'latitude' => str_replace('lat=', '', $locationArray[0]),
            'longitude' => str_replace('long=', '', $locationArray[1]),
        ];

        Report::flushEventListeners();

        $report = $service->reports()->create([
            'user_role_company_id' => $person->id,
            'completed' => $completed,
            'on_time' => 'onTime',
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
        ]);

        $image1 = $report->addImageFromUrl('temp/'.explode('/temp/', $answers['image_1']['value'])[1]);
        $image2 = $report->addImageFromUrl('temp/'.explode('/temp/', $answers['image_2']['value'])[1]);
        $image3 = $report->addImageFromUrl('temp/'.explode('/temp/', $answers['image_3']['value'])[1]);
        if(array_key_exists('image_4', $answers) && array_key_exists('value', $answers['image_4'])){
            $image4 = $report->addImageFromUrl($answers['image_4']['value']);
        }
        if(array_key_exists('image_5', $answers) && array_key_exists('value', $answers['image_5'])){
            $image5 = $report->addImageFromUrl($answers['image_5']['value']);
        }

        // $people = $person->company->userRoleCompanies()->ofRole('admin', 'supervisor')->get();
        // foreach ($people as $urc){
        //     $urc->notify(new NewReportNotification($report, $person));
        // }
        // foreach ($report->service->userRoleCompanies as $client) {
        //     $client->notify(new NewReportNotification($report, $person));
        // }

        // throw new Exception("Just for Testing", 1);

        info($report->toArray());
    }

    public function form()
    {
        $company = Logged::company();
        $destination = new Destination($company);
        $form = new Form($company, $destination);
        dispatch(new CreateOrUpdateForm($form));
    }

}
