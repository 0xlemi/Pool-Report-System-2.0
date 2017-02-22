<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\PRS\Classes\Logged;

class CheckActive
{
    /**
     * Verefy that the user is active (was payed for)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = (new Logged)->user();

        if(!$user->active){
            return response([
                'message' => 'You cannot login because this user is set to inactive. Ask the system administrator to activate your account.'
            ], 402);
        }

        return $next($request);
    }
}
