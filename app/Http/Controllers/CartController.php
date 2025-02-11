<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Добавление товара в корзину
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++; // Увеличиваем количество
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Товар добавлен в корзину!');
    }

    // Просмотр корзины
    public function showCart()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Удаление товара из корзины
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.show')->with('success', 'Товар удален из корзины!');
    }

    // Очистка корзины
    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('cart.show')->with('success', 'Корзина очищена!');
    }

    public function updateQuantity(Request $request, $id)
    {
        $cart = session()->get('cart', []);
    
        if (!isset($cart[$id])) {
            return response()->json(['error' => 'Товар не найден в корзине'], 404);
        }
    
        $product = \App\Models\Product::findOrFail($id);
    
        $newQuantity = $request->quantity;
    
        if ($newQuantity < 1) {
            return response()->json(['error' => 'Количество не может быть меньше 1'], 400);
        }
    
        if ($newQuantity > $product->stock) {
            return response()->json(['error' => 'На складе доступно только ' . $product->stock . ' единиц'], 400);
        }
    
        $cart[$id]['quantity'] = $newQuantity;
        session()->put('cart', $cart);
    
        return response()->json([
            'success' => 'Количество обновлено',
            'total_price' => $cart[$id]['quantity'] * $cart[$id]['price'],
            'cart_total' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
        ]);
    }
    
    
}
