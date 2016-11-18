<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends PageController
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = $this->getUser()->notifications()->paginate(30);
        return view('notifications.index', compact('notifications'));
    }

}
