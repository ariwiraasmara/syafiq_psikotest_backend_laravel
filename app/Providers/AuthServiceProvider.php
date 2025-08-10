<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Providers;

// use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider {

    protected $policies = [
        User::class => UserPolicy::class,
        // Add other model-policy mappings here
    ];

    /**
     * Register services.
     */
    public function register(): void {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {
        //
        $this->registerPolicies();
        Passport::enablePasswordGrant();
        // Tambahkan ini untuk menyimpan kunci di storage/
        Passport::loadKeysFrom(storage_path('oauth'));
        Gate::define('is-auth', [UserPolicy::class, 'isAuth']);
        Gate::define('is-super-admin', [UserPolicy::class, 'isSuperAdmin']);
        Gate::define('is-admin', [UserPolicy::class, 'isAdmin']);
    }
}
