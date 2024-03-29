<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\PRS\Classes\SendBird;

class ChatController extends PageController
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

    public function unreadCount($seqId)
    {
        try {
            $urc = $this->loggedCompany()->userRoleCompanies()->bySeqId($seqId);
        } catch (ModelNotFoundException $e) {
            return response([
                'error' => 'There is no user with that id.',
            ], 400);
        }

        $count = SendBird::unreadMessageCount($urc);
        return response([
            'data' => $count
        ]);
    }

    public function userChatId($seqId)
    {
        try {
            $urc = $this->loggedCompany()->userRoleCompanies()->bySeqId($seqId);
        } catch (ModelNotFoundException $e) {
            return response([
                'error' => 'There is no user with that id.',
            ], 400);
        }

        return response([
            'chat_id' => $urc->chat_id,
        ]);
    }

}
