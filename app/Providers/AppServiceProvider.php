<?php

namespace App\Providers;

use App\Authorization\AppRoles;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function (User $user) {
            return $user->hasRole(AppRoles::SUPER_ADMIN) ? true : null;
        });

        Gate::define('view-dashboard', function (User $user) {
            return $user->hasAnyRole([AppRoles::SUPER_ADMIN, AppRoles::ADMIN]);
        });

        Gate::define('viewPulse', function (User $user) {
            if ($this->app->environment('production')) {
                return $user->hasRole(AppRoles::DEVELOPER);
            }

            return true;
        });
    }
}
