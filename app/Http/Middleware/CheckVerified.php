<?php

namespace App\Http\Middleware;

use Closure;
use App\PRS\Classes\Logged;

class CheckVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = (new Logged)->user();

        if(!$user->activated){
            return response([
                'message' => 'You cannot login because your email has not been verified.',
                'resend_email' => 'Make post request: '.url('api/v1/activate/resend'),
            ], 402);
        }

        return $next($request);
    }
}
