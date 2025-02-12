@extends('layouts.app')

@section('content')

<td>
    @can('manage-orders')
        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary btn-sm">Просмотр</a>
    @endcan

    @can('manage-orders')
        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success btn-sm">Обновить статус</button>
        </form>
    @endcan
</td>


<div class="container">
    <h1>Управление заказами</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

        <form method="GET" action="{{ route('admin.orders') }}" class="mb-3">
        <div class="row">
            <!-- Фильтр по статусу -->
            <div class="col-md-3">
                <label>Статус:</label>
                <select name="status" class="form-control">
                    <option value="">Все</option>
                    <option value="ожидает подтверждения" {{ request('status') == 'ожидает подтверждения' ? 'selected' : '' }}>Ожидает подтверждения</option>
                    <option value="в обработке" {{ request('status') == 'в обработке' ? 'selected' : '' }}>В обработке</option>
                    <option value="отправлен" {{ request('status') == 'отправлен' ? 'selected' : '' }}>Отправлен</option>
                    <option value="доставлен" {{ request('status') == 'доставлен' ? 'selected' : '' }}>Доставлен</option>
                    <option value="отменен" {{ request('status') == 'отменен' ? 'selected' : '' }}>Отменен</option>
                </select>
            </div>

            <!-- Фильтр по способу оплаты -->
            <div class="col-md-3">
                <label>Способ оплаты:</label>
                <select name="payment_method" class="form-control">
                    <option value="">Все</option>
                    <option value="наличные" {{ request('payment_method') == 'наличные' ? 'selected' : '' }}>Наличные</option>
                    <option value="карта" {{ request('payment_method') == 'карта' ? 'selected' : '' }}>Карта</option>
                    <option value="онлайн" {{ request('payment_method') == 'онлайн' ? 'selected' : '' }}>Онлайн</option>
                </select>
            </div>

            <!-- Фильтр по дате -->
            <div class="col-md-3">
                <label>Дата (от):</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <label>Дата (до):</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>

            <!-- Фильтр по пользователю -->
            <div class="col-md-3">
                <label>Пользователь:</label>
                <input type="text" name="user_name" class="form-control" placeholder="Введите имя" value="{{ request('user_name') }}">
            </div>

            <d  iv class="col-md-3 align-self-end">
                <button type="submit" class="btn btn-primary">Фильтровать</button>
                <a href="{{ route('admin.orders') }}" class="btn btn-secondary">Сбросить</a>
            </div>
        </div>
    </form>


    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Покупатель</th>
                <th>Сумма</th>
                <th>Статус</th>
                <th>Оплата</th>
                <th>Дата</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name ?? 'Гость' }}</td>
                <td>{{ $order->total_price }} €</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->payment_method }}</td>
                <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info btn-sm">Подробнее</a>
                </td>
            </tr>
            @endforeach
        </tbody>
        
    </table>

    {{ $orders->links() }}
</div>
@endsection
