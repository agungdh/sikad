<?php

namespace App\Http\Middleware;

use Closure;

class MustLoggedIn
{
    public function handle($request, Closure $next, ...$accepts)
    {
		$failRedirectTo = route('main.index');
		$loggedIn = session('login') ?: false;
		
		if ($loggedIn != true) {
			return redirect($failRedirectTo);
		}

        return $next($request);
    }
}
