<?php


namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Отображение страницы оформления заказа
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'Ваша корзина пуста!');
        }

        return view('orders.checkout', ['cart' => $cart]);
    }

    // Оформление заказа
    public function placeOrder(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Пожалуйста, авторизуйтесь перед оформлением заказа.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|in:наличные,карта,онлайн',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'Корзина пуста!');
        }

        // Создаем заказ
        $order = Order::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_method' => $request->payment_method,
            'total_price' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            'status' => 'pending',
        ]);

        // Добавляем товары из корзины в заказ
        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Очищаем корзину
        session()->forget('cart');

        // Если выбран способ оплаты "онлайн", перенаправляем на страницу оплаты
        if ($request->payment_method === 'онлайн') {
            return redirect()->route('order.payment', ['order_id' => $order->id]);
        }

        return redirect()->route('profile.index')->with('success', 'Ваш заказ успешно оформлен!');
    }

    // Страница оплаты заказа
    public function paymentPage($order_id)
    {
        $order = Order::findOrFail($order_id);

        return view('orders.payment', compact('order'));
    }

    // Отмена заказа
    public function cancel(Order $order)
    {
        // Проверяем, принадлежит ли заказ текущему пользователю
        if ($order->user_id !== auth()->id()) {
            return redirect()->route('profile.index')->with('error', 'Вы не можете отменить этот заказ.');
        }

        // Проверяем, что статус заказа — "pending" (ожидает подтверждения)
        if ($order->status !== 'pending') {
            return redirect()->route('profile.index')->with('error', 'Этот заказ уже обрабатывается.');
        }

        // Проверяем, что прошло меньше 24 часов с момента создания заказа
        $timeRemaining = $order->created_at->addHours(24)->diffInHours(now(), false);
        if ($timeRemaining >= 0) {
            return redirect()->route('profile.index')->with('error', 'Срок отмены заказа истёк.');
        }

        // Обновляем статус заказа
        $order->status = 'отменен';
        $order->save();

        return redirect()->route('orders.history')->with('success', 'Заказ успешно отменен.');
    }

    // Показать список заказов пользователя
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->distinct()->latest()->get();
    
        return view('profile.orders', compact('orders'));
    }
    
}
