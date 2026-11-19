<?php
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CrudController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

// ---------------- Admin
Route::prefix('admin')->group(function () {
    Route::get('login', [AuthController::class, 'form']);
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:10,1');

    Route::middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('profile', [AuthController::class, 'profileSave']);

        Route::post('editor-upload', function (\Illuminate\Http\Request $r) {
            $v = \Illuminate\Support\Facades\Validator::make($r->all(), ['file' => 'required|file|mimes:jpg,jpeg,png,webp,gif|max:4096']);
            if ($v->fails()) {
                return response()->json(['error' => $v->errors()->first()], 422);
            }
            $dir = 'uploads/' . date('Y/m');
            $name = \Illuminate\Support\Str::random(12) . '.' . strtolower($r->file('file')->getClientOriginalExtension());
            try {
                $r->file('file')->move(public_path($dir), $name);
            } catch (\Throwable $e) {
                return response()->json(['error' => 'Could not save file (folder permission?)'], 500);
            }
            // asset() adds the /public/ prefix (ASSET_URL), same as every other image on the site
            return response()->json(['location' => asset("$dir/$name")]);
        });
        Route::post('clear-cache', function () {
            \Illuminate\Support\Facades\Artisan::call('optimize:clear');
            return back()->with('ok', 'Cache cleared successfully.');
        });

        Route::get('leads', [LeadController::class, 'index']);
        Route::get('leads/export', [LeadController::class, 'export']);
        Route::get('leads/{id}', [LeadController::class, 'show'])->whereNumber('id');
        Route::post('leads/{id}', [LeadController::class, 'update'])->whereNumber('id');
        Route::post('leads/{id}/delete', [LeadController::class, 'destroy'])->whereNumber('id');

        Route::get('settings', [SettingController::class, 'index']);
        Route::post('settings', [SettingController::class, 'save']);
        Route::post('settings/test-mail', [SettingController::class, 'testMail']);

        $res = 'sliders|universities|courses|blogs|testimonials|faqs|pages';
        Route::get('{res}', [CrudController::class, 'index'])->where('res', $res);
        Route::get('{res}/create', [CrudController::class, 'create'])->where('res', $res);
        Route::post('{res}', [CrudController::class, 'store'])->where('res', $res);
        Route::get('{res}/{id}/edit', [CrudController::class, 'edit'])->where('res', $res)->whereNumber('id');
        Route::post('{res}/{id}', [CrudController::class, 'update'])->where('res', $res)->whereNumber('id');
        Route::post('{res}/{id}/delete', [CrudController::class, 'destroy'])->where('res', $res)->whereNumber('id');
    });
});

// ---------------- Public
Route::get('/sitemap.xml', [SiteController::class, 'sitemap']);
Route::get('/robots.txt', [SiteController::class, 'robots']);
Route::get('/', [SiteController::class, 'home']);
Route::get('/about', [SiteController::class, 'about']);
Route::get('/universities', [SiteController::class, 'universities']);
Route::get('/courses', [SiteController::class, 'courses']);
Route::get('/compare', [SiteController::class, 'compare']);
Route::get('/blogs', [SiteController::class, 'blogs']);
Route::get('/blog/{slug}', [SiteController::class, 'blog']);
Route::get('/contact', [SiteController::class, 'contact']);
Route::post('/contact', [SiteController::class, 'contactStore'])->middleware('throttle:15,1');

// old *.php URLs -> clean URLs (301)
Route::get('/{slug}.php', [SiteController::class, 'legacy'])->where('slug', '[A-Za-z0-9_-]+');
// university / course pages
Route::get('/{slug}', [SiteController::class, 'page'])->where('slug', '[A-Za-z0-9_-]+');