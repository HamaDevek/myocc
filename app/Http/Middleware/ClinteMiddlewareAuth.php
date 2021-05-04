<?php

namespace App\Http\Middleware;

use Closure;
use  \App\AccountTable;
class ClinteMiddlewareAuth
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
        if (session()->exists('user')) {
            AccountTable::where('a_ID',session()->get('user'))->where('a_state',1)->firstOrFail();
            return $next($request);
        }else{
            return \redirect()->route('login.show');;
         }
    }
}
