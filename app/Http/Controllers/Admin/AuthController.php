<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function form(Request $r)
    {
        return $r->session()->has('admin_id') ? redirect(dura_admin()) : view('admin.login');
    }

    public function login(Request $r)
    {
        $r->validate(['email' => 'required|email', 'password' => 'required']);
        $a = DB::table('admins')->where('email', $r->email)->first();
        if (!$a || !Hash::check($r->password, $a->password)) {
            return back()->withInput($r->only('email'))->withErrors(['email' => 'Invalid email or password.']);
        }
        $r->session()->regenerate();
        $r->session()->put('admin_id', $a->id);
        return redirect(dura_admin());
    }

    public function logout(Request $r)
    {
        $r->session()->forget('admin_id');
        $r->session()->regenerateToken();
        return redirect(dura_admin('login'));
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function profileSave(Request $r)
    {
        $a = $r->attributes->get('admin');
        $r->validate(['name' => 'required|max:100', 'email' => 'required|email|unique:admins,email,' . $a->id, 'password' => 'nullable|min:8|confirmed']);
        $d = ['name' => $r->name, 'email' => $r->email, 'updated_at' => now()];
        if ($r->filled('password')) {
            $d['password'] = Hash::make($r->password);
        }
        DB::table('admins')->where('id', $a->id)->update($d);
        return back()->with('ok', 'Profile updated.');
    }
}
