use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        // Definisikan rate limiter untuk 'login'
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5); // Limit 5 permintaan per menit
        });
        
        // Definisikan rate limiter lainnya jika perlu
        // RateLimiter::for('api', function (Request $request) {
        //     return Limit::perMinute(60);
        // });
    }
}