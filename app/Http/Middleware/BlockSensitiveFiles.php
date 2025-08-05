<?php
// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockSensitiveFiles {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $forbidden = [
            '.env',
            '.env.example',
            '.env.vault',
            '.env.local',
            '.env.testing',
            '.env.production',
            '.env.development',
            '.env.key',
            '.gitignore',
            '.git',
            'composer.json',
            'composer.lock',
            'package.json',
            'package-lock.json',
            'artisan',
            '.htaccess',
            'pgp-key.txt',
            '.env.backup',
            'tailwindcss.exe',
            'tailwind.config.js',
            'webpack.config.js',
            'jsconfing.json',
            'tsconfig.json',
            'vite.config.js',
            'scan.ps1',
            '.rnd',
            'urls.txt'
        ];

        foreach ($forbidden as $file) {
            if ($request->is($file)) {
                abort(403, 'Access Denied');
            }
        }

        return $next($request);
    }
}
