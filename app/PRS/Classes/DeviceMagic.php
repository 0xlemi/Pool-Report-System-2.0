<?php

namespace App\PRS\Classes;

use Guzzle;
use Uuid;
use Excel;
use Storage;
use App\PRS\Classes\Logged;
use App\Company;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;

class DeviceMagic{

    public function createForm()
    {
           $response = Guzzle::post(
            'https://api.sendbird.com/v3/users',
            [
                'headers' => [
                    'Api-Token' => env('SENDBIRD_TOKEN')
                ],
                'json' => [
                    "user_id" =>  $urc->chat_id,
                    "nickname" =>  $urc->chat_nickname,
                    "profile_url" =>  Storage::url($urc->icon()),
                    "issue_access_token" => true
                ]
            ]
        );
        if($response->getStatusCode() == 200){
            $object = json_decode($response->getBody()->getContents());
            $urc->chat_token = $object->access_token;
            $urc->save();
            return $object;
        }

    }


}
