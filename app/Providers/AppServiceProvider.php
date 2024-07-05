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
        Gate::define('view-dashboard', function (User $user) {
            return $user->hasAnyRole([
                AppRoles::SUPER_ADMIN,
                AppRoles::ADMIN,
                AppRoles::DEVELOPER]);
        });

        Gate::define('view-pulse', function (User $user) {
            return $user->hasRole(AppRoles::DEVELOPER);
        });

        Gate::define('view-teams', function (User $user) {
            return $user->hasAnyRole([
                AppRoles::SUPER_ADMIN,
                AppRoles::ADMIN,
                AppRoles::DEVELOPER]);
        });
    }
}
