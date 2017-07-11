<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PRS\Classes\Logged;
use App\PRS\Classes\DeviceMagic\Form;
use App\PRS\Classes\DeviceMagic\Group;

class DeviceMagicController extends Controller
{
    public function forms(Request $request)
    {
        info($request);

    }

    public function form(Form $form)
    {
        $company = Logged::company();
        return (string) $form->add($company);
    }

    public function group(Group $group)
    {
        $company = Logged::company();
        $group->create($company);    
    }

}
