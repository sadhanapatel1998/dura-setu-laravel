<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $count = fn($t, $w = null) => $w ? DB::table($t)->where(...$w)->count() : DB::table($t)->count();
        return view('admin.dashboard', [
            'stats' => [
                'new_leads' => $count('leads', ['status', 'new']),
                'total_leads' => $count('leads'),
                'contacted_leads' => $count('leads', ['status', 'contacted']),
                'converted_leads' => $count('leads', ['status', 'converted']),
                'universities' => $count('universities'),
                'courses' => $count('courses'),
                'blogs' => $count('blogs'),
                'testimonials' => $count('testimonials'),
                'sliders' => $count('sliders'),
                'faqs' => $count('faqs'),
            ],
            'latest_leads' => DB::table('leads')->orderByDesc('id')->limit(6)->get(),
            'recent_universities' => DB::table('universities')->orderByDesc('id')->limit(5)->get(['id', 'name', 'slug', 'logo', 'status', 'created_at']),
            'recent_courses' => DB::table('courses')->orderByDesc('id')->limit(5)->get(['id', 'title', 'slug', 'level', 'popular', 'status']),
        ]);
    }
}
