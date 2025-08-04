<?php
// use Illuminate\Cache\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {
    public function boot()
    {
        $this->configureRateLimiting();
        // $this->routes(function () {
        //     Route::prefix('api')
        //         ->middleware('api')
        //         ->group(base_path('routes/api.php'));
    
        //     Route::middleware('web')
        //         ->group(base_path('routes/web.php'));
        // });
        parent::boot();
    }

    protected function configureRateLimiting() {
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip()); // 5 permintaan/menit/IP
        });

        // Setiap IP hanya boleh mengirim maksimal 150 request per menit.
        // Kalau lebih dari itu, request selanjutnya akan diblokir dengan HTTP 429 Too Many Requests selama sisa waktu window belum habis (1 menit dihitung dari request pertama yang melebihi batas).
        RateLimiter::for('pranker', function (Request $request) {
            return Limit::perMinute(150)->by($request->ip());
        });

        // Default limiter
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });
    }
}