@extends('layouts.app')

@section('content')
<div class="container">
    @if(isset($order))
        <h1>Оплата заказа #{{ $order->id }}</h1>
        <p>Сумма к оплате: <strong>{{ $order->total_price }} €</strong></p>
        <p>Оплата пока не подключена, но в реальном магазине здесь была бы форма оплаты.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Вернуться в магазин</a>
    @else
        <h1>Ошибка</h1>
        <p>Заказ не найден.</p>
    @endif
</div>
@endsection
