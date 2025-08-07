<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DetectSqlInjection {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $patterns = [
            '/\bUNION\b/i',
            '/\bSELECT\b/i',
            '/\bINSERT\b/i',
            '/\bUPDATE\b/i',
            '/\bDELETE\b/i',
            '/\bDROP\b/i',
            '/\b--\b/i',
            '/\bOR\b\s+\d+=\d+/i',
            '/\bAND\b\s+\d+=\d+/i',
            '/\bSLEEP\s*\(/i',
            '/CHR\s*\(/i'
        ];

        $data = array_merge($request->all(), $request->query());

        foreach ($data as $key => $value) {
            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $value)) {
                    $ip = $request->ip();
                    $route = $request->path();
                    $timestamp = date('Y-m-d H:i:s');

                    $log = [
                        'time'      => $timestamp,
                        'ip'        => $request->ip(),
                        'url'       => $request->fullUrl(),
                        'method'    => $request->method(),
                        'input_key' => $key,
                        'input_val' => $value,
                        'content'   => $request->all(),
                        'agent'     => $request->userAgent(),
                    ];

                    // Log file
                    // Simpan log ke file (misalnya dalam /storage/app/private/injection_logs)
                    $filename = 'sql_injection_'.date('Ymd_His').'.json';
                    Storage::disk('sql_injection')->put("{$filename}", json_encode($log, JSON_PRETTY_PRINT));

                    // WhatsApp notification
                    $this->sendWhatsappAlert($ip, $route, $value, $timestamp, $log);

                    // Laravel Firewall: ban this IP
                    $this->blockIpViaFirewall($ip);

                    // Fail2ban log
                    Log::channel('fail2ban')->error("Blocked IP $ip for SQLi attempt on $route");
                    abort(403, 'Forbidden – Suspicious activity detected.');
                }
            }
        }
        return $next($request);
    }

    protected function sendWhatsappAlert($ip, $route, $payload, $timestamp, $message) {
        $adminPhone = env('ADMIN_PHONE_NUMBER'); // Format: 62xxxx
        $message = "🚨 SQL Injection Detected!\n\nIP: $ip\nRoute: $route\nPayload: $payload\nTime: $timestamp\n\nDetails: ".json_encode($message, JSON_PRETTY_PRINT);

        $whatsappApiUrl = env('WHATSAPP_API_URL').'?phone='.$adminPhone;
        $apiKey = env('WHATSAPP_API_KEY');

        Http::post($whatsappApiUrl, [
            'to' => $adminPhone,
            'message' => $message,
            'api_key' => $apiKey,
        ]);
    }

    protected function blockIpViaFirewall($ip) {
        if (function_exists('firewall')) {
            firewall()->blacklist($ip);
        }
    }
}
