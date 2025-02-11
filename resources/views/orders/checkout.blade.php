@extends('layouts.app')

@section('content')
    <h1>Оформление заказа</h1>

    <form action="{{ route('order.place') }}" method="POST">
        @csrf

        <label>Имя:</label>
        <input type="text" name="name" required>

        <label>Телефон:</label>
        <input type="text" name="phone" required>

        <label>Адрес доставки:</label>
        <input type="text" name="address" required>

        <label>Способ оплаты:</label>
        <select name="payment_method" required>
            <option value="наличные">Наличные</option>
            <option value="карта">Банковская карта</option>
            <option value="онлайн">Онлайн-оплата</option>
        </select>


        <h2>Ваш заказ</h2>
        <table class="table">
            <tr>
                <th>Название</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Общая стоимость</th>
            </tr>
            @foreach($cart as $id => $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['price'] }} €</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ $item['price'] * $item['quantity'] }} €</td>
                </tr>
            @endforeach
        </table>

        <button type="submit" class="btn btn-success">Подтвердить заказ</button>
    </form>
@endsection
