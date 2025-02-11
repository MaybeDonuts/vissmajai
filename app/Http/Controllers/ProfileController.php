<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()->latest()->get(); // Загружаем заказы
    
        return view('profile.index', compact('user', 'orders'));
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('profile.index')->with('success', 'Данные обновлены!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('profile.index')->with('error', 'Текущий пароль неверный.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.index')->with('success', 'Пароль успешно изменен!');
    }
}
