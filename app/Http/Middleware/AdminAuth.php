<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        $id = $request->session()->get('admin_id');
        $admin = $id ? DB::table('admins')->find($id) : null;
        if (!$admin) {
            $request->session()->forget('admin_id');
            return redirect(dura_admin('login'));
        }
        $request->attributes->set('admin', $admin);
        view()->share('admin', $admin);
        try {
            view()->share('newLeadsCount', DB::table('leads')->where('status', 'new')->count());
        } catch (\Throwable $e) {
            view()->share('newLeadsCount', 0);
        }
        return $next($request);
    }
}
