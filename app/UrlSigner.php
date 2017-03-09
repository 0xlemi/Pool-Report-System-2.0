<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrlSigner extends Model
{
    protected $fillable = [
                'token',
                'expire'
            ];

    public function getRouteKeyName()
    {
        return 'token';
    }
    
    /**
     * Get the user with this token
     * @return App\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
