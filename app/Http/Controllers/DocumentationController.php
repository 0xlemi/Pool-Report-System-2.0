<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentationController extends Controller
{

    public function index()
    {
        return redirect(url('docs/quick'));
    }

    public function quick()
    {
        return view('docs.quick');
    }

    public function user()
    {
        return view('docs.user');
    }

    public function company()
    {
        return view('docs.company');
    }

    public function service()
    {
        return view('docs.service');
    }

    public function report()
    {
        return view('docs.report');
    }

    public function todaysRoute()
    {
        return view('docs.todaysroute');
    }

    public function workOrder()
    {
        return view('docs.workorder');
    }

    public function invoice()
    {
        return view('docs.invoice');
    }

    public function chat()
    {
        return view('docs.chat');
    }

    public function setting()
    {
        return view('docs.setting');
    }


}
