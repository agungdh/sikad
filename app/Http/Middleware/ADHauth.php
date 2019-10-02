<?php

namespace App\Http\Middleware;

use ADHhelper;

use Closure;
use Illuminate\Support\Facades\Route;

class ADHauth
{
    public function handle($request, Closure $next, ...$accepts)
    {
		$failRedirectTo = route('main.index');
		$currentRoute = Route::currentRouteName();
		$loggedIn = session('login') ?: false;
		
		if ($loggedIn != true) {
			return redirect($failRedirectTo);
		}

        if (!ADHhelper::authCan($currentRoute)) {
            return redirect($failRedirectTo);
        }

        return $next($request);
    }
}
