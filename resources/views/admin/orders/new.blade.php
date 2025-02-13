@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Новые заказы</h1>
    @if($orders->isEmpty())
        <p>Нет новых заказов.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Дата</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->status }}</td>
                        <td><a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info">Подробнее</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
