<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JavaScript;

use App\Http\Requests;

class TodaysRouteController extends Controller
{

    public function index()
    {
        $default_table_url = url('datatables/todaysroute');

        JavaScript::put([
            // 'click_url' => url('todaysroute/report/').'/',
        ]);

        return view('todaysroute.index', compact('default_table_url'));
    }

}
