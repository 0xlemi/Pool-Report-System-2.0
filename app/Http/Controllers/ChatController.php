<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\PRS\Classes\SendBird;

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
        $urc = auth()->user()->selectedUser;


        // $sendBird = new SendBird($urc);

        // dd(SendBird::createUser($urc));
        // dd($sendBird->newToken());
        // dd($sendBird->checkIfUserExists());
        return view('chat.home');
    }

}
