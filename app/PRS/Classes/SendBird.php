<?php

namespace App\PRS\Classes;

use App\UserRoleCompany;
use Guzzle;
use Storage;
use GuzzleHttp\Psr7\Response;

class SendBird{

    protected $urc;

    public function __construct(UserRoleCompany $urc)
    {
        $this->urc = $urc;
    }

    public function create()
    {
        $response = Guzzle::post(
            'https://api.sendbird.com/v3/users',
            [
                'headers' => [
                    'Api-Token' => env('SENDBIRD_TOKEN')
                ],
                'json' => [
                    "user_id" =>  $this->urc->chat_id,
                    "nickname" =>  $this->urc->chat_nickname,
                    "profile_url" =>  Storage::url($this->urc->icon()),
                    "issue_access_token" => true
                ]
            ]
        );
        $object = $this->getResponseObject($response);
        $this->urc->chat_token = $object->access_token;
        $this->urc->save();
        return $object;
    }

    /**
     * Check if this URC is allready registerd in SendBird
     * @return boolean
     */
    public function exists(){
        $response = Guzzle::get(
            'https://api.sendbird.com/v3/users',
            [
                'headers' => [
                    'Api-Token' => env('SENDBIRD_TOKEN')
                ],
                'json' => [
                    "user_ids" =>  json_encode([ $this->urc->chat_id ]),
                    "show_bot" => false
                ]
            ]
        );
        return count($this->getResponseObject($response)->users) > 0;
    }

    public function get()
    {
        $response = Guzzle::get(
            'https://api.sendbird.com/v3/users/'.$this->urc->chat_id,
            [
                'headers' => [
                    'Api-Token' => env('SENDBIRD_TOKEN')
                ]
            ]
        );
        return $this->getResponseObject($response);
    }

    public function update($refreshToken)
    {
        $response = Guzzle::put(
            'https://api.sendbird.com/v3/users/'.$this->urc->chat_id,
            [
                'headers' => [
                    'Api-Token' => env('SENDBIRD_TOKEN')
                ],
                'json' => [
                    "user_id" =>  $this->urc->chat_id,
                    "nickname" =>  $this->urc->chat_nickname,
                    "profile_url" =>  Storage::url($this->urc->icon()),
                ]
            ]
        );
        return $this->getResponseObject($response);
    }

    public function newToken()
    {
        $response = Guzzle::put(
            'https://api.sendbird.com/v3/users/'.$this->urc->chat_id,
            [
                'headers' => [
                    'Api-Token' => env('SENDBIRD_TOKEN')
                ],
                'json' => [
                    "issue_access_token" => true
                ]
            ]
        );
        $object = $this->getResponseObject($response);
        $this->urc->chat_token = $object->access_token;
        $this->urc->save();
        return $object;
    }

    protected function getResponseObject(Response $response)
    {
        if($response->getStatusCode() == 200){
            return json_decode($response->getBody()->getContents());
        }
    }

}
