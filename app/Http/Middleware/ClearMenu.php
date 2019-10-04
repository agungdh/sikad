<?php

namespace App\Http\Middleware;

use ADHhelper;

use Closure;
use Illuminate\Support\Facades\Route;

use Session;

class ClearMenu
{
    public function handle($request, Closure $next)
    {
    	Session::forget('activeMenu'); 

        return $next($request);
    }
}
