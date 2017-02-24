<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientInterfaceController extends PageController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reports(Request $request)
    {
        if(!$request->user()->isClient()){
            abort(403, 'Only clients can view this page.');
        }

        $this->validate($request, [
            'date' => 'validDateReportFormat'
        ]);

        return view('clientInterface.reports');
    }

    public function statement(Request $request)
    {
        if(!$request->user()->isClient()){
            abort(403, 'Only clients can view this page.');
        }

        return view('clientInterface.statement');
    }

}
