@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Товары со скидками</h1>

    @if($products->isEmpty())
        <p>Сейчас нет товаров со скидками.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Категория</th>
                    <th>Старая цена</th>
                    <th>Новая цена</th>
                    <th>Скидка</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? 'Без категории' }}</td>
                        <td><del>{{ $product->price }} €</del></td>
                        <td class="text-danger">{{ $product->discounted_price }} €</td>
                        <td>-{{ $product->discount }}%</td>
                        <td>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">В корзину</button>
                            </form>
                        </td>
                        <td>
    @if($product->discount > 0 && 
        (is_null($product->discount_start) || $product->discount_start <= now()) && 
        (is_null($product->discount_end) || $product->discount_end >= now()))
        <span class="text-danger">
            {{ number_format($product->price * (1 - $product->discount / 100), 2) }} €
        </span>
        <small class="text-muted"><del>{{ number_format($product->price, 2) }} €</del></small>
    @else
        {{ number_format($product->price, 2) }} €
    @endif
</td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $products->links() }}
    @endif
</div>

@endsection
