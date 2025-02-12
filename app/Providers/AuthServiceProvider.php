<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Gate::define('manage-users', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('manage-products', function ($user) {
            return in_array($user->role, ['admin', 'employee']);
        });

        Gate::define('delete-products', function ($user) {
            return in_array($user->role, ['admin', 'employee']);
        });

        Gate::define('manage-orders', function ($user) {
            return in_array($user->role, ['admin', 'employee']);
        });
    }
}
