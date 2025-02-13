<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Нужно, чтобы Laravel загружал role при авторизации
    ];
    
    protected $casts = [
        'role' => 'string', // Принудительно загружаем role как строку
    ];
    
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isEmployee()
    {
        return $this->role === 'employee';
    }
    
    public function isUser()
    {
        return $this->role === 'user';
    }
    
    public function isGuest()
    {
        return $this->role === 'guest';
    }

    public function getRoleAttribute($value)
{
    return $value ?? 'user'; // Если role не загружена, возвращаем 'user'
}
public function orders()
{
    return $this->hasMany(Order::class);
}

}
