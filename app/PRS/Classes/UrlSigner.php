<?php

namespace App\PRS\Classes;

use DB;
use App\User;
use Carbon\Carbon;

class UrlSigner{


    public function validateToken(string $token)
    {
        $column  = DB::table('url_signers')->where('token', '=' , $token)->get();
        if($column->count() > 0){
            return $column->first();
        }
        return null;
    }

    public function removeSigner(string $token){
        DB::table('url_signers')->where('token', '=' , $token);
    }

    public function create(User $user, int $daysUntilExpiration){
        $token = str_random(60);

        $this->email = $user->email;
        $this->token = str_random(60);
        $this->expire = Carbon::now()->addDays($daysUntilExpiration);

        if(DB::table('url_signers')->insert([
            'email' => $this->email,
            'token' => $this->token,
            'expire' =>  $this->expire,
        ])){
            return $token;
        }
        return null;
    }


}
