<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PRS\Classes\Logged;
use App\PRS\Classes\DeviceMagic\Group;

class DeviceMagicController extends Controller
{
    public function forms(Request $request)
    {
        info($request);

    }

    public function group(Group $deviceMagicGroup)
    {
        $company = Logged::company();

        return (string)$deviceMagicGroup->create($company);

    }

}
