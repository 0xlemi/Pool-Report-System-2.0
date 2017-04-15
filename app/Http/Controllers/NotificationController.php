<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class NotificationController extends PageController
{

    protected $paginationNumber = 20;

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
        $notifications = $request->user()->selectedUser
                            ->notifications()
                            ->paginate($this->paginationNumber);

        // mark the notifications as read
        $this->markPageAsRead($request);

        return view('notifications.index', compact('notifications'));
    }

    public function widget(Request $request)
    {
        $userRoleCompany = $request->user()->selectedUser;
        $notifications = $userRoleCompany->notifications()
                                ->take(4)
                                ->get()
                                ->transform(function($item){
                                    return (object) array_merge(
                                            (array) $item->data,
                                            [
                                                'read' => ($item->read_at) ? true : false,
                                                'time' => Carbon::parse($item->created_at)->diffForHumans()
                                            ]
                                        );
                                });

        return response()->json([
            'notifications' => $notifications,
            'unreadCount' => $userRoleCompany->unreadNotifications()->count(),
        ]);
    }

    public function markWidgetAsRead(Request $request)
    {
        $request->user()
            ->selectedUser
            ->notifications()
            ->take(4)
            ->get()
            ->markAsRead();
    }

    public function markAllAsRead(Request $request)
    {
        $request->user()
            ->selectedUser
            ->unreadNotifications
            ->markAsRead();
    }

    protected function markPageAsRead(Request $request)
    {
        $request->user()
            ->selectedUser
            ->notifications()
            ->paginate($this->paginationNumber)
            ->markAsRead();
    }


}
