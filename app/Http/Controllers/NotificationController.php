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
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications()->paginate(30);
        return view('notifications.index', compact('notifications'));
    }

    public function widget(Request $request)
    {
        $notifications = $request->user()
                                ->notifications()
                                ->take(4)
                                ->get()
                                ->transform(function($item){
                                    return (object) array_merge(
                                            (array) $item->data,
                                            ['read' => ($item->read_at) ? true : false]
                                        );
                                });

        return response()->json($notifications);
    }

}
