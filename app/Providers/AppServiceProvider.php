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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function (User $user) {
            return $user->hasRole(AppRoles::SUPER_ADMIN) ? true : null;
        });

        Gate::define('viewPulse', function (User $user) {
            if ($this->app->environment('production')) {
                return $user->hasRole(AppRoles::DEVELOPER);
            }

            return true;
        });
    }
}
