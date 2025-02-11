@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Детали заказа #{{ $order->id }}</h1>

    <p><strong>Покупатель:</strong> {{ $order->user->name ?? 'Гость' }}</p>
    <p><strong>Телефон:</strong> {{ $order->phone }}</p>
    <p><strong>Адрес доставки:</strong> {{ $order->address }}</p>
    <p><strong>Сумма заказа:</strong> {{ $order->total_price }} €</p>

    <h3>Товары</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Название</th>
                <th>Цена</th>
                <th>Количество</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->price }} €</td>
                    <td>{{ $item->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Изменение статуса</h3>
    <form action="{{ route('admin.orders.status', $order) }}" method="POST">
        @csrf
        <label>Статус:</label>
        <select name="status">
            <option value="ожидает подтверждения" {{ $order->status == 'ожидает подтверждения' ? 'selected' : '' }}>Ожидает подтверждения</option>
            <option value="в обработке" {{ $order->status == 'в обработке' ? 'selected' : '' }}>В обработке</option>
            <option value="отправлен" {{ $order->status == 'отправлен' ? 'selected' : '' }}>Отправлен</option>
            <option value="доставлен" {{ $order->status == 'доставлен' ? 'selected' : '' }}>Доставлен</option>
            <option value="отменен" {{ $order->status == 'отменен' ? 'selected' : '' }}>Отменен</option>
        </select>
        <button type="submit" class="btn btn-primary">Обновить</button>
    </form>

    <a href="{{ route('admin.orders') }}" class="btn btn-secondary">Назад</a>
</div>

@if(!$order->viewed)
    <form action="{{ route('admin.orders.markViewed', $order) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Пометить как просмотренный</button>
    </form>
@endif

@endsection
