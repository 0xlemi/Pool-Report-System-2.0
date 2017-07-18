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
            info("firstOrFail: not passed");
            return false;
        }

        $serviceSeqId = (int) $answers['service']['value'];

        $completed = Carbon::parse($answers['image_1']['timestamp'], $person->company->timezone)->setTimezone('UTC');

        $locationArray = explode(", ", $answers['image_1']['geostamp']);
        $location  = [
            'latitude' => str_replace('lat=', '', $locationArray[0]),
            'longitude' => str_replace('long=', '', $locationArray[1]),
        ];

        $image1 = $answers['image_1']['value'];
        $image2 = $answers['image_2']['value'];
        $image3 = $answers['image_3']['value'];
        $image4 = null;
        if(array_key_exists('image_4', $answers) && array_key_exists('value', $answers['image_4'])){
            $image4 = $answers['image_4']['value'];
        }
        $image5 = null;
        if(array_key_exists('image_5', $answers) && array_key_exists('value', $answers['image_5'])){
            $image5 = $answers['image_5']['value'];
        }

        info($request);

        info([
            $deviceId,
            $serviceSeqId,
            $completed,
            $location,
            $image1,
            $image2,
            $image3,
            $image4,
            $image5
        ]);
    }

}
