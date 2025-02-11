@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Мои заказы</h1>

    @if($orders->isEmpty())
        <p>У вас пока нет заказов.</p>
    @else
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
            <td>{{ $order->created_at }}</td>
            <td>{{ $order->total_price }}</td>
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
    @endif
</div>
@endsection
