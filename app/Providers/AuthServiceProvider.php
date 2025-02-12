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
        Gate::define('manage-users', function ($user) {
            return $user->role === 'admin'; // Только админ управляет пользователями
        });
    
        Gate::define('manage-products', function ($user) {
            return in_array($user->role, ['admin', 'employee']); // Админ и сотрудник могут редактировать товары
        });
    
        Gate::define('delete-products', function ($user) {
            return in_array($user->role, ['admin', 'employee']); // Теперь сотрудник тоже может удалять
        });
    
        Gate::define('manage-orders', function ($user) {
            return in_array($user->role, ['admin', 'employee']); // Админ и сотрудник управляют заказами
        });
    }
    
}





