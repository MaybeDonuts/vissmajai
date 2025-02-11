<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

class AdminController extends Controller
{
    // Ограничиваем доступ только для администраторов
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Доступ запрещен');
            }
            return $next($request);
        });
    }

    // Главная страница админ-панели
    public function index()
    {
        $usersCount = User::count();
        $ordersCount = Order::count();
        $productsCount = Product::count();

        return view('admin.dashboard', compact('usersCount', 'ordersCount', 'productsCount'));
    }
}

