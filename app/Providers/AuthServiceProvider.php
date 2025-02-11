<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Политики приложения.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Регистрация любых аутентификационных / авторизационных сервисов.
     */
    public function boot()
    {
        Gate::define('delete-products', function ($user) {
            return $user->role === 'admin'() || $user->role === 'employee'();
        });
    
        Gate::define('manage-orders', function ($user) {
            return $user->role === 'admin'() || $user->role === 'employee'();
        });

        Gate::define('manage-users', function ($user) {
            dd($user->role); // Временный `dd()` для проверки
            return $user->role === 'admin';
        });
    
        Gate::define('manage-products', function ($user) {
            return $user->role === 'admin'() || $user->role === 'employee'();
        });
    }
}
