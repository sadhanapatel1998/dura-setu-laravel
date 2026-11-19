<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    /** key => [label, type] grouped by tab */
    public static function groups(): array
    {
        return [
            'General' => ['site_name' => ['Site name', 'text'], 'site_url' => ['Site URL (no www, leave empty = auto)', 'text'], 'logo' => ['Logo', 'image']],
            'Contact' => ['phone' => ['Phone (digits with country code, e.g. 919315913702)', 'text'], 'phone_display' => ['Phone (display text)', 'text'], 'email' => ['Public email', 'text'], 'whatsapp_number' => ['WhatsApp number (digits)', 'text'], 'address' => ['Address (HTML allowed)', 'textarea'], 'contact_hours' => ['Working hours text (contact page)', 'text']],
            'SEO' => ['default_title' => ['Default meta title', 'text'], 'default_description' => ['Default meta description', 'textarea'], 'default_keywords' => ['Default meta keywords', 'textarea'], 'default_og_image' => ['Default social image', 'image'], 'robots_txt' => ['robots.txt ({sitemap} = sitemap URL)', 'textarea']],
            'Scripts' => ['header_scripts' => ['Header scripts (inside <head>)', 'code'], 'body_scripts' => ['Body-start scripts (right after <body>)', 'code'], 'footer_scripts' => ['Footer scripts (before </body>)', 'code'], 'custom_css' => ['Custom CSS', 'code']],
            'Mail' => ['mail_host' => ['SMTP host', 'text'], 'mail_port' => ['SMTP port', 'text'], 'mail_encryption' => ['Encryption (tls / ssl / none)', 'text'], 'mail_username' => ['SMTP username', 'text'], 'mail_password' => ['SMTP password', 'password'], 'mail_from_address' => ['From email', 'text'], 'mail_from_name' => ['From name', 'text'], 'lead_notify_email' => ['Send new-lead alerts to', 'text'], 'lead_autoreply' => ['Auto-reply to visitor (1 = on, 0 = off)', 'text'], 'autoreply_subject' => ['Auto-reply subject', 'text'], 'autoreply_body' => ['Auto-reply body ({name} = visitor name)', 'textarea']],
            'Security' => ['turnstile_site_key' => ['Cloudflare Turnstile site key (empty = off)', 'text'], 'turnstile_secret' => ['Cloudflare Turnstile secret key', 'text']],
        ];
    }

    public function index()
    {
        return view('admin.settings', ['groups' => self::groups()]);
    }

    public function save(Request $r)
    {
        $r->validate(['logo_file' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif|max:4096', 'default_og_image_file' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:4096']);
        foreach (self::groups() as $fields) {
            foreach ($fields as $k => [$label, $type]) {
                if (!$r->has($k) && !$r->hasFile($k . '_file')) {
                    continue;
                }
                $v = (string) $r->input($k);
                if ($type === 'image' && ($f = $r->file($k . '_file'))) {
                    $name = bin2hex(random_bytes(6)) . '.' . strtolower($f->getClientOriginalExtension());
                    $f->move(public_path('uploads/' . date('Y/m')), $name);
                    $v = '/uploads/' . date('Y/m') . '/' . $name;
                }
                if ($k === 'site_url') {
                    $v = rtrim(preg_replace('#^(https?://)www\.#i', '$1', trim($v)), '/');
                }
                DB::table('settings')->updateOrInsert(['k' => $k], ['v' => $v]);
            }
        }
        dura_flush_cache();
        return back()->with('ok', 'Settings saved.');
    }

    public function testMail(Request $r)
    {
        $to = trim((string) setting('lead_notify_email', setting('email')));
        $res = Mailer::send($to, 'DuraSetu test mail', '<p>SMTP settings are working.</p>');
        return back()->with($res === true ? 'ok' : 'err', $res === true ? "Test mail sent to $to." : 'Mail failed: ' . $res);
    }
}
