<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,employee'); // Доступ только для админов и сотрудников
    }

    // Отображение всех заказов
    public function index(Request $request)
    {
        $orders = Order::query();
    
        // Фильтр по статусу
        if ($request->filled('status')) {
            $orders->where('status', $request->status);
        }
    
        // Фильтр по способу оплаты
        if ($request->filled('payment_method')) {
            $orders->where('payment_method', $request->payment_method);
        }
    
        // Фильтр по дате (от - до)
        if ($request->filled('date_from')) {
            $orders->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $orders->whereDate('created_at', '<=', $request->date_to);
        }
    
        // Фильтр по пользователю (поиск по имени)
        if ($request->filled('user_name')) {
            $orders->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->user_name . '%');
            });
        }
    
        $orders = $orders->latest()->paginate(10);
    
        return view('admin.orders.index', compact('orders'));
    }
    

    // Просмотр деталей заказа
    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    // Обновление статуса заказа
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:ожидает подтверждения,в обработке,отправлен,доставлен,отменен',
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->route('admin.orders')->with('success', 'Статус заказа обновлен!');
    }

    public function newOrders()
    {
        $orders = Order::where('viewed', false)->latest()->paginate(10);
        return view('admin.orders.new', compact('orders'));
    }

    public function markViewed(Order $order)
    {
        $order->viewed = true;
        $order->save();
    
        return redirect()->route('admin.orders')->with('success', 'Заказ помечен как просмотренный');
    }
    
}
