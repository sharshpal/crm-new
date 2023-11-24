<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IpFilter
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

        if(Auth::user()){
            $hostIp = $request->server->get("REMOTE_ADDR");
            $hasFilter = !empty(Auth::user()->ipfilter);
            if($hasFilter){
                $ipList = explode("|",Auth::user()->ipfilter);
                if(!in_array($hostIp,$ipList)){
                    abort(403,"Access Forbidden");
                }
            }
        }


        return $next($request);
    }
}
