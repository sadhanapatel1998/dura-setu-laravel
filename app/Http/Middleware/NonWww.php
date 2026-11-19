<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/** Always serve the site on the non-www host (301 www -> non-www). */
class NonWww
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();
        if (stripos($host, 'www.') === 0) {
            return redirect()->to($request->getScheme() . '://' . substr($host, 4) . $request->getRequestUri(), 301);
        }
        return $next($request);
    }
}
