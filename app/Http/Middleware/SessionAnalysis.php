<?php

namespace App\Http\Middleware;

use App\Session;
use Closure;
use Illuminate\Http\Request;
use ipinfo\ipinfo\IPinfo;
use Illuminate\Support\Str;

class SessionAnalysis
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
        $client = new IPinfo();
        $ip = ($request->ip() == '127.0.0.1') ? NULL : $request->ip();
        $details = $client->getDetails($ip);

        $session = new Session();
        $session->ip = $request->ip();

        if (!isset($_COOKIE['UUID']) || empty($_COOKIE['UUID'])) {
            setcookie('UUID', Str::uuid());
            $session->returning_user =  0;
        } else {
            $session->unique_id = $_COOKIE['UUID'];
            $session->returning_user =  1;
        }

        $session->city =  $details->city;
        $session->region =  $details->region;
        $session->country =  $details->country;
        $session->country_name =  $details->country_name;
        $session->session_start_date = date('Y-m-d');
        $session->timezone = $details->timezone;

        $session->save();
        return $next($request);
    }
}
