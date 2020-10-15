<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        error_log('Masuk middleware'.$request->get('access_token'));
        if ($request->has('access_token')) {
            // error_log('Masuk middleware'.$request->get('access_token'));
            // $is_exists = User::where('id' , Auth::guard('api')->id())->exists();
            $request->headers->set('Authorization', 'Bearer ' . $request->get('access_token'));
            // error_log('Masuk middleware'.$request->get('access_token'));
            die(dd($request->headers));
           }
        return $next($request);
    }
}
