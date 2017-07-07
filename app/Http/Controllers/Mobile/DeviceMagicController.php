<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PRS\Classes\Logged;
use App\PRS\Classes\DeviceMagic\Resource;

class DeviceMagicController extends Controller
{
    public function forms(Request $request)
    {
        info($request);

    }

    public function resource(Resource $deviceMagicResource)
    {
        $company = Logged::company();

        return $deviceMagicResource->updateServicesList($company);

    }

}
