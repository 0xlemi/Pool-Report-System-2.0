<?php

namespace App\PRS\Classes;

use App\UserRoleCompany;
use Guzzle;
use Storage;
use GuzzleHttp\Psr7\Response;

class SendBird{

    public static function create(UserRoleCompany $urc)
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

    /**
     * Check if this URC is allready registerd in SendBird
     * @return boolean
     */
    public static function exists()
    {
        $response = Guzzle::get(
            'https://api.sendbird.com/v3/users',
            [
                'headers' => [
                    'Api-Token' => env('SENDBIRD_TOKEN')
                ],
                'json' => [
                    "user_ids" =>  json_encode([ $urc->chat_id ]),
                    "show_bot" => false
                ]
            ]
        );
        return count(json_decode($response->getBody()->getContents())->users) > 0;
    }

    public static function get(UserRoleCompany $urc)
    {
        $response = Guzzle::get(
            'https://api.sendbird.com/v3/users/'.$urc->chat_id,
            [
                'headers' => [
                    'Api-Token' => env('SENDBIRD_TOKEN')
                ]
            ]
        );
        if($response->getStatusCode() == 200){
            return json_decode($response->getBody()->getContents());
        }
    }

    public static function update(UserRoleCompany $urc)
    {
        $response = Guzzle::put(
            'https://api.sendbird.com/v3/users/'.$urc->chat_id,
            [
                'headers' => [
                    'Api-Token' => env('SENDBIRD_TOKEN')
                ],
                'json' => [
                    "user_id" =>  $urc->chat_id,
                    "nickname" =>  $urc->chat_nickname,
                    "profile_url" =>  Storage::url($urc->icon()),
                ]
            ]
        );
        if($response->getStatusCode() == 200){
            return json_decode($response->getBody()->getContents());
        }
    }

    public static function unreadMessageCount(UserRoleCompany $urc)
    {
        $response = Guzzle::get(
            'https://api.sendbird.com/v3/users/'.$urc->chat_id.'/unread_count',
            [
                'headers' => [
                    'Api-Token' => env('SENDBIRD_TOKEN')
                ]
            ]
        );
        if($response->getStatusCode() == 200){
            return json_decode($response->getBody()->getContents())->unread_count;
        }
    }

    public static function getAll()
    {
        $response = Guzzle::get(
            'https://api.sendbird.com/v3/users?limit=100',
            [
                'headers' => [
                    'Api-Token' => env('SENDBIRD_TOKEN')
                ]
            ]
        );
        if($response->getStatusCode() == 200){
            return json_decode($response->getBody()->getContents());
        }
    }

    public static function delete($userId)
    {
        $response = Guzzle::delete(
            'https://api.sendbird.com/v3/users/'.$userId,
            [
                'headers' => [
                    'Api-Token' => env('SENDBIRD_TOKEN')
                ]
            ]
        );
        if($response->getStatusCode() == 200){
            return true;
        }
    }

    public static function newToken(UserRoleCompany $urc)
    {
        $response = Guzzle::put(
            'https://api.sendbird.com/v3/users/'.$urc->chat_id,
            [
                'headers' => [
                    'Api-Token' => env('SENDBIRD_TOKEN')
                ],
                'json' => [
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
