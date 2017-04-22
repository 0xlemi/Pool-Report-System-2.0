<?php

namespace App\PRS\Classes;

use App\UserRoleCompany;
use Guzzle;
use Storage;

class SendBird{

    static function createUser(UserRoleCompany $urc)
    {
        return Guzzle::post(
            'https://api.sendbird.com/v3/users',
            [
                'headers' => config('services.sendbird'),
                'form_params' => [
                    "user_id" =>  $urc->chat_id,
                    "nickname" =>  $urc->chat_nickname,
                    "profile_url" =>  Storage::url($urc->icon()),
                    "issue_access_token" => true
                ]
            ]
        );
    }

}
