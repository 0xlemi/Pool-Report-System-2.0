<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ChatController extends Controller
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
     * Chat home to send messages.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('chat.home');
    }

}
