@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Корзина</h1>

        @if(session('success'))
            <p class="alert alert-success">{{ session('success') }}</p>
        @endif

        @if(empty($cart))
            <p>Корзина пуста.</p>
        @else
            <table class="table">
                <tr>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Общая стоимость</th>
                    <th>Действия</th>
                </tr>
                @foreach($cart as $id => $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['price'] }} €</td>
                        <td>
                            <input type="number" value="{{ $item['quantity'] }}" min="1"
                                   class="quantity-input"
                                   data-id="{{ $id }}">
                        </td>
                        <td class="total-price" data-id="{{ $id }}">
                            {{ $item['price'] * $item['quantity'] }} €
                        </td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>

            <h3>Итого: <span id="cart-total">{{ collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']) }} €</span></h3>

            <a href="{{ route('order.checkout') }}" class="btn btn-success">Оформить заказ</a>
        @endif
    </div>

    <script>
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            let productId = this.dataset.id;
            let newQuantity = this.value;

            fetch(`/cart/update/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity: newQuantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    location.reload(); // Перезагружаем страницу при ошибке
                } else {
                    document.querySelector(`.total-price[data-id="${productId}"]`).textContent = data.total_price + ' €';
                    document.querySelector('#cart-total').textContent = data.cart_total + ' €';
                }
            })
            .catch(error => console.error('Ошибка:', error));
        });
    });
</script>

@endsection
