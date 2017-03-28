<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\UserRoleCompany;

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
     * Tells you if this urlSigner is expired
     * @return boolan
     */
    public function expired()
    {
        $first = Carbon::parse($this->expire);
        $second = Carbon::now();
        // if now is later into the futrue than expire means is expired
        // What that means is that expired already happend
        return $first->lt($second);
    }

    /**
     * Get the user with this token
     * @return App\UserRoleCompany
     */
    public function userRoleCompany()
    {
        return $this->belongsTo(UserRoleCompany::class);
    }

}
