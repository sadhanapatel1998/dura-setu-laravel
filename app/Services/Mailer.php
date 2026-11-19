<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/** Sends mail using SMTP details saved in Admin > Settings > Mail (falls back to .env). */
class Mailer
{
    public static function configure(): void
    {
        $host = trim((string) setting('mail_host'));
        if ($host === '') {
            return;
        }
        $enc = strtolower((string) setting('mail_encryption', 'tls'));
        $from = setting('mail_from_address') ?: setting('mail_username') ?: setting('email');
        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp' => [
                'transport' => 'smtp',
                'host' => $host,
                'port' => (int) setting('mail_port', 587),
                'scheme' => $enc === 'ssl' ? 'smtps' : null,
                'username' => setting('mail_username') ?: null,
                'password' => setting('mail_password') ?: null,
                'timeout' => 15,
            ],
            'mail.from' => ['address' => $from, 'name' => setting('mail_from_name', 'DuraSetu')],
        ]);
        Mail::purge('smtp');
    }

    /** Returns true on success, error text on failure. */
    public static function send(string $to, string $subject, string $html, ?string $replyTo = null)
    {
        try {
            self::configure();
            Mail::html($html, function ($m) use ($to, $subject, $replyTo) {
                $m->to($to)->subject($subject);
                if ($replyTo) {
                    $m->replyTo($replyTo);
                }
            });
            return true;
        } catch (\Throwable $e) {
            Log::error('Mail failed: ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    public static function leadMails(array $lead): void
    {
        $e = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
        $notify = trim((string) setting('lead_notify_email', setting('email')));
        if ($notify !== '') {
            $html = '<h3>New website enquiry</h3><table cellpadding="6" border="1" style="border-collapse:collapse">'
                . '<tr><td><b>Name</b></td><td>' . $e($lead['name']) . '</td></tr>'
                . '<tr><td><b>Phone</b></td><td>' . $e($lead['phone']) . '</td></tr>'
                . '<tr><td><b>Email</b></td><td>' . $e($lead['email']) . '</td></tr>'
                . '<tr><td><b>Subject</b></td><td>' . $e($lead['subject']) . '</td></tr>'
                . '<tr><td><b>Message</b></td><td>' . nl2br($e($lead['message'])) . '</td></tr>'
                . '<tr><td><b>Page</b></td><td>' . $e($lead['source_url']) . '</td></tr></table>';
            self::send($notify, 'New enquiry from ' . $lead['name'], $html, $lead['email']);
        }
        if (setting('lead_autoreply', '0') === '1') {
            $body = str_replace('{name}', $lead['name'], (string) setting('autoreply_body'));
            self::send($lead['email'], (string) setting('autoreply_subject', 'Thank you for contacting us'), nl2br($e($body)));
        }
    }
}
