<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PRS\Classes\Logged;
use App\PRS\Classes\DeviceMagic\Form;
use App\PRS\Classes\DeviceMagic\Group;
use App\PRS\Classes\DeviceMagic\Resource;
use App\PRS\Classes\DeviceMagic\Destination;

class DeviceMagicController extends Controller
{
    public function forms(Request $request)
    {
        info($request);
    }

    public function destination(Destination $destination)
    {
        $company = Logged::company();
        return $destination->create($company);
    }

    public function form(Form $form)
    {
        $company = Logged::company();
        return $form->updateReport($company);
    }

    public function group(Group $group)
    {
        $company = Logged::company();
        $group->create($company);
    }

    public function resource(Resource $resource)
    {
        $company = Logged::company();
        $resource->updateServicesList($company);
    }

}
