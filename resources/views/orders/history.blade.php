@extends('layouts.app')

@section('content')
    <h1>Мои заказы</h1>

    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif

    @if($orders->isEmpty())
        <p>У вас пока нет заказов.</p>
    @else
        <table class="table">
            <tr>
                <th>Дата заказа</th>
                <th>Общая сумма</th>
                <th>Статус</th>
            </tr>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                    <td>{{ $order->total_price }} €</td>
                    <td>В обработке</td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection
