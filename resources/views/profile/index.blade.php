@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Личный кабинет</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h3>Обновление данных</h3>
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        <label>Имя:</label>
        <input type="text" name="name" value="{{ $user->name }}" required class="form-control">

        <label>Телефон:</label>
        <input type="text" name="phone" value="{{ $user->phone }}" class="form-control">

        <label>Адрес доставки:</label>
        <input type="text" name="address" value="{{ $user->address }}" class="form-control">

        <button type="submit" class="btn btn-primary mt-2">Сохранить</button>
    </form>

    <hr>

    <h3>Смена пароля</h3>
    <form method="POST" action="{{ route('profile.password') }}">
        @csrf
        <label>Текущий пароль:</label>
        <input type="password" name="current_password" required class="form-control">

        <label>Новый пароль:</label>
        <input type="password" name="password" required class="form-control">

        <label>Подтвердите новый пароль:</label>
        <input type="password" name="password_confirmation" required class="form-control">

        <button type="submit" class="btn btn-warning mt-2">Изменить пароль</button>
    </form>

    <hr>

    <h3>История заказов</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Дата</th>
                <th>Сумма</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
    @foreach($orders as $order)
        <tr>
            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
            <td>{{ $order->total_price }} €</td>
            <td>{{ $order->status }}</td>
            <td>
                @if($order->status == 'pending')
                    <form method="POST" action="{{ route('orders.cancel', $order->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Отменить</button>
                    </form>
                @else
                    <span class="text-muted">Отмена невозможна</span>
                @endif
            </td>
        </tr>
    @endforeach
</tbody>
            </table>
</div>
@endsection
