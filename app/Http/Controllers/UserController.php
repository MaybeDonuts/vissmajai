<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }
    
    public function updateRole(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Вы не можете изменить свою роль.');
        }
    
        $request->validate([
            'role' => 'required|in:user,employee,admin'
        ]);
    
        $user->role = $request->role;
        $user->save();
    
        return redirect()->route('admin.users')->with('success', 'Роль пользователя обновлена.');
    }

    public function block(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Вы не можете заблокировать себя.');
        }
    
        $user->is_blocked = !$user->is_blocked;
        $user->save();
    
        return redirect()->route('admin.users')->with('success', 'Статус пользователя обновлён.');
    }
    
}
