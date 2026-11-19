<?php

namespace App\Http\Controllers;

use App\Services\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SiteController extends Controller
{
    public function home()
    {
        $schema = array_filter([dura_faq_schema(dura_get_faqs('home'), 'question', 'answer')]);
        return view('site.index', ['meta' => dura_page_meta('home', ['schema' => $schema])]);
    }

    public function about()
    {
        $schema = array_filter([dura_faq_schema(dura_get_faqs('about'), 'question', 'answer')]);
        return view('site.about', ['meta' => dura_page_meta('about', ['schema' => $schema, 'crumbs' => [['Home', '/'], ['About Us', '/about']]])]);
    }

    public function universities()
    {
        return view('site.universities', ['meta' => dura_page_meta('universities', ['crumbs' => [['Home', '/'], ['Universities', '/universities']]])]);
    }

    public function courses()
    {
        return view('site.courses', ['meta' => dura_page_meta('courses', ['crumbs' => [['Home', '/'], ['Courses', '/courses']]])]);
    }

    public function compare()
    {
        return view('site.compare', ['meta' => dura_page_meta('compare', ['robots' => 'noindex, follow'])]);
    }

    public function blogs()
    {
        return view('site.blogs', ['meta' => dura_page_meta('blogs', ['crumbs' => [['Home', '/'], ['Blogs', '/blogs']]])]);
    }

    public function blog(string $slug)
    {
        $b = DB::table('blogs')->where('slug', $slug)->where('status', 1)->first();
        abort_if(!$b, 404);
        $b = (array) $b;
        $recent = array_map('dura_blog_card', array_map(fn($r) => (array) $r, DB::table('blogs')->where('status', 1)->where('id', '!=', $b['id'])->orderByDesc('published_at')->limit(4)->get()->all()));
        $url = dura_site_url() . '/blog/' . $b['slug'];
        $article = [
            '@context' => 'https://schema.org', '@type' => 'Article',
            'headline' => $b['title'], 'description' => $b['description'],
            'image' => dura_abs(dura_path($b['image'])),
            'datePublished' => date('c', strtotime($b['published_at'] ?: $b['created_at'] ?: 'now')),
            'dateModified' => date('c', strtotime($b['updated_at'] ?: $b['published_at'] ?: 'now')),
            'author' => ['@type' => 'Person', 'name' => $b['author'] ?: setting('site_name')],
            'publisher' => ['@type' => 'Organization', 'name' => setting('site_name'), 'logo' => ['@type' => 'ImageObject', 'url' => dura_abs(setting('logo'))]],
            'mainEntityOfPage' => $url,
        ];
        $meta = dura_meta([
            'title' => $b['meta_title'] ?: $b['title'] . ' | ' . setting('site_name'),
            'description' => $b['meta_description'] ?: $b['description'],
            'keywords' => $b['meta_keywords'], 'og_image' => dura_path($b['image']), 'og_type' => 'article',
            'schema' => [$article], 'crumbs' => [['Home', '/'], ['Blogs', '/blogs'], [$b['title'], '/blog/' . $b['slug']]],
        ]);
        return view('site.blog-show', ['blog' => $b, 'recent' => $recent, 'meta' => $meta]);
    }

    /** Catch-all: university or course page by slug. */
    public function page(string $slug)
    {
        if ($u = dura_rows('SELECT * FROM universities WHERE slug = ? AND status = 1', [$slug])[0] ?? null) {
            $univ = dura_get_university($u['uid']);
            $name = $univ['name'];
            $schema = [[
                '@context' => 'https://schema.org', '@type' => 'CollegeOrUniversity', 'name' => $name,
                'url' => dura_site_url() . '/' . $slug, 'logo' => dura_abs($univ['logo']), 'description' => $univ['hero_desc'],
            ]];
            if ($f = dura_faq_schema($univ['faqs'])) {
                $schema[] = $f;
            }
            $meta = dura_meta([
                'title' => $u['meta_title'] ?: "$name | Courses, Fees & Admission | " . setting('site_name'),
                'description' => $u['meta_description'] ?: $univ['hero_desc'],
                'keywords' => $u['meta_keywords'], 'robots' => $u['robots'], 'og_image' => $u['og_image'] ?: $univ['campus_img'],
                'schema' => $schema, 'crumbs' => [['Home', '/'], ['Universities', '/universities'], [$name, '/' . $slug]],
            ]);
            return view('site.university', compact('univ', 'meta'));
        }
        if ($c = dura_get_course_row_by_slug($slug)) {
            $meta = fn($title, $desc, $extra = []) => dura_meta($extra + [
                'title' => $c['meta_title'] ?: $title . ' | Fees, Eligibility & Admission | ' . setting('site_name'),
                'description' => $c['meta_description'] ?: $desc, 'keywords' => $c['meta_keywords'],
                'robots' => $c['robots'], 'og_image' => $c['og_image'] ?: $c['image'],
                'crumbs' => [['Home', '/'], ['Courses', '/courses'], [$title, '/' . $slug]],
            ]);
            $schema = [[
                '@context' => 'https://schema.org', '@type' => 'Course', 'name' => $c['title'],
                'description' => $c['short_desc'] ?: $c['full_name'],
                'provider' => ['@type' => 'Organization', 'name' => setting('site_name'), 'sameAs' => dura_site_url() . '/'],
            ]];
            if ($course = dura_get_course_detail($c['cid'])) {
                if ($f = dura_faq_schema($course['faqs'] ?? [])) {
                    $schema[] = $f;
                }
                return view('site.course', ['course' => $course, 'meta' => $meta($course['title'] ?: $c['title'], $course['hero_desc'] ?: $c['short_desc'], ['schema' => $schema])]);
            }
            if (view()->exists('site.courses.' . $slug)) {
                return view('site.courses.' . $slug, ['meta' => $meta($c['title'], $c['short_desc'], ['schema' => $schema])]);
            }
        }
        $p = DB::table('pages')->where('page_key', $slug)->first();
        $content = $p ? (json_decode($p->content ?? '', true) ?: []) : [];
        if ($p && !empty($content['custom'])) {
            $meta = dura_page_meta($slug, ['title' => $p->meta_title ?: $p->name . ' | ' . setting('site_name'), 'crumbs' => [['Home', '/'], [$p->name, '/' . $slug]]]);
            return view('site.custom-page', ['title' => $p->name, 'body' => $content['body'] ?? '', 'meta' => $meta]);
        }
        abort(404);
    }

    public function legacy(string $slug)
    {
        return redirect($slug === 'index' ? url('/') : url($slug), 301);
    }

    // ------------------------------------------------------------ contact
    public function contact()
    {
        return view('site.contact', ['meta' => dura_page_meta('contact', ['turnstile' => true, 'crumbs' => [['Home', '/'], ['Contact Us', '/contact']]])]);
    }

    public function contactStore(Request $r)
    {
        $fail = fn(array $errors) => response()->json(['status' => 'error', 'errors' => $errors]);
        if ($r->filled('website_hp')) {
            return $fail(['general' => 'Spam submission detected.']);
        }
        $ts = (int) $r->input('form_ts');
        if ($ts > 0 && time() - $ts < 1) {
            return $fail(['general' => 'Submission too fast. Please take a moment to review your details.']);
        }
        $name = strip_tags(trim((string) $r->input('first-name')));
        $phone = strip_tags(trim((string) $r->input('phone')));
        $email = strip_tags(trim((string) $r->input('email')));
        $subject = strip_tags(trim((string) $r->input('subject')));
        $message = strip_tags(trim((string) $r->input('message')));
        $e = [];

        $len = fn($s) => mb_strlen($s, 'UTF-8');
        if ($name === '') $e['first-name'] = 'Please enter your name.';
        elseif ($len($name) < 2) $e['first-name'] = 'Name must be at least 2 characters.';
        elseif ($len($name) > 50) $e['first-name'] = 'Name must not exceed 50 characters.';
        elseif (!preg_match('/^[a-zA-Z\s.\'-]+$/u', $name)) $e['first-name'] = 'Name can only contain letters, spaces, and hyphens.';

        $digits = preg_replace('/\D/', '', $phone);
        if (strlen($digits) === 12 && substr($digits, 0, 2) === '91') $digits = substr($digits, 2);
        elseif (strlen($digits) === 11 && $digits[0] === '0') $digits = substr($digits, 1);
        if ($phone === '') $e['phone'] = 'Please enter your mobile number.';
        elseif (preg_match('/[a-zA-Z]/', $phone)) $e['phone'] = 'Phone number cannot contain letters.';
        elseif (!preg_match('/^[6-9]\d{9}$/', $digits) || preg_match('/^(\d)\1{9}$/', $digits)) $e['phone'] = 'Please enter a valid 10-digit Indian mobile number starting with 6, 7, 8, or 9.';
        else $phone = $digits;

        if ($email === '') $e['email'] = 'Please enter your email address.';
        elseif ($len($email) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strpos($email, '..') !== false) $e['email'] = 'Please enter a valid email address.';

        if ($len($message) < 10) $e['message'] = 'Message must contain at least 10 characters.';
        elseif ($len($message) > 1000) $e['message'] = 'Message must not exceed 1000 characters.';
        if ($len($subject) > 100) $e['subject'] = 'Subject must not exceed 100 characters.';

        if (!$e && ($secret = setting('turnstile_secret'))) {
            $token = (string) $r->input('cf-turnstile-response');
            if ($token === '') {
                $e['general'] = 'Please complete the security verification.';
            } else {
                try {
                    $ok = Http::asForm()->timeout(10)->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', ['secret' => $secret, 'response' => $token, 'remoteip' => $r->ip()])->json('success');
                } catch (\Throwable $ex) {
                    $ok = false;
                }
                if (!$ok) $e['general'] = 'Security verification failed. Please try again.';
            }
        }
        if ($e) {
            return $fail($e);
        }

        $lead = ['name' => $name, 'phone' => $phone, 'email' => $email, 'subject' => $subject, 'message' => $message,
            'source_url' => substr((string) $r->headers->get('referer', $r->fullUrl()), 0, 255), 'ip' => $r->ip(),
            'user_agent' => substr((string) $r->userAgent(), 0, 255), 'status' => 'new', 'created_at' => now(), 'updated_at' => now()];
        DB::table('leads')->insert($lead);
        Mailer::leadMails($lead);

        $wa = "Hello DuraSetu,\n\n*New Website Enquiry*\n\nName: $name\nPhone: $phone\nEmail: $email\nSubject: $subject\nMessage: $message";
        $url = 'https://wa.me/' . setting('whatsapp_number', setting('phone')) . '?text=' . rawurlencode($wa);
        if ($r->ajax() || $r->input('is_ajax') || $r->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Enquiry verified successfully!', 'whatsapp_url' => $url]);
        }
        return redirect()->away($url);
    }

    // ------------------------------------------------------------ sitemap / robots
    public function sitemap()
    {
        $base = dura_site_url();
        $urls = [[$base . '/', null, '1.0']];
        $pages = DB::table('pages')->whereIn('page_key', ['about', 'universities', 'courses', 'blogs', 'contact'])->where('robots', 'not like', '%noindex%')->get();
        foreach ($pages as $p) {
            $urls[] = [$base . '/' . $p->page_key, $p->updated_at, '0.8'];
        }
        foreach (DB::table('pages')->where('content', 'like', '%"custom"%')->where('robots', 'not like', '%noindex%')->get() as $p) {
            $urls[] = [$base . '/' . $p->page_key, $p->updated_at, '0.6'];
        }
        foreach (['universities' => 'slug', 'courses' => 'slug'] as $t => $col) {
            foreach (DB::table($t)->where('status', 1)->where('robots', 'not like', '%noindex%')->orderBy('sort_order')->get([$col, 'updated_at']) as $r) {
                $urls[] = [$base . '/' . $r->slug, $r->updated_at, '0.8'];
            }
        }
        foreach (DB::table('blogs')->where('status', 1)->orderByDesc('published_at')->get(['slug', 'updated_at', 'published_at']) as $r) {
            $urls[] = [$base . '/blog/' . $r->slug, $r->updated_at ?: $r->published_at, '0.7'];
        }
        $x = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as [$loc, $mod, $pri]) {
            $x .= "  <url>\n    <loc>" . htmlspecialchars($loc, ENT_XML1) . "</loc>\n"
                . ($mod ? '    <lastmod>' . date('Y-m-d', strtotime($mod)) . "</lastmod>\n" : '')
                . "    <changefreq>weekly</changefreq>\n    <priority>$pri</priority>\n  </url>\n";
        }
        return response($x . '</urlset>', 200, ['Content-Type' => 'application/xml; charset=utf-8']);
    }

    public function robots()
    {
        $t = (string) setting('robots_txt', "User-agent: *\nAllow: /\nSitemap: {sitemap}");
        return response(str_replace('{sitemap}', dura_site_url() . '/sitemap.xml', $t), 200, ['Content-Type' => 'text/plain; charset=utf-8']);
    }
}
